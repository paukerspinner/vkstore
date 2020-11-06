<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-4 col-md-6 col-sm-8 offset-md-3 offset-lg-4 offset-sm-2">
                <form v-on:submit.prevent="login">
                    <h3 class="text-center">Đăng nhập</h3><hr>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="number" name="phone" v-model="phone" class="form-control" id="phone" autocomplete="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" v-model="password" class="form-control" id="password" autocomplete="password" required>
                        <div class="error" v-if="error">
                            <small>* {{ error }}</small>
                        </div>
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';

export default Vue.extend({
    data() {
        return {
            phone: '',
            password: '',
            error: ''
        }
    },
    methods: {
        login() {
            this.$store.dispatch('retrieveToken', {
                phone: this.phone,
                password: this.password
            })
                .then(response => {
                    
                }) 
                .catch(error => {
                    this.error = error.response.data.error;
                })
        }
    }
})
</script>

<style scoped>
    .error {
        color: red;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>