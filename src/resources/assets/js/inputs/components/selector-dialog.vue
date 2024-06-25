<template>

    <dialog-box ref="dialogComponent">

        <!-- ###################################################### -->
        <!-- ######################  anchor  ###################### -->
        <!-- ###################################################### -->
        <template v-slot:dialog-anchor>
            <div class="field-preview" v-html="anchorLabel"></div>
        </template>

        <!-- ###################################################### -->
        <!-- ######################  dialog  ###################### -->
        <!-- ###################################################### -->
        <template v-slot:dialog-content>
            <div class="with_header_and_footer">

                <!-- dialog header -->
                <div class="header">
                    <div class="dialog-title">{{ Locale.getLabel('modular-forms::common.select_item') }}</div>
                    <button type="button" class="close" @click=closeSelectorDialog><i class="fa fa-times black"></i></button>
                </div>

                <!-- dialog body -->
                <div class="body">

                    <!--  ###############  API search   ############### -->
                    <div v-if="displaySearch" class="dialog_search">

                        <!-- Search by key -->
                        <i>{{ Locale.getLabel('modular-forms::common.search_item') }}: </i>
                        <input type="text" class="field-edit dialog_search_by_key" ref="searchByKey" autofocus
                               v-model="searchKey"
                               v-on:keydown.enter.prevent="applySearch"
                        />

                        <!-- Optional search filters -->
                        <slot name="searchFilters"></slot>

                        <!-- Search button -->
                        <button type="button" class="btn-nav gray small"
                                v-on:click="applySearch"
                                :disabled=!isSearchable >
                            {{ Locale.getLabel('modular-forms::common.search') }}
                        </button>

                        <!-- Search error / count -->
                        <div class="dialog_search_error" v-if="searchKey.length>0 && searchKey.length<keyMinLength" >
                            <i>{{ keyLengthErrorMessage }}</i>
                        </div>
                        <div class="dialog_search_count" v-if="searchExecuted">
                            <b>{{ totalCount }} {{ recordFoundLabel }}</b><br />
                        </div>

                        <!-- Loading icon -->
                        <div class="dialog_search_loading" v-if="isSearching">
                            <br />
                            <i class="fa fa-spinner fa-spin fa-2x primary-800"></i>
                        </div>

                        <!-- Result filters -->
                        <div class="dialog_search_results_filters" v-if="searchExecuted">
                            <slot name="searchResultFilters"></slot>
                        </div>

                        <!-- Search Result -->
                        <table class="striped dialog_search_results" v-if="searchExecuted">
                            <thead>
                            <tr>
                                <th></th>
                                <slot name="searchResultHeader"></slot>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in showList">
                                <td>
                                    <input type="radio"
                                           :name="parentId + '_radio'" :id="parentId + '_radio' + index"
                                           v-on:click="selectResultItem(item)"
                                    />
                                    <label :for="parentId + '_radio' + index" ></label>
                                </td>
                                <slot name="searchResultItem" :item=item></slot>
                            </tr>
                            </tbody>
                        </table>

                    </div>


                    <!--  ###############  INSERT   ############### -->

                    <!-- INSERT item (text) -->
                    <div v-if="displayInsertText" class="dialog_insert">
                        <input type="text" class="field-edit dialog_insert_freetext" v-model=insertedItem />
                        <div class="dialog_insert_msg">
                            <i>{{ Locale.getLabel('modular-forms::common.be_specific_as_possible') }}</i>
                        </div>
                    </div>

                    <!-- INSERT item (object) -->
                    <div v-if="displayInsertObject" class="dialog_insert">
                        <slot name="selector-insert"></slot>
                    </div>


                </div>

                <!-- dialog footer -->
                <div class="footer">

                    <!-- insert toggle -->
                    <button type="button"
                            class="btn-nav dark small"
                            v-if="withInsert && displaySearch"
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
                            v-if="displayInsertText || displayInsertObject"
                            @click=confirmInsert >
                        {{ Locale.getLabel('modular-forms::common.add') }}
                    </button>

                    <!-- confirm select -->
                    <button type="button"
                            class="btn-nav dark small"
                            :disabled="selectedValue===null"
                            v-if=displaySearch
                            @click=confirmSelection >
                        {{ Locale.getLabel('modular-forms::common.confirm_select') }}
                    </button>

                </div>

            </div>
        </template>

    </dialog-box>

</template>


<style lang="scss" scoped>

    @import "../../../sass/abstracts/colors";

    .dialog_search{

        padding: 10px;
        text-align: center;

        .dialog_search_by_key{
            width: 200px;
            margin: 0 10px;
        }

        .dialog_search_error{
            @apply text-red-700;
        }
        .dialog_search_error,
        .dialog_search_count{
            @apply text-xs;
            margin: 5px 0;
        }

        .dialog_search_results_filters{
            margin: 10px 0;
        }

        .dialog_search_results{
            th, td{
                @apply text-xs;
            }
        }


    }

</style>

<script setup>

import {computed, ref, defineModel, getCurrentInstance, inject, provide, defineExpose, onMounted} from 'vue';
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
        },
        keyMinLength: {
            type: Number,
            default: 4
        },
        parentSearchParamsValid:  {
            type: Boolean,
            default: false
        }
    });

    // components, injections & expose
    const dialogComponent = ref(null);
    const selectorComponent_AfterSearch = inject('afterSearch', null);
    const selectorComponent_SetLabel = inject('setLabel', null);
    const selectorComponent_SetValue = inject('setValue', null);
    const selectorComponent_beforeDialogClose = inject('beforeDialogClose', null);
    const selectorComponent_getSearchParams = inject('getSearchParams', null);
    const selectorComponent_confirmSelection = inject('confirmSelection', null);
    defineExpose({
        filterShowList
    })

    // values/labels
    const inputValue = defineModel();
    const selectedValue = ref(null);
    let anchorLabel = computed(() => {
        return setLabel();
    });
    const searchKey = ref('');
    const isSearching = ref(false);
    const searchResults = ref({});
    const showList = ref({});
    const totalCount = ref(null);
    const searchExecuted = ref(false);
    const confirmedItem = ref(null);
    const insertedItem = ref(null);
    const errorLabel = ref(null);

    // computed
    const isSearchable = computed(() => {
        return props.parentSearchParamsValid
            || searchKey.value.length >= props.keyMinLength;
    });
    const keyLengthErrorMessage = computed(() => {
        return Locale.getLabel('modular-forms::common.search_key_min_length', {num_chars: props.keyMinLength});
    });
    const recordFoundLabel = computed(() => {
        return Locale.getLabel('modular-forms::common.record_found', totalCount.value);
    });

    // template state
    const displaySearch = ref(true);
    const displayInsertText = ref(false);
    const displayInsertObject = ref(false);

    // ###################################################
    // ###############  Methods - GENERAL  ###############
    // ###################################################

    function initializeValue(value){} // TODO

    function setLabel(){
        // Retrieve value
        let value = confirmedItem.value!==null && Object.keys(confirmedItem.value).length !==0
            ? confirmedItem.value
            : inputValue.value;
        // Check if a custom "setLabel" is defined in parent component
        if(typeof selectorComponent_SetLabel === "function"){
            return selectorComponent_SetLabel(value);
        }
        return value;
    }

    function resetSelectorDialog(){
        resetSearchResult();
        searchKey.value = '';
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

    function resetSearchResult(){
        isSearching.value = false;
        searchExecuted.value = false;
        totalCount.value = null;
        selectedValue.value = null;
        searchResults.value = {};
        showList.value = {};
    }

    /**
     *  Close the SelectorDialog component
     */
    function closeSelectorDialog(){
        // Check if a custom "beforeDialogClose" is defined in parent component
        if(typeof selectorComponent_beforeDialogClose === "function"){
            selectorComponent_beforeDialogClose();
        }
        // reset state
        resetSelectorDialog();
        // close
        dialogComponent.value.closeDialog();
    }

    /**
     * Apply new item and close
     */
    function applyAndClose(){

        console.log('confirmedItem', confirmedItem.value);

        inputValue.value = typeof selectorComponent_SetValue === "function"
            ? selectorComponent_SetValue(confirmedItem.value)
            : confirmedItem.value

        closeSelectorDialog();
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


    // ########################################################
    // #############  Methods - Selection/search  #############
    // ########################################################

    function searchParams(){
        let params = {
            'search_key': searchKey.value
        };
        // Check if a custom "getSearchParams" is defined in selectorComponent
        if(typeof selectorComponent_getSearchParams === "function"){
            Object.entries(selectorComponent_getSearchParams()).forEach(([key, value]) => {
                params[key] = value;
            });
        }
        return params;
    }

    function applySearch(event) {
        if (isSearchable) {

            resetSearchResult();
            isSearching.value = true;

            fetch(props.searchUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": window.Laravel.csrfToken
                },
                body: JSON.stringify(searchParams())
            })
                .then((response) => response.json())
                .then(function(data){
                    searchResults.value = data['records'];
                    showList.value = data['records'];
                    totalCount.value = Object.keys(searchResults.value).length;
                    searchExecuted.value = true;
                    isSearching.value = false;
                    // Check if a custom "afterSearch" is defined in parent component
                    if(typeof selectorComponent_AfterSearch === "function"){
                        selectorComponent_AfterSearch(data);
                    }
                })
                .catch(function () {
                    // setErrors();
                })
        }
    }

    function filterShowList(filters){
        selectedValue.value = null;
        let filteredList = searchResults.value;
        filteredList = Object.values(filteredList)
        Object.keys(filters).forEach(function (key) {
            filteredList = filterByAttribute(filteredList, filters[key], key);
        });
        showList.value = filteredList;
    }

    function selectResultItem(item){
        selectedValue.value = item;
    }

    function confirmSelection(){
        confirmedItem.value = selectedValue.value;
        // if(typeof selectorComponent_confirmSelection === "function"){
        //     selectorComponent_confirmSelection();
        // } else {
            applyAndClose();
        // }
    }


    // ####################################################
    // ################  Methods - insert  ################
    // ####################################################

    function enableInsert(){
        displaySearch.value = false;
        displayInsertText.value = !props.withId;
        displayInsertObject.value = props.withId;
    }

    function confirmInsert(){} // TODO
    function saveNewItem(){} // TODO




</script>
