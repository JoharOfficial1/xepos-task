<template>
    <form @submit.prevent="edit">
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" id="first_name" v-model="employee.first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First Name</label>
        </div>
        
        <div class="relative z-0 w-full mb-6 group">
            <input type="test" id="last_name" v-model="employee.last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "/>
            <label for="last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last Name</label>
        </div>
        
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" id="email" v-model="employee.email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email Address</label>
        </div>

        <div class="relative z-0 w-full mb-6 group">
            <input type="number" id="phone" v-model="employee.phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone</label>
        </div>

        <div class="relative z-0 w-full mb-6 group"><label for="companies" class="sr-only">Underline select</label>
            <select id="companies" v-model="employee.company_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option value="">Select a Company</option>
                <option v-for="(company,key) in companies.data" :key="key" v-bind:value="company.id">{{company.name}}</option>
            </select>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</template>

<script type="application/javascript">
    export default {
        name:"edit-employee",
        data(){
            return {
                employee:{
                    first_name:"",
                    last_name:"",
                    email:"",
                    phone:"",
                    company_id:"",
                },
                companies:[]
            }
        },
        mounted(){
            this.getCompanies(),
            this.getEmployee(),
            activateCurrentNavRouter()
        },
        methods:{
            async getEmployee(e){
                await axios.get(`/api/employees/${this.$route.params.id}`).then(response => {
                    this.employee.first_name = (response.data.first_name ? response.data.first_name : "");
                    this.employee.last_name = (response.data.last_name ? response.data.last_name : "");
                    this.employee.email = (response.data.email ? response.data.email : "");
                    this.employee.phone = (response.data.phone ? response.data.phone : "");
                    this.employee.company_id = (response.data.company_id ? response.data.company_id : "");
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
                        var message = 'Something went wrong while fetching employee';

                        flashMessage('error', message);
                    }
                })
            },
            async edit(e){
                this.employee._method = 'PUT';
                await axios.post(`/api/employees/${this.$route.params.id}`, this.employee).then(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.data.status == true) {
                        flashMessage(response.data.status, response.data.message);
                        
                        this.$router.push({name:"employeesView"});
                    } else {
                        flashMessage(response.data.status, response.data.message);
                    }
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
                        var message = 'Something went wrong while updating employee';

                        flashMessage('error', message);
                    }
                })
            },
            async getCompanies(page='all'){
                await axios.get(`/api/companies?page=${page}`).then(response => {
                    this.companies = response;
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
                        var message = 'Something went wrong while fetching companies';

                        flashMessage('error', message);
                    }
                })
            },
        }
    }
</script>