import { filter } from "lodash";

export default {
    loggedIn(state) {
        return state.token !== null
    },
    filteredProducts(state) {
        return state.products.filter((product) => {
            if (state.filterCategoryId.length == 0) {
                return true;
            } else {
                return state.filterCategoryId.indexOf(product.category_id) != -1;      // notenote
            }
        });
    },
    categoryTrees(state) {
        return state.categoryTrees;
    },
    shopcart(state) {
        return state.shopcart;
    },
    product: (state) => (id) => {
        state.products.forEach(product => {
            console.log(product.id);
            if (product.id == id) {
                return product;
            }
        });
    },
    dataShip(state) {
        return state.dataShip;
    },
    myOrders(state) {
        return state.myOrders
    }
}