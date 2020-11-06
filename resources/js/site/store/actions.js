import Axios from "axios";
import { reject } from "lodash";
import store from "./store";
import router from '../routes.js';

export default {
    retrieveToken(context, credentials) {
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/login', {
                phone: credentials.phone,
                password: credentials.password
            })
                .then(response => {
                    const token = response.data.token;
                    localStorage.setItem('token_user', token);
                    context.commit('retrieveToken', token);
                    resolve(response);
                    store.dispatch('getShopcart');
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
        })
    },
    checkUserToken(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/profile')
                .then(response => {
                    context.commit('getProfile', response.data);
                    store.dispatch('getShopcart');
                    resolve(response);
                })
                .catch(error => {
                    localStorage.removeItem('token_user');
                    context.commit('destroyToken');
                    reject(error);
                    console.log("checkUserToken");
                })
        })
    },
    destroyToken(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;

        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                Axios.post('/api/v1/logout')
                    .then(response => {
                        localStorage.removeItem('token_user');
                        context.commit('destroyToken');
                        resolve(response);
                    })
                    .catch(error => {
                        localStorage.removeItem('token_user');
                        context.commit('destroyToken');
                        reject(error);
                    })
            })
        }
    },
    register(context, data) {
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/register', {
                phone: data.phone,
                name: data.name,
                email: data.email,
                password: data.password
            })
            .then(response => {
                resolve(response);
            })
            .catch(error => {
                reject(error);
            })
        })
    },
    getCategoryTrees(context) {
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/categories-tree')
                .then(response => {
                    context.commit('getCategoryTrees', response.data);  // Tham so thu 2 cuar commit
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    getProducts(context) {
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/products')
                .then(response => {
                    context.commit('getProducts', response.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    getProduct(context, product_id) {
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/products/' + product_id)
                .then(res => {
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    filterByCategory(context, categoryId) {
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/subcategory/'+categoryId)
                .then(response => {
                    context.commit('filterByCategory', response.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    getShopcart(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/shopcarts')
                .then(response => {
                    context.commit('getShopcart', response.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    addToCart(context, productId) {
        Axios.defaults.headers.common['Authentication'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/shopcarts/add-to-cart', {
                product_id: productId
            }).then(res => {
                context.dispatch('getShopcart');
                resolve(res);
            }).catch(err => {
                if (err.response.status == 401) {
                    alert("Bạn phải đăng nhập để thực hiện tính năng này.");
                    router.push('/login');
                }
                reject(err);
            })
        })
    },
    updateQuantityProductShopcart(context, data) {
        Axios.defaults.headers.common['Authentication'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/shopcarts/update-quantity-product', {
                product_id: data.productId,
                quantity: data.quantity
            }).then(res => {
                context.dispatch('getShopcart');
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    deleteProductShopcart(context, productId) {
        Axios.defaults.headers.common['Authentication'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/shopcarts/delete-product', {
                product_id: productId,
            }).then(res => {
                context.dispatch('getShopcart');
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    setOrder(context, data) {
        Axios.defaults.headers.common['Authentication'] = 'Bearer' + context.state.token;
        
        return new Promise((resolve, reject) => {
            Axios.post(`/api/v1/myorders`, {
                shopcart_id: data.shopcartId,
                data_ship: data.dataShip
            }).then(res => {
                context.commit('setDataShip', res.data);
                context.dispatch('getShopcart');
                console.log(res.data)
                resolve(res);
            }).catch(err => {
                console.log(err.response)
                reject(err);
            })
        })
    },
    getMyOrders(context) {
        Axios.defaults.headers.common['Authentication'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get(`/api/v1/myorders`)
                .then(res => {
                    context.commit('getMyOrders', res.data);
                    // console.log(res.data)
                    resolve(res);
                })
                .catch(err => {
                    // console.log(err.response)
                    reject(err.response);
                })
        })
    }
}