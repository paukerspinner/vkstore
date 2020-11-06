import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard';
import Products from './components/Products';
import Categories from './components/Categories';
import Login from './components/Login';
import Logout from './components/Logout';
import Product from './components/Product';
import ProductAttributes from './components/ProductAttributes';
import Orders from './components/Orders';
import Order from './components/Order';

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/logout',
            component: Logout
        },
        {
            path: '/dashboard',
            component: Dashboard
        },
        {
            path: '/products',
            component: Products
        },
        {
            path: '/categories/:id?',
            name: 'Categories',
            component: Categories
        },
        {
            path: '/products/create-edit/:id?/',
            name: 'Product',
            component: Product
        },
        {
            path: '/product-attributes',
            name: 'ProductAttributes',
            component: ProductAttributes
        },
        {
            path: '/orders',
            name: 'Orders',
            component: Orders
        },
        {
            path: '/orders/:id',
            name: 'Order',
            component: Order
        }
    ]
})