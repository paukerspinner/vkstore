<template>
    
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    created() {
        this.$store.dispatch('destroyToken');
    }
})
</script>