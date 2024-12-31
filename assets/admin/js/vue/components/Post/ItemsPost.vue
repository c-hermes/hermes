<script setup>
import {computed, inject, reactive, ref, watch } from 'vue'
import HeaderPost from './HeaderPost.vue';
import {useChangeIndex, useMyfilter} from '../Base/BaseItems'
import ButtonsUpDown from '../Base/ButtonsUpDown.vue';

const props = defineProps(['header', 'items', 'norecord'])
const header = computed(() => {
   return props.header
})

let myitems = reactive(props.items)
const URI = `/fr/admin/ajax/switch-position/post`
const myselect = inject('myselectSection')

const getPostHref = (item) => {
  return "/" + item.locale + "/admin/menu/" + item.menu_slug + '/contenu/' + item.id + '/' + item.name
}

const getCopyPostHref = (item) => {
  return "/" + item.locale + "/admin/contenu/copy/" + item.id
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
    <HeaderPost :header="header" ></HeaderPost>
    <tbody>
        <template v-for="(item, index) in myitems">
        <tr v-if="useMyfilter(myselect,item.section_id)" class="align-middle">
            <td class="col-1">
                <div class="form-check form-switch form-switch-sm my-0">
                    <input type="checkbox" class="post-active form-check-input" :id="item.id" :checked="item.active ? true : false">
                </div>
            </td>
            <td class="col-1">{{ item.locale }}</td>
            <td class="col-1">{{ item.sheet }}</td>
            <td class="col-1">{{ item.menu }}</td>
            <td class="col-1">{{ item.template }}</td>
            <td class="col-1" v-if="myselect !== 'all'">
                <div class="btn-group">
                    <div class="btn-group">
                        <ButtonsUpDown :class="{'disabled': index == 0 }"  :direction="'up'"   @click="changeIndex('up', index)"></ButtonsUpDown>
                        <ButtonsUpDown :class="{'disabled': index == last }"  :direction="'down'"    @click="changeIndex('down', index)"></ButtonsUpDown>
                    </div>
                </div>
            </td>
            <td class="col-1">{{ item.name }}</td>
            <td class="col-1">{{ item.startPublishedAt ? item.startPublishedAt.date.slice(0, 19) : ''  }}</td>
            <td class="col-1">{{ item.endPublishedAt ? item.startPublishedAt.date.slice(0, 19) : ''  }}</td>
            <td class="col-1">{{ item.updatedAt ? item.updatedAt.date.slice(0, 19) : '' }}</td>
            <td>
                <li v-for="(post) in item.posts"class="list-unstyled">
                    <a :class="[post.isActive ? 'hms-color1 h5' : 'hms-color1 h5 fst-italic text-decoration-line-through text-black-50']   " :href="getPostHref(post, item)">{{ post.name }}</a>
                </li>
            </td>
            <td class="col-2">
                <a class="ms-1" :id="item.code" :href="getPostHref(item)"><i class="hms-color1 btn btn-outline-success fa fa-edit"></i></a>
                <a class="ms-1" :id="item.name" :href="getCopyPostHref(item)" ><i class="hms-color1 btn btn-outline-success fa fa-copy"></i></a>
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
