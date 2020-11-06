export default {
    retrieveToken(state, token) {
        state.token = token
    },
    destroyToken(state) {
        state.token = null;
    },
    getCategoriesTree(state, data) {
        state.categoriesTree = data;
    },
    getProducts(state, data) {
        state.products = data;
    },
    addNewProduct(state, data) {
        state.products.push(data);
    },
    getProductAttributes(state, data) {
        state.attributes = data;
    }
}