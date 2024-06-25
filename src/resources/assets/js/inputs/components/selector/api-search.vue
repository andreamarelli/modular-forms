<template>

    <div class="dialog_search">

        <!-- Search by key -->
        <i>{{ Locale.getLabel('modular-forms::common.search_item') }}: </i>
        <input type="text" class="field-edit dialog_search_by_key" ref="searchByKey" autofocus
               v-model="searchKey"
               v-on:keydown.13="preventDefault"
               v-on:keyup.13="applySearch" />

        <!-- Optional search filters -->
        <slot name="dialog_search_filters"></slot>

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
            <slot name="resultFilters"></slot>
        </div>

        <!-- Search Result -->
        <table class="striped dialog_search_results" v-if="searchExecuted">
            <thead>
            <tr>
                <th></th>
                <slot name="resultHeader"></slot>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in showList">
                <td>
                        <span class="radio">
                            <input type="radio"
                                   :name="parentId + '_radio'" :id="parentId + '_radio' + index"
                                   v-on:click="selectResultItem(item)"
                            />
                            <label :for="parentId + '_radio' + index" ></label>
                        </span>
                </td>
                <slot name="resultItem" :item=item></slot>
            </tr>
            </tbody>
        </table>

    </div>

</template>

<style lang="scss" scoped>

    @import "../../../../sass/abstracts/colors";

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

    import {computed, getCurrentInstance, inject, ref, defineExpose} from 'vue';
    const Locale = window.ModularForms.Mixins.Locale;
    import {useList} from "../../composables/list.js";

    const {filterByAttribute} = useList({});

    const props = defineProps({
        searchUrl: {
            type: String,
            default: null
        },
        parentId:  {
            type: String,
            default: null
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
    const selectorComponent = getCurrentInstance().parent.parent.parent;
    const selectorDialogComponent = getCurrentInstance().parent.parent;
    const parentAfterSearch = inject('afterSearch', null);
    const parentSelectedItem = inject('selectItem', null);
    defineExpose({
        filterShowList,
        reset
    })

    // reactive variables
    const searchKey = ref('');
    const isSearching = ref(false);
    const searchResults = ref({});
    const showList = ref({});
    const totalCount = ref(null);
    const searchExecuted = ref(false);
    const selectedValue = ref(null);

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

    function reset(){
        searchKey.value = '';
        isSearching.value = false;
        reset_search_result();
    }

    function reset_search_result(){
        searchExecuted.value = false;
        totalCount.value = null;
        selectedValue.value = null;
        searchResults.value = {};
        showList.value = {};
    }

    function searchParams(){
        let params = {
            'search_key': searchKey.value
        };
        // Check if a custom "searchParams" is defined in parent component
        if(selectorComponent.props.searchParams){
            selectorComponent.props.searchParams();
            Object.entries(selectorComponent.props.searchParams()).forEach(([key, value]) => {
                params[key] = value;
            });
        }
        return params;
    }

    function preventDefault(event){
        event.preventDefault();
        event.stopPropagation();
        return false
    }

    function applySearch(event) {
        if (isSearchable) {

            reset_search_result();
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
                    if(typeof parentAfterSearch === "function"){
                        parentAfterSearch(data);
                    }
                })
                .catch(function () {
                    // setErrors();
                })
        }
    }

    function filterShowList(filters){
        selectedValue.value = null;
        if(typeof parentSelectedItem === "function"){
            parentSelectedItem(null);
        }
        let filteredList = searchResults.value;
        filteredList = Object.values(filteredList)
        Object.keys(filters).forEach(function (key) {
            filteredList = filterByAttribute(filteredList, filters[key], key);
        });
        showList.value = filteredList;
    }

    function selectResultItem(item){
        selectedValue.value = item;
        if(typeof parentSelectedItem === "function"){
            parentSelectedItem(item);
        }
    }

</script>
