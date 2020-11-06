<template>
    <div class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="section-body">
                                <ul v-for="categoryTree in categoryTrees" :key="categoryTree.id">
                                    <tree-view :node="categoryTree" class="root-category"/>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-4 col-md-6" v-for="product in filterProducts" :key="product.id">
                            <div class="product__item">
                                <div class="product__item__pic my-set-bg" v-bind:style="{backgroundImage: `url(../${product.image})`}" v-on:click="showProduct(product.id)">
                                    <div class="label"></div>
                                    <ul class="product__hover">
                                        <li><a v-bind:href="`../${product.image}`" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="#">{{ product.name }}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">{{product.price}} VND</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
export default Vue.extend({
    components: {
        'tree-view': require('../components/Tree.vue').default
    },
    data() {
        return {
            products: [],
            categoryTrees: []
        }
    },
    mounted() {
        // this.getProducts();
        this.$store.dispatch('getProducts')
            .then(() => {
                this.products = this.$store.getters.filteredProducts;
            })
        this.$store.dispatch('getCategoryTrees')
            .then(() => {
                    this.categoryTrees = this.$store.getters.categoryTrees;
            });
    },
    computed: {
        filterProducts() {
            return this.$store.getters.filteredProducts;
        }
    },
    methods: {
        showProduct(productId) {
            this.$router.push({name: 'Product', params: {id : productId}});
        }
    }
})
</script>

<style scoped>
    .root-category {
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f2f2f2;
    }
</style>