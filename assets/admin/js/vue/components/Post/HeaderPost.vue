<!--
Ce composant récupère les entête du tableau des Sous Menus (Menu).
-->

<script setup>
import { computed, inject,} from 'vue'
const props = defineProps(['header'])
const header = computed(() => {
   return props.header
})

const myselect = inject('myselectSection')

</script>

<template>
        <thead>
                <tr>
                        <th class="col-sm-1">{{ header.active }}/{{ header.inactive }}</th>
                        <th class="col-sm-1">{{ header.locale }}</th>
                        <th class="col-sm-1">{{ header.sheet }}</th>
                        <th class="col-sm-1">{{ header.menu }}</th>
                        <th class="col-sm-1">{{ header.template }}</th>
                        <th class="col-sm-1" v-if="myselect !== 'all'">{{ header.position }}</th>
                        <th class="col-sm-1">{{ header.name }}</th>
                        <th class="col-sm-1">{{ header.startPublishedAt }}</th>
                        <th class="col-sm-1">{{ header.endPublishedAt }}</th>
                        <th class="col-sm-1">{{ header.updatedAt }}</th>
                        <th class="col-sm-1">{{ header.actions }}</th>
                </tr>
        </thead>
</template>

<style>

</style> 
