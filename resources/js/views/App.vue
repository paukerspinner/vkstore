<template>
    <div>
        This is client
    </div>
</template>

<script lang="ts">
import Vue from "vue";
export default Vue.extend({
    data: function () {
        return {
        adminpage: false,
        };
    },
    mounted: function () {
        this.adminpage = this.checkAdminpage();
    },
    updated: function () {
        this.adminpage = this.checkAdminpage();
    },
    methods: {
        checkAdminpage() {
        let currentPath = this.$router.currentRoute.path;
        var adminRegex = new RegExp("^/adminpage");
        console.log(adminRegex.test(currentPath));
        return adminRegex.test(currentPath);
        },
    },
});
</script>