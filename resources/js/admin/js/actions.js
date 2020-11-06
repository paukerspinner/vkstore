import Axios from 'axios';
import { reject } from 'lodash';
import router from '../routes';
import store from './store';

export default {
    retrieveToken(context, credentials) {
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/adminpage/login', {
                phone: credentials.phone,
                password: credentials.password
            })
                .then(response => {
                    const token = response.data.token;
                    localStorage.setItem('token_user', token);
                    context.commit('retrieveToken', token);
                    resolve(response);
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
        })
    },
    checkAdminToken(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/adminpage/profile')
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    localStorage.removeItem('token_user');
                    context.commit('destroyToken');
                    reject(error);
                    console.log("checkAdminToken");
                })
        })
    },
    destroyToken(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        
        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/adminpage/logout')
                .then(response => {
                    localStorage.removeItem('token_user');
                    context.commit('destroyToken');
                    router.push('/');
                    resolve(response);
                })
                .catch(error => {
                    localStorage.removeItem('token_user');
                    context.commit('destroyToken');
                    router.push('/');
                    reject(error);
                })
        });
    },
    getCategoriesTree(context) {
        return new Promise((resolve, reject) => {
            Axios.get('/api/v1/categories-tree')
                .then(response => {
                    context.commit('getCategoriesTree', response.data);
                    resolve(response);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    addNewCategory(context, data) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;

        return new Promise((resolve, reject) => {
            Axios.post('/api/v1/categories/create', {
                label: data.label,
                parent_id: data.parent_id
            }).then(res => {
                store.dispatch('getCategoriesTree');
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    getCategory(context, id) {
        return new Promise((resolve, reject) => {
            Axios.get(`/api/v1/categories/${id}`)
                .then(res => {
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    updateCategory(context, data) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        let id = data.id;
        return new Promise((resolve, reject) => {
            Axios.put(`/api/v1/categories/${id}`, {
                label: data.categoryData.label,
                parentId: data.categoryData.parentId
            }).then(res => {
                    store.dispatch('getCategoriesTree');
                    console.log(res.data)
                    resolve(res);
                })
                .catch(err => {
                    console.log(err.response)
                    reject(err);
                })
        })
    },
    deleteCategory(context, id) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.delete(`/api/v1/categories/${id}`)
                .then(res => {
                    store.dispatch('getCategoriesTree');
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    getProducts(context) {
        return new Promise((resolve, reject) => {
            Axios.get('api/v1/products')
                .then(res => {
                    context.commit('getProducts', res.data);
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    getProduct(context, productId) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get(`api/v1/products/${productId}`).then(res => {
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    deleteProduct(context, productId) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.delete(`api/v1/products/${productId}`).then(res => {
                resolve(res);
            }).catch(err => {
                console.log(err.response)
                reject(err);
            })
        })
    },
    addNewProduct(context, data) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        Axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
        return new Promise((resolve, reject) => {
            Axios.post('api/v1/products', data).then(res => {
                context.commit('addNewProduct', res.data.newProduct);
                resolve(res);
            }).catch(err => {
                console.log(err.response)
                reject(err);
            })
        })
    },
    updateProduct(context, data) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        Axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
        return new Promise((resolve, reject) => {
            Axios.post(`api/v1/products/${data.id}/update`, data.formData).then(res => {
                resolve(res);
            }).catch(err => {
                console.log(err.response)
                reject(err);
            })
        })
    },
    getProductAttributes(context) {
        return new Promise((resolve, reject) => {
            Axios.get('api/v1/attributes').then(res => {
                context.commit('getProductAttributes', res.data);
                resolve(res);
            }).then(err => {
                reject(err);
            })
        })
    },
    addProductAttribute(context, newAttribute) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.post('api/v1/attributes', newAttribute).then(res => {
                store.dispatch('getProductAttributes');
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    deleteProductAttribute(context, id) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.delete(`api/v1/attributes/${id}`).then(res => {
                if (res.data.status == 'fail') {
                    alert(res.data.message);
                } else {
                    store.dispatch('getProductAttributes');
                }
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    getOrders(context) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get('api/v1/orders').then(res => {
                resolve(res);
            }).catch(err => {
                console.log(err.response)
                reject(err)
            })
        })
    },
    getOrder(context, orderId) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.get(`api/v1/orders/${orderId}`).then(res => {
                resolve(res);
            }).catch(err => {
                reject(err)
            })
        })
    },
    updateOrderStatus(context, data) {
        let orderId = data.orderId;
        let status = data.status;
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.put(`api/v1/orders/${orderId}`, {
                status
            }).then(res => {
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    },
    deleteOrder(context, orderId) {
        Axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token;
        return new Promise((resolve, reject) => {
            Axios.delete(`api/v1/orders/${orderId}`).then(res => {
                resolve(res);
            }).catch(err => {
                reject(err);
            })
        })
    }
}