<script>
import Vue from 'vue';
const EventBus = new Vue({
    mounted() {

    },
    methods: {
        checkAuthenticated() {
            axios.get('/api/v1/profile', {
                headers: {
                    Authorization: 'Bearer'.localStorage.getItek('user-token')
                }
            });
        }
    }
});
export default EventBus;
</script>