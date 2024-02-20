<template>
    <form @submit.prevent="create">
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" id="name" v-model="company.name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
        </div>
        
        <div class="relative z-0 w-full mb-6 group">
            <input type="email" id="email" v-model="company.email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
        </div>

        <div class="relative z-0 w-full mb-6 group">
            <input type="url" id="website" v-model="company.website" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="website" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Website</label>
        </div>
        
        <div class="relative z-0 w-full mb-6 group">    
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Upload file <span class="mt-1 text-sm text-red-500 dark:text-red-300" id="logo_help">(SVG, PNG, JPG or JPEG.)</span></label>
            <input type="file" id="logo" v-on:change="logoChange" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="logo_help">
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</template>

<script type="application/javascript">
    export default {
        name:"add-company",
        data(){
            return {
                company:{
                    name:"",
                    email:"",
                    website:"",
                    logo:"",
                }
            }
        },
        mounted(){
            activateCurrentNavRouter()
        },
        methods:{
            async create(e){
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };

                await axios.post('/api/companies', this.company, config).then(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.data.status == true) {
                        flashMessage(response.data.status, response.data.message);

                        this.$router.push({name:"companiesView"});
                    } else {
                        flashMessage(response.data.status, response.data.message);
                    }
                }).catch(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.response.data.errors !== undefined) {
                        var errors = response.response.data.errors;

                        $.each(errors, function(index, value) {
                            $.each(value, function(index, message) {
                                flashMessage('error', message);
                            });
                        });
                    } else {
                        var message = 'Something went wrong while creating company';

                        flashMessage('error', message);
                    }
                });
            },
            logoChange(e){
                $('#flash-message').html('');

                var _URL = window.URL || window.webkitURL;
                var logo = e.target.files[0];

                var img = new Image();
                var objectUrl = _URL.createObjectURL(logo);

                // Store a reference to the component (this)
                var vm = this;

                // Checking logo size
                img.onload = function () {
                    if (this.width > 100 || this.height > 100) {
                        var message = 'Please select a logo of size 100x100';
                        $('#logo').val('');

                        vm.company.logo = '';

                        flashMessage('error', message);
                    } else {
                        vm.company.logo = logo;
                    }
                    
                    _URL.revokeObjectURL(objectUrl);
                };
                img.src = objectUrl;
            }
        }
    }
</script>