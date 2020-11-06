<template>
    <li @mouseover="expand" @mouseleave="contract">
        <a v-bind:class="{ has__angle : hasChildren}" :aria-expanded="expanded ? 'true' : 'false'" v-on:click="onClickCategory(node.id)">{{node.label}}</a>
        <ul v-if="expanded">
            <tree-view
            v-for="child in node.children" :key="child.id"
            :node="child"
        />
        </ul>
    </li>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'tree-view',
    props: {
        node: Object,
    },
    data() {
        return {
            expanded: false
        }
    },
    methods: {
        onClickCategory(categId) {
            this.$store.dispatch('filterByCategory', categId);
        },
        expand() {
            this.expanded = true;
        },
        contract() {
            this.expanded = false;
        }
    },
    computed: {
        hasChildren() {
            return this.node.children.length != 0;
        }
    }
})
</script>