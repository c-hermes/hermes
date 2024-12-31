<script setup>
import {computed, inject, reactive} from 'vue'
import HeaderMenu from './HeaderMenu.vue';
import {useChangeIndex, useMyfilter} from '../Base/BaseItems'
import ButtonsUpDown from '../Base/ButtonsUpDown.vue';


const props = defineProps(['header', 'items', 'norecord'])
const header = computed(() => {
   return props.header
})
let myitems = reactive(props.items)

const URI = `/fr/admin/ajax/switch-position/menu`

const myselect = inject('myselect')

const getMenuHref = (item) => {
    return "/" + item.locale + "/admin/page/" + item.sheet_slug + "/edit/menu/" + item.referenceName + "/locale/" + item.locale
}

const getAddMenuHref = (item) => {
  return "/" + item.locale + "/admin/menu/" + item.slug + "/nouvelle-section/nouveau-contenu"
}
const changeIndex = (direction, index) => {
    myitems = useChangeIndex(myitems, direction, index, URI)
}

const last = computed(() => {
   return myitems.length - 1
})

</script>

<template>
<table class="table mt-4" >
<HeaderMenu :header="header" ></HeaderMenu>
<tbody>
    <template v-for="(item, index) in myitems">
    <tr v-if="useMyfilter(myselect,item.sheet)" class="align-middle">
        <td class="col-2">
            <div class="form-check form-switch form-switch-sm my-0">
                <input type="checkbox" class="menu-active form-check-input" :id="item.id" :checked="item.active ? true : false">
                <label class="custom-control-label" :for="item.id">{{ item.sheet }}</label>
            </div>
        </td>
        <td class="col-1">{{ item.locale }}</td>
        <td class="col-2">{{ item.sheet }}</td>
        <td class="col-2">{{ item.name }}</td>
        <td v-if="myselect !== 'all'">
            <div class="btn-group">
                <div class="btn-group">
                    <ButtonsUpDown :class="{'disabled': index == 0 }"  :direction="'up'"   @click="changeIndex('up', index)"></ButtonsUpDown>
                    <ButtonsUpDown :class="{'disabled': index == last }"  :direction="'down'"    @click="changeIndex('down', index)"></ButtonsUpDown>
                </div>
            </div> 
        </td>
        <td>{{ item.fileName }}</td>
        <td class="col-1">
            <a :id="item.code" :href="getMenuHref(item)"><i class="hms-color1 btn btn-outline-success fa fa-edit"></i></a>
            <a :id="item.name" :href="getAddMenuHref(item)" class="ps-1"><i class="hms-color1 btn btn-outline-success fa fa-plus-circle"></i></a>
        </td>
    </tr>
    <tr v-if="props.items.length < 1 " class="align-middle">
        <td colspan="5">{{props.norecord.norecord}}</td>
    </tr>
    </template>
</tbody>
</table>
</template>

<style>

</style>
