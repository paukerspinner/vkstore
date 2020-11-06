<template>
    <div class="container-fluid">
        <div class="row mt-4 ">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            Danh sách thuộc tính
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="productTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Thuộc tính</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attribute in attributes" :key="attribute.id">
                                        <td>{{ attribute.id }}</td>
                                        <td>{{ attribute.label }}</td>
                                        <td>
                                            <button title="Sửa" class="btn sm-btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <button title="Xóa" class="btn sm-btn btn-danger" v-on:click="deleteProductAttribute(attribute.id)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Thêm mới thuộc tính
                        </h5><hr>
                        <form @submit.prevent="addNewProductAttribute">
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input type="text" v-model="newAttribute.label" class="form-control" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    data() {
        return {
            newAttribute: {
                label: ''
            }
        }
    },
    created() {
        this.$store.dispatch('getProductAttributes');
    },
    methods: {
        addNewProductAttribute() {
            this.$store.dispatch('addProductAttribute', this.newAttribute).then(res => {
                this.newAttribute = {
                    label: ''
                }
            });
        },
        deleteProductAttribute(id) {
            this.$store.dispatch('deleteProductAttribute', id);
        }
    },
    computed: {
        attributes() {
            return this.$store.getters.attributes;
        }
    }
})
</script>

<style scoped>
    .sm-btn {
        padding: 0px 3px;
    }
</style>