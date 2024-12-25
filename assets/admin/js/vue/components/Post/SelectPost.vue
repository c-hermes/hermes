<script setup>
import {provide, ref } from 'vue'

const myselect= ref('all')
provide('myselectSection', myselect)

</script>

<template>
    <slot></slot>
</template>

<style>

</style>
