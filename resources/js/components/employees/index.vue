<template>
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card">
                <div class="card-body text-end">
                    <router-link :to='{name:"createEmployeeView"}' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</router-link>
        
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        First Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Last Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Company
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody v-if="employees.data && employees.data.length > 0">
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700" v-for="(employee,key) in employees.data" :key="key">
                                    <td class="px-6 py-4">
                                        {{ (employee.first_name ? employee.first_name : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (employee.last_name ? employee.last_name : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (employee.email ? employee.email : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (employee.phone ? employee.phone : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (employee.company.name ? employee.company.name : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <router-link :to="{name:'editEmployeeView', params:{id: employee.id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</router-link>
                                        |
                                        <router-link to='#' v-on:click="deleteEmployee(employee.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</router-link>
                                    </td>
                                </tr>
                            </tbody>
                            
                            <tbody v-else>
                                <tr>
                                    <td colspan="5" align="center" class="pt-2 pb-2">No employee available.</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center pt-2 pb-2">
                            <TailwindPagination :data="employees" @pagination-change-page="getEmployees"></TailwindPagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    import { TailwindPagination } from 'laravel-vue-pagination';
    
    export default {
        name:"employees",
        components:{
            TailwindPagination
        },
        data(){
            return {
                employees:{
                    type:Object,
                    default:null
                }
            }
        },
        mounted(){
            this.getEmployees(),
            activateCurrentNavRouter()
        },
        methods:{
            async getEmployees(page=1){
                await axios.get(`/api/employees?page=${page}`).then(({data}) => {
                    this.employees = data;
                }).catch(({ response }) => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.response.data.errors !== undefined) {
                        var errors = response.response.data.errors;

                        $.each(errors, function(index, value) {
                            $.each(value, function(indes, message) {
                                flashMessage('error', message);
                            });
                        });
                    } else {
                        var message = 'Something went wrong while fetching employees';

                        flashMessage('error', message);
                    }
                });
            },
            deleteEmployee(id){
                if(confirm("Are you sure to delete this employee ?")){
                    axios.delete(`/api/employees/${id}`).then(response => {
                        $('#flash-message').html('');

                        // Generating flash message
                        flashMessage(response.data.status, response.data.message);
                        
                        this.getEmployees();
                    }).catch(response => {
                        $('#flash-message').html('');

                        // Generating flash message
                        if (response.response.data.errors !== undefined) {
                            var errors = response.response.data.errors;

                            $.each(errors, function(index, value) {
                                $.each(value, function(indes, message) {
                                    flashMessage('error', message);
                                });
                            });
                        } else {
                            var message = 'Something went wrong while deleting employee';

                            flashMessage('error', message);
                        }
                    })
                }
            }
        }
    }
</script>