/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
//import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './routes.js';
import store from './store/store.js';

window.Vue = require('vue');
Vue.use(VueRouter);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
            next({
                name: 'Login'
            })
        } else {
            next();
        }
    } else {
        next();
    }
})

Vue.component('site-app', require('./views/Site.vue').default);

const app = new Vue({
    el: '#app',
    store,
    router
});