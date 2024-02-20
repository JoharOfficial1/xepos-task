<template>
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card">
                <div class="card-body text-end">
                    <router-link :to='{name:"createCompanyView"}' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</router-link>
        
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
                                        Logo
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Website
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody v-if="companies.data && companies.data.length > 0">
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700" v-for="(company,key) in companies.data" :key="key">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="rounded-full w-10 h-10" v-bind:src="company.logo" alt="Company Logo" />
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (company.name ? company.name : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (company.email ? company.email : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (company.website ? company.website : 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <router-link :to="{name:'editCompanyView', params:{id: company.id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</router-link>
                                        |
                                        <router-link to='#' v-on:click="deleteCompany(company.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</router-link>
                                    </td>
                                </tr>
                            </tbody>
                            
                            <tbody v-else>
                                <tr>
                                    <td colspan="5" align="center" class="pt-2 pb-2">No company available.</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="text-center pt-2 pb-2">
                            <TailwindPagination :data="companies" @pagination-change-page="getCompanies"></TailwindPagination>
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
        name:"companies",
        components:{
            TailwindPagination
        },
        data(){
            return {
                companies:{
                    type:Object,
                    default:null
                }
            }
        },
        mounted(){
            this.getCompanies(),
            activateCurrentNavRouter()
        },
        methods:{
            async getCompanies(page=1){
                await axios.get(`/api/companies?page=${page}`).then(({data}) => {
                    this.companies = data;
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
                        var message = 'Something went wrong while fetching companies';

                        flashMessage('error', message);
                    }
                });
            },
            deleteCompany(id){
                if(confirm("Are you sure to delete this company ?")){
                    axios.delete(`/api/companies/${id}`).then(response => {
                        $('#flash-message').html('');

                        // Generating flash message
                        flashMessage(response.data.status, response.data.message);

                        this.getCompanies();
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
                            var message = 'Something went wrong while deleting company';

                            flashMessage('error', message);
                        }
                    })
                }
            }
        }
    }
</script>