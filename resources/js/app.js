import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';
import { VueReCaptcha } from 'vue-recaptcha-v3';

// Componentes
import ClientList from './components/ClientList.vue';
import ClientForm from './components/ClientForm.vue';
import Login from './components/Login.vue';

// Router
const routes = [
    { path: '/', redirect: '/clients' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/clients', component: ClientList, name: 'clients.index', meta: { requiresAuth: true } },
    { path: '/clients/create', component: ClientForm, name: 'clients.create' },
    { path: '/clients/:id/edit', component: ClientForm, name: 'clients.edit', meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Guards
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('auth_token');

    if (to.meta.requiresAuth && !token) {
        next('/login');
    } else {
        next();
    }
});

// App
const app = createApp({});
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(VueReCaptcha, { siteKey: window.recaptchaSiteKey });

app.mount('#app');
