<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-6 col-md-6 col-sm-8 offset-md-3 offset-lg-3 offset-sm-2">
                <form v-on:submit.prevent="register">
                    <h3 class="text-center">Đăng ký</h3><hr>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" v-model="phone" class="form-control" id="phone">
                        <div class="errors" v-if="errors.phone && errors.phone.length">
                            <ul>
                                <li v-for="(error, idx) in errors.phone" :key="idx"><small>* {{ error }}</small></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input type="text" name="name" v-model="name" class="form-control" id="name">
                        <div class="errors" v-if="errors.name && errors.name.length">
                            <ul>
                                <li v-for="(error, idx) in errors.name" :key="idx"><small>* {{ error }}</small></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Địa chỉ email</label>
                        <input type="email" name="email" v-model="email" class="form-control" id="email">
                        <div class="errors" v-if="errors.email && errors.email.length">
                            <ul>
                                <li v-for="(error, idx) in errors.email" :key="idx"><small>* {{ error }}</small></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" v-model="password" class="form-control" id="password">
                        <div class="errors" v-if="errors.password && errors.password.length">
                            <ul>
                                <li v-for="(error, idx) in errors.password" :key="idx"><small>* {{ error }}</small></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import router from './../routes.js';

export default Vue.extend({
    data() {
        return {
            phone: '',
            name: '',
            email: '',
            password: '',
            errors: {
                phone: [],
                name: [],
                email: [],
                password: []
            }
        }
    },
    methods: {
        register() {
            this.$store.dispatch('register', {
                phone: this.phone,
                name: this.name,
                email: this.email,
                password: this.password
            })
                .then(response => {
                    router.push('/');
                })
                .catch(error => {
                    console.clear();
                    this.errors.phone = error.response.data.phone;
                    this.errors.name = error.response.data.name;
                    this.errors.email = error.response.data.email;
                    this.errors.password = error.response.data.password;
                })
        }
    }
})
</script>


<style scoped>
    .errors ul li {
        list-style-type: none;
        color: red;
    }
</style>