<template>

    <div class="editorjs" ref="htmlelement"></div>

</template>

<script setup>
import EditorJS from '@editorjs/editorjs';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    id: {
        type: String,
        default: null
    }
});

const htmlelement = ref(null);
const inputValue = defineModel();
let editor;
let updatingModel = false;

// model -> view
function modelToView() {
    if (!inputValue.value) { return; }
    if (typeof inputValue.value === 'string') {
        editor.blocks.renderFromHTML(inputValue.value);
        return;
    }
    editor.render(inputValue.value);
}
// view -> model
function viewToModel(api, event) {
    updatingModel = true;
    editor.save().then((outputData) => {
        console.log(event, 'Saving completed: ', outputData)
        emit('update:modelValue', outputData);
    }).catch((error) => {
        console.log(event, 'Saving failed: ', error)
    }).finally(() => {
        updatingModel = false;
    })
}


onMounted(() => {
    editor = new EditorJS({
        holder: htmlelement.value,
        placeholder: null,
        inlineToolbar: ['bold', 'italic', 'link'],
        tools: {
            // embed: EmbedTool,
            // list: ListTool,
            // image: ImageTool,
            // video: VideoTool,
        },
        minHeight: 'auto',
        data: inputValue.value,
        onReady: modelToView,
        onChange: viewToModel,
    })
})

</script>
