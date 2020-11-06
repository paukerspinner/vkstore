<template>
    <div class="checkout__order">
        <h5>Giỏ hàng của bạn</h5>
        <div class="checkout__order__product">
            <table class="table borderless">
                <thead class="text__head">
                    <th>Sản phẩm</th>
                    <th class="text-right">Thành tiền</th>
                </thead>
                <tbody v-for="product in products" :key="product.product_id">
                    <tr>
                        <td rowspan="2" class="text__name text-top">{{ product.name }}</td>
                        <td class="text__right">{{ product.price }}x{{ product.quantity}}</td>
                    </tr>
                    <tr>
                        <td class="text__money text__right">{{ product.price * product.quantity }} VNĐ</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="checkout__order__total">
            <ul>
                <li>Total <span>{{ total }} VNĐ</span></li>
            </ul>
        </div>
        <div v-if="router == 'Shopcart'">
            <router-link to="/checkout" class="site-btn">Tiến hành đặt hàng</router-link>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    data() {
        return {
            router: 'non'
        }
    },
    mounted() {
        this.router = this.$router.currentRoute.name;
    },
    computed: {
        products() {
            return this.$store.getters.shopcart.products;
        },
        total() {
            let products = this.products;
            let total = products.reduce((resutlTotal, product) => {
                return resutlTotal += product.price * product.quantity;
            }, 0)
            return total;
        }
    }
})
</script>