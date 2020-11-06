<template>
    <div>
        <Banner />
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    components: {
        'Banner': require('../components/Banner.vue').default
    }
})
</script>