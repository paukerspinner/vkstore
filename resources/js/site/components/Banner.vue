<template>
    <div class="banner my-set-bg" v-bind:style="{backgroundImage: `url(../img/banner/banner-1.jpg)`}">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="" v-bind:style="{ paddingTop: '125px' }">
                        <div class="banner__item">
                            <div class="banner__text text-center">
                                <span>The Chloe Collection</span>
                                <h1>The Project Jacket</h1>
                                <router-link to="/shop">
                                    Mua sắm ngay
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>