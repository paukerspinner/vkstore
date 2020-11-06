<template>
    <div class="container-fluid">
        <div class="mt-4 card mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Danh sách sản phẩm
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="productTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{ order.id }}</td>
                                <td>{{ formatDate(order.created_at) }}</td>
                                <td>{{ formatOrderStatus(order.status) }}</td>
                                <td>{{ order.phoneuser }}</td>
                                <td>{{ formatCurrency(calculatePayment(order.shopcart)) }}</td>
                                <td>
                                    <router-link :to="{name: 'Order', params:{id: order.id}}" class="btn btn-primary"><i class="fa fa-eye" title="Xem chi tiết" aria-hidden="true"></i></router-link>
                                    <button v-on:click="deleteOrder(order)" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import { FormatOrderStatus, FormatDate, FormatCurrency } from '../../utities/string';
import { CalculatePayment } from '../../utities/calculate';
export default Vue.extend({
    data() {
        return {
            orders: []
        }
    },
    mounted() {
        this.$store.dispatch('getOrders').then(res => {
            this.orders = res.data;
        });
    },
    methods: {
        formatOrderStatus: (statusNum) => FormatOrderStatus(statusNum),
        formatDate: (timestamp) => FormatDate(timestamp),
        formatCurrency: (currency) => FormatCurrency(currency),
        calculatePayment: (shopcart) => CalculatePayment(shopcart),
        deleteOrder(order) {
            if (confirm('Hãy cân nhắc kỹ trước khi xóa. Bạn có muốn tiếp tục?')) {
                this.$store.dispatch('deleteOrder', order.id).then(res => {
                    this.orders = this.orders.filter((elem, index) => elem.id != order.id)
                });
            }
        }
    }
})
</script>


<style scoped>
    .btn {
        padding: 0px 3px;
    }
</style>