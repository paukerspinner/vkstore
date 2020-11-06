export default {
    retrieveToken(state, token) {
        state.token = token
    },
    destroyToken(state) {
        state.token = null;
        state.profile = {};
        state.filterCategoryId = [];
        state.shopcart = {};
        state.dataShip = {};
        state.myOrders = []
    },
    getCategoryTrees(state, categoryTrees) {
        state.categoryTrees = categoryTrees;
    },
    getProducts(state, products) {
        state.products = products;
    },
    filterByCategory(state, categoryNode) {
        state.filterCategoryId = []
        function getIdInTree(categoryNode) {
            state.filterCategoryId.push(categoryNode.id);
            if (categoryNode.children.length == 0) {
                return;
            } else {
                categoryNode.children.forEach(child => {
                    getIdInTree(child);
                });
            }  
        };
        getIdInTree(categoryNode);
    },
    getShopcart(state, shopcart) {
        state.shopcart = shopcart;
    },
    setDataShip(state, data) {
        state.dataShip = data
    },
    getMyOrders(state, data) {
        state.myOrders = data;
    },
    getProfile(state, data) {
        state.profile = data;
    }
}