<template>
    <li class="tree">
        <div class="node">
            <i class="fa fa-folder" aria-hidden="true">&nbsp;</i>
            <router-link :to="{ name: 'Categories', params: {id: node.id} }">{{ node.label }}</router-link>
            <span v-if="hasChildren" class="btn-expand" v-on:click="toggleExpand">
                <i v-if="expanded" class="fa fa-minus-square-o"></i>
                <i v-if="!expanded" class="fa fa-plus-square-o"></i>
            </span>
        </div>
        
        <ul v-if="expanded">
            <tree-category 
                v-for="child in node.children" :key="child.id"
                :node="child"
            />
        </ul>
    </li>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'tree-category',
    props: {
        node: Object,
    },
    data() {
        return {
            expanded: true
        }
    },
    computed: {
        hasChildren() {
            return this.node.children.length != 0;
        }
    }, methods: {
        toggleExpand() {
            this.expanded = !this.expanded;
        }
    }
})
</script>
