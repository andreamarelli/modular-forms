<template>

    <floating_dialog
        :is-scrollable=false
    >

        <!-- anchor -->
        <template v-slot:dialog-anchor>
            <slot name="selector-anchor"></slot>
        </template>

        <!-- dialog -->
        <template v-slot:dialog-content>

            <div class="with_header_and_footer">

                <!-- dialog header -->
                <div class="header">
                    <div class="dialog-title">{{ dialogTitle }}</div>
                    <button type="button" class="close" @click=closeSelectorDialog><i class="fa fa-times black"></i></button>
                </div>

                <!-- dialog body -->
                <div class="body">

                    <!-- API search -->
                    <div v-show="displaySearch">
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

                    <!-- INSERT item -->
                    <div v-show="displayInsert" class="dialog_insert">
                        <slot name="selector-insert">

                            <!-- DEFAULT simple text field -->
                            <i>{{ Locale.getLabel('modular-forms::entities.biodiversity.species', 1) }}: </i>
                            <input type="text" class="field-edit dialog_insert_freetext"
                                   value="" :id="'selector_item_insert_'+parentId" />
                            <div class="dialog_insert_msg">
                                <i>{{ Locale.getLabel('modular-forms::common.be_specific_as_possible') }}</i>
                            </div>

                        </slot>
                    </div>


                </div>

                <!-- dialog footer -->
                <div class="footer">

                    <!-- insert toggle -->
                    <button type="button"
                            class="btn-nav dark small"
                             v-show="enableFreeText && displaySearch"
                             @click=enableInsert >
                         {{ Locale.getLabel('modular-forms::common.add_if_not_found') }}
                    </button>

                    <div class="spacer"></div>

                    <!-- confirm insert -->
                    <button type="button"
                            class="btn-nav dark small"
                            @click=closeSelectorDialog >
                        {{ Locale.getLabel('modular-forms::common.cancel') }}
                    </button>

                    <!-- confirm insert -->
                    <button type="button"
                            class="btn-nav dark small"
                            v-show=displayInsert
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

<style lang="scss" scoped>

    .with_header_and_footer{

        .header,
        .footer{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            .dialog-title{
                font-weight: bold;
            }
            .spacer{
                flex-grow: 1;
            }
        }
        .body{
            max-height: 80vh;
            overflow-y: auto;
        }

    }

    .dialog_insert {
        padding: 10px;
        text-align: center;

        .dialog_insert_freetext{
            width: 200px;
            margin: 0 10px;
        }
        .dialog_insert_msg{
            @apply text-xs;
            margin: 5px 0;
        }

    }


</style>

<script>
    import values from '../../../mixins-vue/values.mixin';
    import floating_dialog from "../../../templates/dialog.vue";
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
            searchUrl: {
                type: String,
                default: null
            },
            enableFreeText: {
                type: Boolean,
                default: false,
            },
            parentId:  {
                type: String,
                default: null
            },
            dialogTitle:  {
                type: String,
                default: () => {
                    return Locale.getLabel('modular-forms::common.select_item');
                }
            },
            anchorLabel:  {
                type: String,
                default: null
            }
        },

        data (){
            return {
                selectorComponent: null,
                dialogComponent: null,
                searchComponent: null,
                Locale: window.Locale,
                dialogId: 'selectorDialog_' + this.parentId,
                errorLabel: null,
                selectedValue: null,
                displaySearch: true,
                displayInsert: false,

            }
        },

        mounted (){
            this.selectorComponent = this.$parent;    // the selector (component) which extends this component
            this.dialogComponent = this.$children[0];
            this.searchComponent = this.$children[0].$children[0];
        },

        methods: {

            resetDialog(){
                this.errorLabel = null;
                this.displayInsert = false;
                this.displaySearch = true;
                this.selectedValue = null;
                document.getElementById('selector_item_insert_'+this.parentId).value = null;
                this.searchComponent.reset();
            },

            openSelectorDialog: function(){
                this.resetDialog();
                this.dialogComponent.openDialog();
                this.afterDialogOpen();
            },

            closeSelectorDialog: function(){
                this.beforeDialogClose();
                this.dialogComponent.closeDialog();
                this.resetDialog();
            },

            afterDialogOpen: function () {

                if(typeof this.selectorComponent.afterDialogOpen === "function"){
                    this.selectorComponent.afterDialogOpen();
                }
            },

            beforeDialogClose: function(){
                if(typeof this.selectorComponent.beforeDialogClose === "function"){
                    this.selectorComponent.beforeDialogClose();
                }
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
                let value = null;
                // custom confirm
                if(typeof this.selectorComponent.confirmSelection === "function") {
                    this.selectorComponent.confirmSelection(this.selectedValue);
                    return;
                }
                // custom value parsing
                if(typeof this.selectorComponent.getSelectedValue === "function"){
                    value = this.selectorComponent.getSelectedValue(this.selectedValue);
                } else {
                    value = this.selectedValue;
                }
                this.applyValue(value);
            },

            enableInsert(){
                this.displaySearch = false;
                this.displayInsert = true;
            },

            confirmInsert(){
                let value = null;
                // custom value parsing
                if(typeof this.selectorComponent.getInsertedValue === "function"){
                    value = this.selectorComponent.getInsertedValue(this.selectedValue);
                } else {
                    value = document.getElementById('selector_item_insert_'+this.parentId).value;
                }
                this.applyValue(value);
            },

            applyValue(value){
                this.selectorComponent.inputValue = value;
                this.selectorComponent.emitValue(this.selectorComponent.inputValue);
                this.dialogComponent.closeDialog();
            }

        }


    }
</script>
