<template>

    <floating_dialog
        :is-scrollable=false
        class="selector-dialog"
    >

        <!-- anchor -->
        <template v-slot:dialog-anchor>
            <div class="field-preview" v-html="anchorLabel"></div>
        </template>

        <!-- dialog -->
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
                            :parent-id=parentId
                            :search-url=searchUrl
                        >
                            <template v-slot:resultFilters>
                                <slot name="selector-api-search-result-filters"></slot>
                            </template>

                            <template v-slot:resultHeader>
                                <slot name="selector-api-search-result-header"></slot>
                            </template>

                            <template v-slot:resultItem="{ item }">
                                <slot name="selector-api-search-result-item" v-bind:item="item"></slot>
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

    </floating_dialog>

</template>


<style lang="scss">
    .selector-dialog > .dialog-anchor {
        max-width: 450px;
    }
</style>

<style lang="scss" scoped>
    .with_header_and_footer {

        .header,
        .footer {
            display: flex;
            flex-direction: row;
            justify-content: space-between;

            .dialog-title {
                font-weight: bold;
            }

            .spacer {
                flex-grow: 1;
            }
        }

        .body {
            .dialog_select,
            .dialog_insert {
                max-height: 80vh;
                overflow-y: auto;
            }

        }

    }

    .dialog_insert {
        padding: 10px;
        text-align: center;

        .dialog_insert_freetext {
            width: 200px;
            margin: 0 10px;
        }

        .dialog_insert_msg {
            @apply text-xs;
            margin: 5px 0;
        }

    }


</style>

<script>
    import values from '../../../mixins-vue/values.mixin';
    import floating_dialog from "../../../templates/dialog_box.vue";
    import selectorApiSearch from "./api-search.vue"

    export default {

        components: {
            floating_dialog,
            selectorApiSearch
        },

        mixins: [
            values
        ],

        props: {
            disableDialog: {
                type: Boolean,
                default: false
            },
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
        },

        data (){
            return {
                Locale: window.Locale,
                dialogId: 'selectorDialog_' + this.parentId,
                // components
                selectorComponent: null,
                dialogComponent: null,
                searchComponent: null,
                // values/labels
                initValue: null,
                initLabel: null,
                anchorLabel: '',
                errorLabel: null,
                selectedValue: null,
                insertedItem: null,
                confirmedItem: null,
                // state
                displaySearch: true,
                displayInsertText: false,
                displayInsertObject: false,
            }
        },

        watch: {
            value(value){
                this.anchorLabel = this.setLabel(value);
            }
        },

        mounted (){
            this.selectorComponent = this.$parent;    // the selector (component) which extends this component
            this.dialogComponent = this.$children[0];
            this.searchComponent = this.$children[0].$children[0];
            this.initializeValue(this.selectorComponent.value);
            this.resetDialog();
        },

        methods: {

            initializeValue(value){
                let _this = this;
                if(this.withId && value!==null){
                    fetch(this.labelUrl, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": window.Laravel.csrfToken,
                        },
                        body: JSON.stringify({
                            id: value
                        }),
                    })
                        .then((response) => response.json())
                        .then(function(data){
                            _this.initValue = data.records;
                            _this.anchorLabel = _this.initLabel = _this.setLabel(_this.initValue);
                        })
                        .catch(function (error) {});
                } else {
                    this.initValue = value;
                    this.anchorLabel = this.initLabel = this.setLabel(_this.initValue);
                }
            },

            setLabel(value){
                value = (this.confirmedItem!=null && Object.keys(this.confirmedItem).length !== 0)
                    ? this.confirmedItem
                    : value;
                if(value!==null && typeof this.selectorComponent.setLabel === "function"){   // custom method
                    return this.selectorComponent.setLabel(value);
                }
                return value;
            },

            setValue(value){
                if(value!==null && typeof this.selectorComponent.setValue === "function"){   // custom method
                    return this.selectorComponent.setValue(value);
                }
                return value;
            },

            resetDialog(){
                this.errorLabel = null;
                this.displayInsertText = false;
                this.displayInsertObject = false;
                this.displaySearch = true;
                this.selectedValue = null;
                this.insertedItem = this.withId ? {} : null;
                if(typeof this.selectorComponent.insertedItem !== "undefined"){
                    this.selectorComponent.insertedItem = this.insertedItem;
                }
                this.searchComponent.reset();
            },

            closeSelectorDialog: function(){
                if(typeof this.selectorComponent.beforeDialogClose === "function"){   // custom method
                    this.selectorComponent.beforeDialogClose();
                }
                this.dialogComponent.closeDialog();
                this.resetDialog();
            },

            setError(label = null){
                label = label===null
                    ? Locale.getLabel('modular-forms::common.saved_error')
                    : label;
                this.errorLabel = Locale.getLabel(label);
            },

            resetError(){
                this.errorLabel = null;
            },

            confirmSelection(){
                this.confirmedItem = this.selectedValue;
                if(typeof this.selectorComponent.confirmSelection === "function") {   // custom method
                    this.selectorComponent.confirmSelection(this.confirmedItem);
                } else {
                    this.applyAndClose();
                }
            },

            enableInsert(){
                this.displaySearch = false;
                this.displayInsertText = !this.withId;
                this.displayInsertObject = this.withId;
            },

            confirmInsert(){
                this.resetError();

                this.confirmedItem = this.withId && typeof this.selectorComponent.insertedItem !== "undefined" // custom insertedItem
                    ? this.selectorComponent.insertedItem
                    : this.insertedItem;

                // Validate inserted item
                let valid = false;
                if(typeof this.selectorComponent.validateInsert === "function"){
                    valid = this.selectorComponent.validateInsert(this.confirmedItem);
                } else {
                    valid = this.withId
                        ? this.confirmedItem!=={}
                        : this.confirmedItem!==null;
                }

                if(valid){
                    if(this.withId) {
                        this.saveNewItem();
                    } else {
                        this.applyAndClose();
                    }
                } else {
                    this.setError(Locale.getLabel('common.validation_error'))
                }
            },

            saveNewItem(){
                let _this = this;
                fetch(_this.createUrl, {
                    method: 'post',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": window.Laravel.csrfToken,
                    },
                    body: JSON.stringify(_this.confirmedItem),
                })
                    .then((response) => response.json())
                    .then(function(data) {
                        _this.confirmedItem = data.records;
                        _this.applyAndClose();
                    })
                    .catch(function (error) {
                        _this.setError();
                    });

            },

            applyAndClose(){
                this.selectorComponent.inputValue = this.setValue(this.confirmedItem);
                this.selectorComponent.emitValue(this.selectorComponent.inputValue);
                this.closeSelectorDialog();
            }

        }


    }
</script>
