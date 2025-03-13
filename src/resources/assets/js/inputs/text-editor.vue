<template>

    <div ref="textEditorComponent"></div>

</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue';

const inputValue = defineModel();
const textEditorComponent = ref(null);

</script>
