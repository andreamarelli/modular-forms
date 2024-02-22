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
                                   v-on:click="selectResultItem(item, $event)"
                            />
                            <label :for="parentId + '_radio' + index" ></label>
                        </span>
                    </td>
                    <slot name="resultItem" v-bind:item="item"></slot>
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

<script>

import filter from '../../../mixins-vue/filter.mixin';
import values from '../../../mixins-vue/values.mixin';

export default {

    mixins: [
        filter,
        values
    ],

    props: {
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
    },

    data (){
        return {
            Locale: window.Locale,
            selectorComponent: null,
            searchKey: '',
            searchExecuted: false,
            isSearching: false,
            searchResults: {},
            showList: {},
            totalCount: null,
            selectedValue: null
        }
    },

    mounted(){
        this.selectorComponent = this.$parent.$parent.$parent;  /// the selector (component) which extends this component
        this.selectorDialogComponent = this.$parent.$parent;
    },

    computed: {
        keyLengthErrorMessage(){
            return Locale.getLabel('modular-forms::common.type_at_least', {'num_chars': this.keyMinLength} );
        },
        recordFoundLabel(){
            return Locale.getLabel('modular-forms::common.record_found', this.totalCount);
        },
        isSearchable(){
            return this.parentSearchParamsValid
                || this.searchKey.length >= this.keyMinLength;
        },
    },

    methods: {

        reset(){
            this.searchKey = '';
            this.isSearching = false;
            this.reset_search_result();
        },

        reset_search_result(){
            this.searchResults = {};
            this.showList = {};
            this.totalCount = null;
            this.searchExecuted = false;
            this.selectedValue = null;
        },

        searchParams(){
            let _this = this;
            let params = {
                'search_key': _this.searchKey
            };
            if(typeof this.selectorComponent.searchParams === "function"){
                Object.entries(_this.selectorComponent.searchParams()).forEach(([key, value]) => {
                    params[key] = value;
                });
            }
            return params;
        },

        preventDefault(event){
            event.preventDefault();
            event.stopPropagation();
            return false
        },

        applySearch(event) {
            let _this = this;
            if (_this.isSearchable) {

                _this.reset_search_result();
                this.isSearching = true;

                fetch(_this.searchUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": window.Laravel.csrfToken
                    },
                    body: JSON.stringify(_this.searchParams())
                })
                    .then((response) => response.json())
                    .then(function(data){
                        _this.searchResults = data['records'];
                        _this.showList = _this.searchResults;
                        _this.totalCount = Object.keys(_this.searchResults).length;
                        _this.searchExecuted = true;
                        _this.isSearching = false;
                        if(typeof _this.selectorComponent.afterSearch === "function"){
                            _this.selectorComponent.afterSearch(data);
                        }
                    })
                    .catch(function () {
                        // _this.setErrors();
                    })
            }
        },

        filterShowList(filters){
            let _this = this;
            _this.selectedValue = _this.selectorDialogComponent.selectedValue = null;
            let filteredList = _this.searchResults;
            filteredList = Object.values(filteredList)
            Object.keys(filters).forEach(function (key) {
                filteredList = _this.filterByAttribute(filteredList, filters[key], key);
            });
            _this.showList = filteredList;
        },

        selectResultItem(item, event){
            this.selectedValue = item;
            this.selectorDialogComponent.selectedValue = this.selectedValue;
        },

    }
}
</script>
