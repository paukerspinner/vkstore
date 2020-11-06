import VueRouter from 'vue-router';
import NotFound from './components/NotFound.vue';
import Banner from './components/Banner.vue';
import Login from './components/Login';
import Register from './components/Register';
import Profile from './components/Profile';
import Logout from './components/Logout';


import Product from './views/Product';
import CheckOut from './views/CheckOut.vue';
import ShopCart from './views/ShopCart.vue';
import Shop from './views/Shop';
import Home from './views/Home';
import MyOrders from './views/MyOrders';

export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/logout',
            component: Logout
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/profile',
            component: Profile
        },
        {
            path: '/shop',
            component: Shop
        },
        {
            path: '/product/:id',
            name: 'Product',
            component: Product
        },
        {
            path: '/checkout',
            name: 'Checkout',
            component: CheckOut,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/shopcart',
            name: 'Shopcart',
            component: ShopCart,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/my-orders',
            name: 'MyOrders',
            component: MyOrders,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '*',
            component: NotFound
        }
    ]
});