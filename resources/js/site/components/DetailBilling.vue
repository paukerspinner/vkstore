<template>
    <div class="detail__billing">
        <h5>Chi tiết địa chỉ</h5>
        <div>
            <p>Họ và tên: <span>{{ dataShip }}</span></p>

        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    computed: {
        dataShip() {
            return this.$store.getters.dataShip
        }
    }
})
</script>