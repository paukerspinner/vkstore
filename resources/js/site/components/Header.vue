<template>
    <div>
        <div class="offcanvas-menu-overlay" v-bind:class="{ active: showOffcanvas }"></div>
        <div class="offcanvas-menu-wrapper" v-bind:class="{ active: showOffcanvas }">
            <div class="offcanvas__close" v-on:click="toggleOffcanvas">+</div>
            <ul class="offcanvas__widget" v-on:click="toggleOffcanvas">
                <li><span class="icon_search search-switch"></span></li>
                <li><a><span class="icon_heart_alt"></span></a></li>
                <li v-if="isAuthenticated"><router-link to="/shopcart"><span class="icon_bag_alt"></span>
                    <div v-if="numberProductInShopcart" class="tip">{{ numberProductInShopcart }}</div>
                </router-link></li>
            </ul>
            <div class="offcanvas__logo">
                <router-link to="/"><img src="img/logo.png" alt=""></router-link>
            </div>
            <div id="mobile-menu-wrap" v-on:click="toggleOffcanvas">
                <div class="slicknav_menu">
                    <nav class="slicknav_nav slicknav_hidden" aria-hidden="true" role="menu" style="display: none;">
                        <ul>
                            <li><router-link to="/">Trang chủ</router-link></li>
                            <li><router-link to="/shop">Mua sắm</router-link></li>
                            <li><router-link to="/checkout">Thanh toán</router-link></li>
                            <li><router-link to="/shopcart">Giỏ hàng</router-link></li>
                            <li><router-link to="/my-orders">Đơn hàng</router-link></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div v-if="!isAuthenticated" class="offcanvas__auth" v-on:click="toggleOffcanvas">
                <router-link to="/login">Đăng nhập</router-link>
                <router-link to="/register">Đăng ký</router-link>
            </div>
            <div v-if="isAuthenticated" class="offcanvas__auth" v-on:click="toggleOffcanvas">
                <router-link to="/logout">Đăng xuất</router-link>
            </div>
        </div>
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-2">
                        <div class="header__logo">
                            <a href="#"><img src="img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <nav class="header__menu">
                            <ul>
                                <li><router-link to="/">Trang chủ</router-link></li>
                                <li><router-link to="/shop">Mua sắm</router-link></li>
                                <li><a>Trang</a>
                                    <ul class="dropdown">
                                        <li><router-link to="/checkout">Thanh toán</router-link></li>
                                        <li><router-link to="/shopcart">Giỏ hàng</router-link></li>
                                        <li><router-link to="/my-orders">Đơn hàng</router-link></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3">
                        <div class="header__right">
                            <div v-if="!isAuthenticated" class="header__right__auth">
                                <router-link to="/login">Đăng nhập</router-link>
                                <router-link to="/register">Đăng ký</router-link>
                            </div>
                            <div v-if="isAuthenticated" class="header__right__auth">
                                <router-link to="/logout">Đăng xuất</router-link>
                            </div>
                            <ul v-if="isAuthenticated" class="header__right__widget">
                                <li><span class="icon_search search-switch"></span></li>
                                <li><a><span class="icon_heart_alt"></span></a></li>
                                <li><router-link to="/shopcart"><span class="icon_bag_alt"></span>
                                    <div v-if="numberProductInShopcart" class="tip"> {{ numberProductInShopcart }}</div>
                                </router-link></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="canvas__open" v-on:click="toggleOffcanvas">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </header>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import EventBus from './EventBus.vue';
export default Vue.extend({
    data() {
        return {
            showOffcanvas : false,
            data: ''
        }
    },
    methods: {
        toggleOffcanvas() {
            this.showOffcanvas = !this.showOffcanvas;
        }
    },
    computed: {
        isAuthenticated() {
            return this.$store.getters.loggedIn;
        },
        numberProductInShopcart() {
            if (this.$store.getters.shopcart.products == undefined) {
                return ;
            } else {
                return this.$store.getters.shopcart.products.length;
            }
        }
    }
})
</script>