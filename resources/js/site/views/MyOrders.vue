<template>
    <div class="container mt-4">
        <div v-for="order in myOrders" :key="order.id" class="card mt-4">
            <div class="card-header">
                Order #{{ zerofill(order.id, 6) }}
            </div>
            <div class=" card-body row">
                <div class="col-lg-6 col-md-6 card-body">
                    <h5 class="card-title">Chi tiết</h5>
                    <p class="card-text">Thời gian: <span>{{ date(order.created_at) }}</span></p>
                    <p class="card-text">Trạng thái: <span>{{ formatOrderStatus(order.status) }}</span></p>
                    <p class="card-text">Số điện thoại người nhận: <span>{{ order.ship_phone }}</span></p>
                    <p class="card-text">Địa chỉ: <span>{{ formatAddress(order.ship_city, order.ship_district, order.ship_ward, order.ship_address) }}</span></p>
                </div>
                <div class="col-lg-6 col-md-6 card-body">
                    <h5 class="card-title">Danh sách sản phẩm</h5>
                    <p v-for="product in order.shopcart.products" :key="product.id">
                        {{ product.name }}
                        <span>x {{ product.quantity }}</span>
                        <span>- {{ product.price * product.quantity }} VNĐ</span>
                    </p>
                    <p class="card-text">Tổng tiền: <span>{{ calculatePayment(order.shopcart) }} VNĐ</span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import {CalculatePayment} from '../../utities/calculate';
import {FormatOrderStatus} from '../../utities/string';
export default Vue.extend({
    data() {
        return {
            shopcarts: []
        }
    },
    created() {
        this.$store.dispatch('getMyOrders');
    },
    methods: {
        formatOrderStatus: (statusNum) => FormatOrderStatus(statusNum),
        calculatePayment: (shopcart) => CalculatePayment(shopcart),
        getProductShopcarts: async (shopcartId) => {
            let productShopcart = [];
            await axios.get('/api/v1/shopcart/' + shopcartId + '/product-shopcart')
                .then(res => {
                    productShopcart = res.data;
                })
                .catch(err => {
                    
                });
            return productShopcart;
        },
        zerofill(num, len) {
            num = num + '';
            return num.padStart(len, '0');
        },
        date(timestamp) {
            let time = new Date(timestamp);
            let year = time.getFullYear();
            let mon = time.getMonth() + '';
            let day = time.getDay() + '';
            return day.padStart(2, '0') + '/' + mon.padStart(2, '0') + '/' + year;
        },
        formatAddress(city, district, ward, address) {
            return city + ', ' + district + ', ' + ward + ', ' + address;
        }
    },
    computed: {
        myOrders() {
            let allOrders = this.$store.getters.myOrders;
            allOrders.sort((orderA, orderB) => orderA.id > orderB.id ? -1 : 1);
            return allOrders;
        },
        products() {
            return (shopcartId) => {
                return this.getProductShopcarts(shopcartId);
            }
        }
    }
})
</script>