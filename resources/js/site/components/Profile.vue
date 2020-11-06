<template>
    <div>
        
    </div>
</template>


<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    data() {
        return {
            user: {}
        }
    },
    beforeMount() {
        this.getProfile();
    },
    methods: {
        getProfile() {
            console.log('Profile');
        }
    }
})
</script>