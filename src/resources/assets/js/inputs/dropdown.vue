<template>

    <v-select
        :options=list
        :taggable=taggable
        :multiple=multiple
        ref="selectElem"
        :create-option="newOption => ({ label: newOption, code: newOption })"
        @search:blur="clearSearch"
        @update:modelValue="changeSelected"
        v-model=selectedItem
    ></v-select>

    <input type="hidden"
           :id=id
           v-model="inputValue"
    />

</template>

<script>
    import vSelect from 'vue-select';

    export default {
        components: {
            'v-select': vSelect
        }
    }
</script>

<script setup>


import {computed, onBeforeMount, ref, watch} from "vue";
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
        },
        taggable: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        }
    });

    const inputValue = defineModel();
    let selectedItem = computed(() => getSelectedItem());
    const selectElem = ref(null);
    let list = ref([]);

    onBeforeMount(() => {
        list = buildOptions();
    });

    function changeSelected(value){
        inputValue.value = value.code;
    }

    function buildOptions() {
        let option_list = JSON.parse(props.dataValues);
        let list = [];
        for(let key in option_list) {
            if((key !== '' && key !== 'null')
                && option_list.hasOwnProperty(key)) {
                list.push(getPair(key));
            }
        }
        // ensure initial selected value is in option list (if added by user)
        if(inputValue!==null && !(inputValue.value in option_list) && !props.multiple){
            list.push(getPair(inputValue.value));
        }
        list = sortList(list);
        return list;
    }

    function getSelectedItem(){
        let value = inputValue.value;
        if(value!==null){
            if(props.multiple){
                try {
                    value = JSON.parse(value);
                } catch (e) {
                    value = value.split(',');
                }
                return value.map(function(item){
                    return getPair(item);
                });
            }
            else {
                return getPair(value);
            }
        }
        return null;
    }

    function getPair(item){
        let option_list = JSON.parse(props.dataValues);
        return  {
            label: option_list[item] ?? item,
            code: item
        };
    }

    function clearSearch(){
        console.log('clearSearch');
        if(props.taggable){
            selectElem.value.search = '';
        }
    }

</script>
