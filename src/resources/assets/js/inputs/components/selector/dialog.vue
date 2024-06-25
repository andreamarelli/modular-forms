<template>

    <dialog-box ref="dialogComponent">

        <!-- ########  anchor  ######## -->
        <template v-slot:dialog-anchor>
            <div class="field-preview" v-html="anchorLabel"></div>
        </template>

        <!-- ########  dialog  ######## -->
        <template v-slot:dialog-content>
            <div class="with_header_and_footer">

                <!-- dialog header -->
                <div class="header">
                    <div class="dialog-title">{{ Locale.getLabel('modular-forms::common.select_item') }}</div>
                    <button type="button" class="close" @click=closeSelectorDialog><i class="fa fa-times black"></i></button>
                </div>

                <!-- dialog body -->
                <div class="body">

                    <!-- API search -->
                    <div v-show="displaySearch" class="dialog_select">
                        <selectorApiSearch
                            ref="apiSearchComponent"
                            :parent-id=parentId
                            :search-url=searchUrl
                        >
                            <template v-slot:resultFilters>
                                <slot name="selector-api-search-result-filters"></slot>
                            </template>

                            <template v-slot:resultHeader>
                                <slot name="selector-api-search-result-header"></slot>
                            </template>

                            <template #resultItem="{ item }">
                                <slot name="selector-api-search-result-item" :item=item></slot>
                            </template>

                        </selectorApiSearch>
                    </div>

                    <!-- INSERT item (text) -->
                    <div v-show="displayInsertText" class="dialog_insert">
                        <input type="text" class="field-edit dialog_insert_freetext" v-model=insertedItem />
                        <div class="dialog_insert_msg">
                            <i>{{ Locale.getLabel('modular-forms::common.be_specific_as_possible') }}</i>
                        </div>
                    </div>

                    <!-- INSERT item (object) -->
                    <div v-show="displayInsertObject" class="dialog_insert">
                        <slot name="selector-insert"></slot>
                    </div>


                </div>

                <!-- dialog footer -->
                <div class="footer">

                    <!-- insert toggle -->
                    <button type="button"
                            class="btn-nav dark small"
                            v-show="withInsert && displaySearch"
                            @click=enableInsert >
                        {{ Locale.getLabel('modular-forms::common.add_if_not_found') }}
                    </button>

                    <div class="spacer"></div>

                    <!-- error message -->
                    <div v-html="errorLabel" class="error text-sm"></div>


                    <!-- cancel -->
                    <button type="button"
                            class="btn-nav dark small"
                            @click=closeSelectorDialog >
                        {{ Locale.getLabel('modular-forms::common.cancel') }}
                    </button>

                    <!-- confirm insert -->
                    <button type="button"
                            class="btn-nav dark small"
                            v-show="displayInsertText || displayInsertObject"
                            @click=confirmInsert >
                        {{ Locale.getLabel('modular-forms::common.add') }}
                    </button>

                    <!-- confirm select -->
                    <button type="button"
                            class="btn-nav dark small"
                            :disabled="selectedValue===null"
                            v-show=displaySearch
                            @click=confirmSelection >
                        {{ Locale.getLabel('modular-forms::common.confirm_select') }}
                    </button>

                </div>

            </div>
        </template>

    </dialog-box>

</template>

<script setup>

import {computed, ref, defineModel, getCurrentInstance, inject, provide} from 'vue';
    import selectorApiSearch from "./api-search.vue";
    const Locale = window.ModularForms.Mixins.Locale;

    const props = defineProps({
        parentId:  {
            type: String,
            default: null
        },
        searchUrl: {
            type: String,
            default: null
        },
        labelUrl: {
            type: String,
            default: null
        },
        createUrl: {
            type: String,
            default: null
        },
        withInsert: {
            type: Boolean,
            default: false,
        },
        withId: {
            type: Boolean,
            default: false,
        }
    });

    // components, injections & expose
    const selectorComponent = getCurrentInstance().parent;
    const dialogComponent = ref(null);
    const apiSearchComponent = ref(null);
    const parentSetLabel = inject('setLabel', null);
    const parentSetValue = inject('setValue', null);
    provide('selectItem', selectItem);

    // values/labels
    const inputValue = defineModel();
    const selectedValue = ref(null);
    let anchorLabel = computed(() => {
        return setLabel();
    });
    const confirmedItem = ref(null);
    const insertedItem = ref(null);
    const errorLabel = ref(null);

    // template state
    const displaySearch = ref(true);
    const displayInsertText = ref(false);
    const displayInsertObject = ref(false);

    // ############  Methods  ############

    function initializeValue(value){} // TODO

    function setLabel(){
        // Retrieve value
        let value = confirmedItem.value!==null && Object.keys(confirmedItem.value).length !==0
            ? confirmedItem.value
            : inputValue.value;
        // Check if a custom "setLabel" is defined in parent component
        if(typeof parentSetLabel === "function"){
            return parentSetLabel(value);
        }
        return value;
    }

    function resetDialog(){
        apiSearchComponent.value.reset()
        errorLabel.value = null;
        displayInsertText.value = false;
        displayInsertObject.value = false;
        displaySearch.value = true;
        selectedValue.value = null;
        insertedItem.value = props.withId ? {} : null;
        // if(typeof this.selectorComponent.insertedItem !== "undefined"){
        //     this.selectorComponent.insertedItem = this.insertedItem;
        // }
    }

    function closeSelectorDialog(){
        // Check if a custom "beforeDialogClose" is defined in parent component
        if(selectorComponent.props.beforeDialogClose){
            selectorComponent.props.beforeDialogClose();
        }
        dialogComponent.value.closeDialog();
        resetDialog();
    }

    function setError(label = null){
        label = label===null
            ? Locale.getLabel('modular-forms::common.saved_error')
            : label;
       errorLabel.value = Locale.getLabel(label);
    }

    function resetError(){
        errorLabel.value = null;
    }

    function selectItem(item){
        selectedValue.value = item;
    }

    function confirmSelection(){
        confirmedItem.value = selectedValue.value;
        if(selectorComponent.props.confirmSelection){
            selectorComponent.props.confirmSelection();
        } else {
            applyAndClose();
        }
    }

    function enableInsert(){
        displaySearch.value = false;
        displayInsertText.value = !props.withId;
        displayInsertObject.value = props.withId;
    }

    function confirmInsert(){} // TODO
    function saveNewItem(){} // TODO
    function applyAndClose(){

        console.log(selectedValue.value);
        console.log(confirmedItem.value);

        // function setValue(value){
        //     // Check if a custom "setValue" is defined in parent component
        //     if(typeof parentSetValue === "function"){   // custom method
        //         return parentSetValue(inputValue.value);
        //     }
        //     return value;
        // }
        // TODO

    }



</script>
