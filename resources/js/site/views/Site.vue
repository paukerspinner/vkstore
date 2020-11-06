<template>
    <div class="body">
        <vue-header />
        <router-view />
        <vue-footer />
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
export default Vue.extend({
    components: {
        'vue-header': require('./../components/Header.vue').default,
        'vue-footer': require('./../components/Footer.vue').default
    },
    beforeMount() {
        this.$store.dispatch('checkUserToken');
    },
    methods: {

    }
})
</script>
