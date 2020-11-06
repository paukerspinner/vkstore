require('../bootstrap');
import VueRouter from 'vue-router';
import router from './routes.js';
import store from './js/store.js';
import FlashMessage from '@smartweb/vue-flash-message';

window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(FlashMessage, {
    // This is config
    time: 600000
});

Vue.component('admin-app', require('./views/Admin.vue').default);

const adminapp = new Vue({
    el: '#adminapp',
    store,
    router
});