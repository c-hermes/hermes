<!--
Ce composant récupère l'entête et les lignes des posts (Pqages).
-->

<script setup>
import { computed, provide, reactive } from 'vue'
import FiltrePost from './FiltrePost.vue';
import ItemsPost from './ItemsPost.vue';
import SelectPost from './SelectPost.vue';
import ButtonsPost from './ButtonsPost.vue';

provide('myselectSection', false)

const datas = reactive(document.querySelector('#vue_items_post'))

const filtre = computed(() => {
   return JSON.parse(datas.dataset.filtre)
})

const items = computed(() => {
   return JSON.parse(datas.value)
})

const header = computed(() => {
   return JSON.parse(datas.dataset.global)
})

const norecord = computed(() => {
   return JSON.parse(datas.dataset.norecord)
})

const buttons = computed(() => {
   return JSON.parse(datas.dataset.buttons)
})

</script>

<template>
   <SelectPost>
      <FiltrePost :items="filtre" ></FiltrePost>
      <ItemsPost :header="header" :items="items" :norecord="norecord"></ItemsPost>
   </SelectPost>
   <ButtonsPost :buttons="buttons" ></ButtonsPost>

</template>

<style>

</style>
