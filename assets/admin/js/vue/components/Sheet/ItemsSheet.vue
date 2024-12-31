<script setup>
import {computed, reactive } from 'vue'
import {useChangeIndex} from '../Base/BaseItems'
import ButtonsUpDown from '../Base/ButtonsUpDown.vue';

const props = defineProps(['items', 'norecord'])
let myitems = reactive(props.items)
const URI = `/fr/admin/ajax/switch-position/sheet` // URI for sheet

const getMenuHref = (item) => {
  return "/" + item.locale + "/admin/page/edit/" + item.slug + "/" + item.locale // Href Menu
}

const changeIndex = (direction, index) => {
    myitems = useChangeIndex(myitems, direction, index, URI)
}

const last = computed(() => {
   return myitems.length - 1
})

</script>

<template>
<tbody>
    <tr v-for="(item, index) in myitems" class="align-middle">
        <td class="col-2">
            <div class="form-check form-switch form-switch-sm my-0">
                <input type="checkbox" class="sheet-active form-check-input" :id="item.id" :checked="item.active ? true : false">
                <label class="custom-control-label" :for="item.id">{{ item.name }}</label>
            </div>
        </td>
        <td class="col-2">{{ item.locale }}</td>
        <td>
            <div class="btn-group">
                <div class="btn-group">
                    <ButtonsUpDown :class="{'disabled': index == 0 }"  :direction="'up'"   @click="changeIndex('up', index)"></ButtonsUpDown>
                    <ButtonsUpDown :class="{'disabled': index == last }"  :direction="'down'"    @click="changeIndex('down', index)"></ButtonsUpDown>
                </div>
            </div>
        </td>
        <td>{{ item.name }}</td>
        <td>
            <a :id="item.code" :href="getMenuHref(item)"><i class="hms-color1 btn btn-outline-success fa fa-edit"></i></a>
        </td>
    </tr>
    <tr v-if="props.items.length < 1 " class="align-middle">
        <td colspan="5">{{props.norecord.norecord}}</td>
    </tr>
</tbody>
</template>

<style>

</style>
