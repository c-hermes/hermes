<script setup>
import {inject, ref } from 'vue'

const props = defineProps(['items'])
const myitems = ref(props.items)
const myselect = inject('myselectSection')

const selectSection = (sel) => {
    myselect.value = sel
}

</script>

<template>
    <select class="form-select h-bg-success text-white" id="select_page" name="post" >
        <option class="align-middle" @click="selectSection('all')">All</option>
        <option v-for="(item, index) in myitems" :value="item.id" class="align-middle" @click="selectSection(item.id)">{{ item.menu + ' - '+ item.name  }}</option>
    </select>
</template>

<style>

</style>
