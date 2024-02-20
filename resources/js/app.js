import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import router from './router';
import axios from 'axios';

import flashmessage from '@/components/Flash.vue';
import DashboardIndex from '@/components/DashboardIndex.vue';

import Companies from '@/components/companies/index.vue';
import CreateCompany from '@/components/companies/create.vue';
import EditCompany from '@/components/companies/edit.vue';

import Employees from '@/components/employees/index.vue';
import CreateEmployee from '@/components/employees/create.vue';
import EditEmployee from '@/components/employees/edit.vue';

createApp({
    components: {
        flashmessage,
    	DashboardIndex,
    	Companies,
        CreateCompany,
        EditCompany,
    	Employees,
        CreateEmployee,
        EditEmployee,
    }
}).use(router).mount('#app')