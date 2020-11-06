<template>
    <div class="container-fluid">
        <div class="mt-4 card mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    Danh sách sản phẩm
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="productTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Ảnh</th>
                                <th>Danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, idx) in products" :key="idx">
                                <td>{{ idx + 1 }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.quantity }}</td>
                                <td><img width="100px" height="100px" v-bind:src="'/' + product.image"></td>
                                <td>
                                    <span v-if="product.category.parent != null"> {{product.category.parent.label}} > </span>
                                    {{ product.category.label }}
                                </td>
                                <td>
                                    <router-link :to="{name: 'Product', params: {id: product.id}}" title="Sửa" class="btn btn-sm btn-success"><i class="fa fa-pencil" aria-hidden="true"></i></router-link>
                                    <button v-on:click="deleteProduct(product)" title="Xóa" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
import Vue from 'vue'
import ProductVue from '../../site/views/Product.vue';
export default Vue.extend({
    data() {
        return {
            products: []
        }
    },
    created() {
        this.$store.dispatch('getProducts').then(res => {
            this.products = this.$store.getters.products;
        });
    },
    mounted() {
        
    },
    methods: {
        deleteProduct(product) {
            if (confirm('Hãy cân nhắc kỹ trước khi xóa. Bạn có muốn tiếp tục?')) {
                this.$store.dispatch('deleteProduct', product.id).then(res => {
                    this.flashMessage.show({
                        status: 'success',
                        message: res.data.message,
                        time: 5000
                    });
                    this.products = this.products.filter(elem => elem.id != product.id);
                }).catch(err => {
                    this.flashMessage.show({
                        status: 'error',
                        message: err.response.data.message,
                        time: 5000
                    });
                })
            }
        }
    }
})
</script>

<style scoped>
    #productTable th, td {
        vertical-align: middle;
    }
</style>