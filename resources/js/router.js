import { createRouter, createWebHistory } from 'vue-router'

import DashboardIndex from '@/components/DashboardIndex.vue'

import Companies from '@/components/companies/index.vue'
import CreateCompany from '@/components/companies/create.vue'
import EditCompany from '@/components/companies/edit.vue'

import Employees from '@/components/employees/index.vue'
import CreateEmployee from '@/components/employees/create.vue'
import EditEmployee from '@/components/employees/edit.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'dashboardView',
        component: DashboardIndex
    },
    {
        path: '/companies',
        name: 'companiesView',
        component: Companies
    },
    {
        path: '/companies/create',
        name: 'createCompanyView',
        component: CreateCompany
    },
    {
        path: '/companies/:id/edit',
        name: 'editCompanyView',
        component: EditCompany
    },
    {
        path: '/employees',
        name: 'employeesView',
        component: Employees
    },
    {
        path: '/employees/create',
        name: 'createEmployeeView',
        component: CreateEmployee
    },
    {
        path: '/employees/:id/edit',
        name: 'editEmployeeView',
        component: EditEmployee
    },
];
 
export default createRouter({
    history: createWebHistory(),
    routes
})