<template>

    <div class="container">
        <div class="field-edit" ref="textEditorComponent" v-html="editorValue"></div>
    </div>

</template>

<style scoped>
.container, .ql-container{
    max-width: 800px;
}

</style>
<style>
.ql-toolbar{
    background: white;
}
</style>

<script setup>
import { onMounted, ref, unref } from 'vue';
import Quill from 'quill';
import Bold from 'quill/formats/bold';
import Italic from 'quill/formats/italic';
import Link from 'quill/formats/link';
import List from 'quill/formats/list';
import Header from 'quill/formats/header';

import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";


const inputValue = defineModel();
const editorValue = ref(unref(inputValue));
const textEditorComponent = ref(null);

let quill = null;
const options = {
    modules: {
        toolbar: [
            ['bold', 'italic'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],
            [{ header: [2, false] }],
        ],
    },
    theme: 'snow'
};

onMounted(() => {
    quill = new Quill(textEditorComponent.value, options);
    quill.on('text-change', () => {
        inputValue.value = quill.container.querySelector('.ql-editor').innerHTML;
    });
});


</script>
