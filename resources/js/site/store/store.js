import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import getters from './getters';
import mutations from './mutations';
import actions from './actions';

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('token_user') || null,
        categoryTrees: [],
        products: [],
        filterCategoryId: [],
        shopcart: {},
        dataShip: {},
        myOrders: []
    },
    getters,
    mutations,
    actions
})