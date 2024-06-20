<template>

    <div class="toggle">

        <div v-for="option in list"
             :class="isSelected(option.value) ? 'active' : ''"
             @click="setOption(option.value)"
        >{{ option.label }}</div>

        <input type="hidden"
               :id=id
               v-model="inputValue"
        />

    </div>

</template>

<script setup>

    import {onBeforeMount, onMounted, ref} from "vue";
    import {useList} from "./composables/list.js";

    const {sortList} = useList({});

    const props = defineProps({
        id: {
            type: String,
            default: null
        },
        dataValues: {
            type: String,
            default: '{}',
        }
    });

    const inputValue = defineModel();
    let list = ref([]);

    onBeforeMount(() => {
        list = initializeOptions();
    });

    onMounted(() => {
        console.log('mounted');
    });

    function initializeOptions() {
        let option_list = JSON.parse(props.dataValues);
        let list = [];
        for(let key in option_list) {
            if(key !== '_'&& key !== 'null' && option_list.hasOwnProperty(key)) {
                list.push({'label': option_list[key], 'value': key});
            }
        }
        list = sortList(list);
        return list;
    }

    function isSelected(value){
        return value!==null
            && inputValue.value!==null
            && value.toString() === inputValue.value.toString();
    }

    function setOption(value) {
        inputValue.value = inputValue.value===value ? null : value;
    }

</script>
