<template>
    <div class="container-fluid categories">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <h1 class="mt-4"><router-link :to="{ name: 'Categories' }">Danh mục</router-link></h1>
                <ul class="list-tree" v-for="category in categoriesTree" :key="category.id">
                    <tree-category
                        :node="category"
                    />
                </ul>
            </div>
            <div v-if="categoryId == undefined" class="col-lg-8 col-md-8 col-sm-6">
                <div class="card mt-4">
                    <div class="card-header">
                        Thêm mới danh mục
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="addNewCategory">
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input type="text" v-model="newCategory.label" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Danh mục mẹ</label>
                                <select id="inputState" class="form-control" v-model="newCategory.parent_id">
                                    <option value="-1">-- Không có danh mục mẹ --</option>
                                    <option v-for="category in categoriesTree" :key="category.id" v-bind:value="category.id">{{category.label}}</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="categoryId != undefined" class="col-lg-8 col-md-8 col-sm-6">
                <div class="card mt-4">
                    <div class="card-header">
                        Chỉnh sửa danh mục
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="">
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input type="text" v-model="editCategory.label" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Danh mục mẹ</label>
                                <select id="inputState" class="form-control" v-model="editCategory.parentId">
                                    <option value="-1">-- Không có danh mục mẹ --</option>
                                    <option v-for="category in categoriesTree" :key="category.id" v-bind:value="category.id">{{category.label}}</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" v-on:click="updateCategory(categoryId)" class="btn btn-success">Lưu lại</button>
                                <button type="submit" v-on:click="deleteCategory(categoryId)" class="btn btn-danger">Xóa danh mục</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';

export default Vue.extend({
    data() {
        return {
            newCategory: {
                label: '',
                parent_id: -1
            },
            editCategory: {
                label: '',
                parentId: -1
            },
            categoryId: ''
        }
    },
    components: {
        'tree-category': require('./TreeCategory.vue').default
    },
    created() {
        this.$store.dispatch('getCategoriesTree');
        this.categoryId = this.$router.currentRoute.params.id;
        if (this.$router.currentRoute.params.id != undefined) {
            this.getCategory(this.$router.currentRoute.params.id);
        }
    },
    computed: {
        categoriesTree() {
            return this.$store.getters.categoriesTree;
        }
    },
    beforeRouteUpdate(to, from, next) {
        this.categoryId = to.params.id;
        if (to.params.id != undefined) {
            this.getCategory(to.params.id);
        }
        next();
    },
    methods: {
        addNewCategory() {
            this.$store.dispatch('addNewCategory', this.newCategory)
                .then(res => {
                    this.newCategory = {
                        label: '',
                        parent_id: -1
                    }
                });
        },
        getCategory(id) {
            this.$store.dispatch('getCategory', id)
                .then(res => {
                    if (!res.data.id) {
                        this.$router.push({name: 'Categories'});
                    };
                    this.editCategory.label = res.data.label;
                    if (res.data.parent_id != null) {
                        this.editCategory.parentId = res.data.parent_id;
                    } else {
                        this.editCategory.parentId = -1;
                    }
                }).catch(err => {
                    console.log('ERR')
                })
        },
        updateCategory(id) {
            this.$store.dispatch('updateCategory', {
                id,
                categoryData: this.editCategory
            });
        },
        deleteCategory(id) {
            if (window.confirm('Bạn có chắc chắn muốn xoá danh mục này?')) {
                this.$store.dispatch('deleteCategory', id)
                    .then(res => {
                        if (res.data.status == 'fail') {
                            window.alert(res.data.message);
                        } else {
                            this.$router.push({name: "Categories"})
                        }
                    });
            }
        }
    }
})
</script>


<style module>
    .list-tree li{
        list-style-type: none;
    }

    .tree .btn-expand {
        cursor: pointer;
    }
</style>

<style scoped>
    .categories h1 a {
        text-decoration: none;
    }
</style>