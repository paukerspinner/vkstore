<template>
    <section class="shop-cart spad">
        <div v-if="products == undefined || products.length == 0" class="container non__product">
            <p>Bạn chưa có sản phẩm nào trong của hàng</p>
            <router-link to="/shop" class="btn btn__redirect">Mua sắm ngay &nbsp;&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i></router-link>
        </div>
        <div class="container" v-if="products != undefined && products.length != 0">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row cart__product" v-for="product in products" :key="product.id">
                        <div class="col-lg-6 col-md-6 col-sm-6 col__img">
                            <img v-bind:src="product.image">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cart__product__item__title">
                                <h6> {{ product.name }}</h6>
                            </div>
                            <div class="cart__price"> {{ product.price }} VNĐ</div>
                            <div class="cart__quantity">
                                <select name="quantity" @change="updateQuantity($event, product.product_id)">
                                    <option v-for="quantity in 10" :key="quantity" v-bind:value="quantity" :selected="quantity == product.quantity">{{ quantity }}</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn__delete" v-on:click="deleteProduct(product.product_id)"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    <div class="cart__btn right__btn">
                        <router-link to="/shop">Tiếp tục mua sắm</router-link>
                    </div>
                </div>
                <div class="col-lg-4">
                    <OrderSummary />
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    components: {
        'OrderSummary': require('../components/OrderSummary.vue').default
    },
    methods: {
        addToCart(productId) {
            this.$store.dispatch('addToCart', productId)
                .then(res => {
                    this.$router.push('/shopcart');
                })
        },
        updateQuantity($event, productId) {
            let quantity = parseInt($event.target.value);
            this.$store.dispatch('updateQuantityProductShopcart', {productId, quantity});
        },
        deleteProduct(productId) {
            this.$store.dispatch('deleteProductShopcart', productId);
        }
    },
    computed: {
        products() {
            return this.$store.getters.shopcart.products;
        }
    }
})
</script>