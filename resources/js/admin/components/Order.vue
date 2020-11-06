<template>
    <div class="container-fluid mt-4">
        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                         <h5 class="card-title">
                            Chi tiết đơn hàng
                        </h5>
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-middle" witdh="100%">
                                <tbody>
                                    <tr>
                                        <td width="40px"><i title="Ngày đặt hàng" class="fa fa-calendar" aria-hidden="true"></i></td>
                                        <td>{{ formatDate(order.created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <td><i title="Khách hàng" class="fa fa-user-circle-o" aria-hidden="true"></i></td>
                                        <td>{{ order.phoneuser }}</td>
                                    </tr>
                                    <tr>
                                        <td><i title="Trạng thái" class="fa fa-clock-o" aria-hidden="true"></i></td>
                                        <td>{{ formatOrderStatus(order.status) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                         <h5 class="card-title">
                            Thông tin vận chuyển
                        </h5>
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-middle" witdh="100%">
                                <tbody>
                                    <tr>
                                        <td width="40px"><i title="Tên" class="fa fa-id-badge" aria-hidden="true"></i></td>
                                        <td>{{ order.ship_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><i title="Số điện thoại" class="fa fa-phone-square" aria-hidden="true"></i></td>
                                        <td>{{ order.ship_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><i title="Địa chỉ" class="fa fa-address-card-o" aria-hidden="true"></i></td>
                                        <td>{{ formatAddress(order.ship_city, order.ship_district, order.ship_ward, order.ship_address) }}</td>
                                    </tr>
                                    <tr>
                                        <td><i title="Lời nhắn" class="fa fa-sticky-note-o" aria-hidden="true"></i></td>
                                        <td>{{ order.ship_note || 'Không để lại lời nhắn' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Danh sách sản phẩm
                        </h5>
                        <div class="table-responsive mt-4">
                            <table class="table table-hover table-middle text-center">
                                <thead>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Ảnh</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                </thead>
                                <tbody v-if="order.shopcart">
                                    <tr v-for="product in order.shopcart.products" :key="product.product_id">
                                        <td>{{ product.product_id }}</td>
                                        <td>{{ product.name }}</td>
                                        <td><img width="100px" height="100px" v-bind:src="'/' + product.image"></td>
                                        <td>{{ formatCurrency(product.price) }}</td>
                                        <td>{{ product.quantity }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><b>Tổng</b></td>
                                        <td><b>{{ formatCurrency(calculatePayment(order.shopcart)) }}</b></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <button v-if="order.status == -1" class="btn btn-success" v-on:click="updateOrderToActiveStatus">Kích hoạt</button>&nbsp;
            <div v-if="order.status != -1">
                <button class="btn btn-secondary" v-on:click="updateOrderToFailStatus">Hủy bỏ</button>&nbsp;
                <button v-if="order.status" v-on:click="updateOrderBackStatus" class="btn btn-success">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Trở lại
                </button>&nbsp;
                <button v-if="getNextActionOrder(order.status)" v-on:click="updateOrderToNextStatus" class="btn btn-success">
                    {{ getNextActionOrder(order.status) }} <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import {FormatCurrency, FormatOrderStatus, FormatAddress, FormatDate, GetNextActionOrder} from '../../utities/string';
import {CalculatePayment} from '../../utities/calculate';
export default Vue.extend({
    data() {
        return {
            order: {}
        }
    },
    created() {
        this.getOrder();
    },
    methods: {
        formatDate: (timestamp) => FormatDate(timestamp),
        formatOrderStatus: (statusNum) => FormatOrderStatus(statusNum),
        formatCurrency: (currency) => FormatCurrency(currency),
        formatAddress: (city, district, ward, address) => FormatAddress(city, district, ward, address),
        getNextActionOrder: (statusNum) => GetNextActionOrder(statusNum),
        calculatePayment: (shopcart) => CalculatePayment(shopcart),
        updateOrderToNextStatus() {
            this.$store.dispatch('updateOrderStatus', {
                orderId: this.order.id,
                status: this.order.status + 1
            }).then(res => {
                this.order.status += 1;
            });
        },
        updateOrderBackStatus() {
            this.$store.dispatch('updateOrderStatus', {
                orderId: this.order.id,
                status: this.order.status - 1
            }).then(res => {
                this.order.status -= 1;
            });
        },
        updateOrderToFailStatus() {
            this.$store.dispatch('updateOrderStatus', {
                orderId: this.order.id,
                status: -1
            }).then(res => {
                this.order.status = -1;
            });
        },
        updateOrderToActiveStatus() {
            this.$store.dispatch('updateOrderStatus', {
                orderId: this.order.id,
                status: 0
            }).then(res => {
                this.order.status = 0;
            });
        },
        getOrder() {
            let orderId = this.$router.currentRoute.params.id;
            this.$store.dispatch('getOrder', orderId).then(res => {
                this.order = res.data;
            });
        }
    }
})
</script>