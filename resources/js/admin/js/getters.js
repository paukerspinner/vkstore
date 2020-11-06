export default {
    loggedIn(state) {
        return state.token !== null
    },
    categoriesTree(state) {
        return state.categoriesTree;
    },
    categories(state) {
        let result = [];
        let extractCategory = (category) => {
            result.push(category);
            if (category.children == null) {
                return;
            } else {
                category.children.forEach(childCategory => {
                    return extractCategory(childCategory);
                });
            }
        };
        state.categoriesTree.forEach(category => {
            extractCategory(category);
        });
        return result;
    },
    products(state) {
        return state.products;
    },
    attributes(state) {
        return state.attributes;
    }
}