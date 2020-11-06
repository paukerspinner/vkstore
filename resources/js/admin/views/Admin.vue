<template>
    <div>
        <div v-bind:class="{'sb-sidenav-toggled' : !showSidebar}" v-if="isAuthenticated">
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Vk store</a>
                <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#" v-on:click="toggleSidebar"><i class="fa fa-bars"></i></button>
                <!-- Navbar Search-->
                <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
                <!-- Navbar-->
                <ul class="navbar-nav ml-auto ml-md-0">
                    <router-link to="/logout" class="nav-link">Đăng xuất</router-link>
                </ul>
            </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <div class="sb-sidenav-menu-heading">Core</div>
                                <router-link class="nav-link" to="/dashboard">
                                    <div class="sb-nav-link-icon"><i class="fa fa-tachometer" aria-hidden="true"></i></div>
                                    Bảng điều khiển
                                </router-link>

                                <div class="sb-sidenav-menu-heading">Quản lý</div>
                                <a class="nav-link collapsed" href="#" v-on:click="toggleColapsed($event)" for="collapseCategories">
                                    <div class="sb-nav-link-icon"><i class="fa fa-folder-open-o"></i></div>
                                    Danh mục
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseCategories" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <router-link to="/categories" class="nav-link">Tất cả các danh mục</router-link>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" v-on:click="toggleColapsed($event)" for="collapseProducts">
                                    <div class="sb-nav-link-icon"><i class="fa fa-product-hunt"></i></div>
                                    Sản phẩm
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <router-link class="nav-link" to="/products">Tất cả các sản phẩm</router-link>
                                        <router-link class="nav-link" :to="{name: 'Product'}">Thêm sản phẩm</router-link>
                                        <router-link class="nav-link" :to="{name: 'ProductAttributes'}">Thuộc tính sản phẩm</router-link>
                                    </nav>
                                </div>    

                                <a class="nav-link collapsed" href="#" v-on:click="toggleColapsed($event)" for="collapseOrders">
                                    <div class="sb-nav-link-icon"><i class="fa fa-list-ul"></i></div>
                                    Đơn hàng
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseOrders" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <router-link class="nav-link" to="/orders">Tất cả đơn hàng</router-link>
                                    </nav>
                                </div>                            
                            </div>
                        </div>
                        <div class="sb-sidenav-footer">
                            <div class="small">Logged in as:</div>
                            Admin Manager
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content">
                    <main class="container">
                        <router-view />
                    </main>
                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; By Pauker 2020</div>
                                <div>
                                    <a href="#">Privacy Policy</a>
                                    &middot;
                                    <a href="#">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <div v-if="!isAuthenticated">
            <Login />
        </div>
        <FlashMessage position="right bottom"/>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
export default Vue.extend({
    data() {
        return {
            showSidebar: true
        }
    },
    components: {
        'Login': require('../components/Login.vue').default
    },
    beforeMount() {
        this.$store.dispatch('checkAdminToken');
    },
    methods: {
        toggleSidebar() {
            this.showSidebar = !this.showSidebar;
        },
        toggleColapsed($event) {
            document.getElementById($event.currentTarget.attributes.for.nodeValue).classList.toggle('collapse');
            $event.currentTarget.classList.toggle("collapsed");
        }
    },
    computed: {
        isAuthenticated() {
            return this.$store.getters.loggedIn;
        }
    },
})
</script>