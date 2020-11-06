<template>
    <div class="container">
        <div class="row mt-4 .mr-auto">
            <div class="col-lg-8 offset-lg-2">
                <form @submit.prevent="submitForm">
                    <h3 class="text-center">Thêm mới sản phẩm</h3><hr>
                    <div class="form-group row">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" v-model="product.name" class="form-control" required>
                    </div>
                    <div class="form-group row">
                        <label for="price">Giá</label>
                        <input type="number" min="0" max="15000000" v-model="product.price" class="form-control" required>
                    </div>
                    <div class="form-group row">
                        <label for="quantity">Số lượng</label>
                        <input type="number" min="0" max="1000" v-model="product.quantity" class="form-control" required>
                    </div>
                    <div class="form-group row">
                        <label for="category">Danh mục</label>
                        <select id="inputState" class="form-control" v-model="product.categoryId" required>
                            <option value="">-- Danh mục sản phẩm --</option>
                            <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{category.label}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label>Ảnh</label>
                        <input class="col-12" type="file" @change="onFileImageChange" id="image" ref="uploadFileImage" hidden>
                        <div class="col-12">
                            <div class="upload-container">
                                <img v-bind:src="imgUrl" class="img-upload" alt="">
                                <!-- <label for="image" class="btn-upload">Chọn ảnh</label> -->
                                <label for="image" class="overlay"></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="addAttribute">Thuộc tính sản phẩm</label>
                        <select id="inputState" class="form-control col-6 offset-6" @change="handleOnchangeAddAttribute">
                            <option value="">-- Chọn để thêm thuộc tính --</option>
                            <option v-for="attribute in productAttributes" :key="attribute.id" v-bind:value="attribute.id">{{attribute.label}}</option>
                        </select>
                    </div>
                    <div class="form-group row" v-for="attribute in product.attributes" :key="attribute.id">
                        <div class="col-md-6">
                            <a class="btn btn-mini btn-secondary text-right" v-on:click="cancleAttribute(attribute.id)"><i class="fa fa-trash"></i></a>
                            <label>{{getLabelAttributeById(attribute.id)}}</label>
                        </div>
                        <input type="text" class="form-control col-md-6" v-model="attribute.value" required>

                        <div v-if="attributeNumber == 0" class="col-12 text-center mt-4"><small>Không có thuộc tính nào</small></div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="description">Mô tả sản phẩm</label>
                        <input type="text" v-model="product.description" class="form-control">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">
                            {{ product.id ? 'Lưu lại' : 'Thêm mới'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    data() {
        return {
            product: {
                id: null,
                name: '',
                price: null,
                quantity: null,
                categoryId: '',
                image: '',
                description: null,
                attributes: []
            },
            imgUrl: '/img/product/placeholder.jpeg',
            productIdShow: null
        }
    },
    created() {
        if (this.$store.getters.categories.length == 0) {
            this.$store.dispatch('getCategoriesTree');
        }
        if (this.$store.getters.attributes.length == 0) {
            this.$store.dispatch('getProductAttributes');
        }
    },
    mounted() {
        this.product.id = this.$router.currentRoute.params.id;
    },
    beforeRouteUpdate(to, from, next) {
        this.resetData();
        this.product.id = to.params.id;
        next();
    },
    methods: {
        getProduct($id) {
            this.$store.dispatch('getProduct', $id).then(res => {
                this.product.id = res.data.id;
                this.product.name = res.data.name;
                this.product.price = res.data.price;
                this.product.quantity = res.data.quantity;
                this.product.categoryId = res.data.category.id;
                this.imgUrl = '/' + res.data.image;
                
                res.data.varchar_eaves.forEach(element => {
                    this.addAttribute(element.attribute_id, element.value);
                });
            }).catch(err => {
                this.$router.push({name: 'Product'})
            })
        },
        addAttribute(id, value, alert=false) {
            const isUsedAttribute = this.product.attributes.map(elem => elem.id.toString()).includes(id.toString());
            if (!isUsedAttribute) {
                this.product.attributes.push({
                    id: id || null,
                    value: value || null
                });
            } else if(alert == true) {
                this.flashMessage.show({
                    status: 'warning',
                    message: 'Vui lòng kiểm tra lại, thuộc tính này đã được thêm!',
                    time: 5000
                });
            }
        },
        deleteAttribute() {
            this.product.attributes.pop();
        },
        handleOnchangeAddAttribute(event) {
            let idAttribute = event.target.value;
            this.addAttribute(idAttribute, '', true);     // alert = true for presentation alert
            event.target.value = ""
        },
        cancleAttribute(attributeId) {
            this.product.attributes = this.product.attributes.filter(elem => elem.id != attributeId);
        },
        onFileImageChange(e) {
            this.product.image = e.target.files[0];
            this.imgUrl = URL.createObjectURL(this.product.image);
        },
        addNewProduct() {
            let formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('price', this.product.price);
            formData.append('quantity', this.product.quantity);
            formData.append('category_id', this.product.categoryId);
            formData.append('image', this.product.image);
            formData.append('attributes', JSON.stringify(this.product.attributes));
            this.$store.dispatch('addNewProduct', formData).then(res => {
                this.flashMessage.show({
                    status: 'success',
                    message: res.data.message,
                    time: 5000
                });
                this.resetData();
            });
        },
        submitForm() {
            let formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('price', this.product.price);
            formData.append('quantity', this.product.quantity);
            formData.append('category_id', this.product.categoryId);
            formData.append('image', this.product.image);
            formData.append('attributes', JSON.stringify(this.product.attributes));
            if (this.product.id) {
                let data = {
                    formData: formData,
                    id: this.product.id
                }
                this.$store.dispatch('updateProduct', data).then(res => {
                    this.flashMessage.show({
                        status: 'success',
                        message: res.data.message,
                        time: 5000
                    })
                }).catch(err => {
                    this.flashMessage.show({
                        status: 'error',
                        message: err.response.data.message || 'Có lỗi xảy ra, vui lòng thử lại',
                        time: 5000
                    })
                });
            } else {
                this.$store.dispatch('addNewProduct', formData).then(res => {
                    this.flashMessage.show({
                        status: 'success',
                        message: res.data.message,
                        time: 5000
                    });
                    this.resetData();
                }).catch(err => {
                        this.flashMessage.show({
                            status: 'error',
                            message: err.response.data.message || 'Có lỗi xảy ra, vui lòng thử lại',
                            time: 5000
                        })
                });
            }

        },
        getLabelAttributeById(id) {
            let res = '';
            this.productAttributes.forEach(element => {
                if (element.id == parseInt(id)) {
                    res = element.label;
                    return;
                }
            });
            return res;
        },
        resetData() {
            this.product = {
                name: '',
                price: null,
                quantity: null,
                categoryId: '',
                image: '',
                description: null,
                attributes: []
            };
            this.$refs.uploadFileImage.value=null;
            this.imgUrl = '/img/product/placeholder.jpeg'
        }
    },
    computed: {
        productAttributes() {
            return this.$store.getters.attributes;
        },
        attributeNumber() {
            return this.product.attributes.length;
        },
        categories() {
            return this.$store.getters.categories;
        }
    },
    watch: {
        'product.id': function() {
            if (this.product.id) {
                this.getProduct(this.product.id);
            }
        }
    }
})
</script>

<style scoped>
    .btn {
        color: #ffffff;
    }
    .btn:hover {
        color: #fff;
    }
    .img-upload {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    .upload-container {
        position: relative;
        margin: 0 auto;
        width: 200px;
        height: 200px;
    }
    .btn-upload {
        position: absolute;
        display: none;
        width: 100%;
        height: 100%;
        padding-top: 135px;
        margin-left: -200px;
        color: rgb(153, 153, 153);
    }
    .overlay {
        position: absolute;
        cursor: pointer;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        transition: background 0.5s;
    }

    .upload-container:hover .overlay {
        background: rgba(0, 0, 0, 0.5);
    }
    .upload-container:hover .overlay:after {
        position: absolute;
        content: "Chọn ảnh";
        top: 10%;
        width: 100%;
        text-align: center;
        color: rgb(202, 202, 202);
    }
</style>