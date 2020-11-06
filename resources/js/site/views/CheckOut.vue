<template>
    <section class="shop-cart spad">
        <div v-if="products == undefined || products.length == 0" class="container non__product">
            <p>Bạn chưa có sản phẩm nào trong của hàng</p>
            <router-link to="/shop" class="btn btn__redirect">Mua sắm ngay &nbsp;&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i></router-link>
        </div>
        <div class="container" v-if="products != undefined && products.length != 0">
            <div class="row">
                <div class="col-lg-8 checkout__form">
                    <h5>Billing detail</h5>
                    <form @submit.prevent="setOrder">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Họ và tên người nhận hàng <span>*</span></p>
                                    <input required autocomplete="name" type="text" v-model="ship_name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Tỉnh / Thành phố<span>*</span></p>
                                    <input required autocomplete="city" type="text" v-model="ship_city">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Quận / Huyện <span>*</span></p>
                                    <input required autocomplete="district" type="text" v-model="ship_district">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Phường / xã <span>*</span></p>
                                    <input required autocomplete="ward" type="text" v-model="ship_ward">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Địa chỉ cụ thể <span>*</span></p>
                                    <input required autocomplete="address" type="text" v-model="ship_address" placeholder="Nhập tên đường, số nhà...">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Số điện thoại khi nhận hàng <span>*</span></p>
                                    <input required autocomplete="phone" type="text" v-model="ship_phone">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Bạn có muốn nhắn nhủ gì không?</p>
                                    <input type="text" v-model="note">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="site-btn">Xác nhận đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <OrderSummary />
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import Vue from 'vue';
export default Vue.extend({
    components: {
        'OrderSummary': require('../components/OrderSummary.vue').default
    },
    data() {
        return {
            ship_name: '',
            ship_city: '',
            ship_district: '',
            ship_ward: '',
            ship_phone: '',
            ship_address: '',
            note: ''
        }
    },
    created() {
        
    },
    methods: {
        setOrder() {
            let confirmed = confirm('Bạn đã chắc chắn về thông tin đặt hàng?');
            if (confirmed) {
                let dataShip = {
                ship_name: this.ship_name,
                ship_city: this.ship_city,
                ship_district: this.ship_district,
                ship_ward: this.ship_ward,
                ship_phone: this.ship_phone,
                note: this.note,
                ship_address: this.ship_address
                };
                this.$store.dispatch('setOrder', {
                    shopcartId: this.$store.getters.shopcart.id,
                    dataShip: dataShip
                }).then(res => {
                    this.$router.push({name: "MyOrders"});
                });
            }
        }
    },
    computed: {
        products() {
            return this.$store.getters.shopcart.products;
        }
    }
})
</script>