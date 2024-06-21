<template>

    <floating_dialog>

        <!-- anchor -->
        <template v-slot:dialog-anchor>

            <div class="upload-anchor dontOpenDialog">

                <!-- File name  -->
                <span class="field-preview upload-filename">
                   {{ value instanceof Object ? value.original_filename : value }}
                </span>

                <!-- Download link button -->
                <a class="btn-nav dark small" target="_blank"
                   :href="value.download_link"
                   v-if="value.original_filename!==null">
                    <i class="fa fa-cloud-download-alt white" />
                </a>

                <!-- Delete Button -->
                <button type="button" class="btn-nav small red"
                        v-if="value.original_filename!==null"
                        @click=deleteSelection>
                    <i class="fa fa-times-circle white" />
                </button>

                <!-- Upload Button -->
                <button type="button" class="btn-nav small"
                        v-if="value.original_filename===null"
                        @click=openUploadDialog>
                    <i class="fa fa-upload white" />&nbsp;
                        {{ Locale.getLabel('modular-forms::common.upload.upload_file') }}
                </button>

            </div>

        </template>


        <!-- dialog -->
        <template v-slot:dialog-content>

            <input name="file_upload" type="file" v-show="false" v-on:change="validateFile">

            <div class="with_header_and_footer">

                <!-- dialog header -->
                <div class="header">
                    <div class="dialog-title">{{ Locale.getLabel('modular-forms::common.upload.upload_file') }}</div>
                    <button type="button" class="close" @click=closeUploadDialog><i class="fa fa-times black"></i></button>
                </div>

                <!-- dialog body -->
                <div class="body">

                    <!-- Select file -->
                    <span v-if="!isFileSelected">
                        <label>
                            {{ Locale.getLabel('modular-forms::common.upload.no_file_selected') }}
                        </label>
                        &nbsp;&nbsp;
                        <button type="button" v-on:click="openFileSelection" class="btn-nav small">
                            <i class="fa fa-folder-open white" />
                            {{ Locale.getLabel('modular-forms::common.upload.select_file') }}
                        </button>
                    </span>

                    <!-- File selected -->
                    <span v-if="isFileSelected">
                        <label>
                            <span class="text-info">
                                <i class="fa fa-file" />&nbsp;{{ selectedFileName }}
                            </span>
                        </label>
                        &nbsp;&nbsp;
                        <button type="button" v-on:click="uploadFile" class="btn-nav small" v-if="!uploading">
                            <i class="fa fa-upload white" />
                            {{ Locale.getLabel('modular-forms::common.upload.upload') }}
                        </button>
                        <i v-if="uploading" class="fa fa-spinner fa-spin fa-2x green-800"></i>
                    </span>

                </div>

                <!-- dialog header -->
                <div class="footer" v-show="errorMessage!=null">
                    <div class="error-message">{{ errorMessage }}</div>
                </div>

            </div>

        </template>

    </floating_dialog>

</template>

<style lang="scss" scoped>

    .upload-anchor{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        column-gap: 5px;

        button{
            white-space: nowrap;
        }

        a.btn-nav{
            cursor: pointer;
        }

        .upload-filename{
            min-width: 300px;
        }

    }

    .with_header_and_footer{
        min-width: 200px;
        max-width: 500px;

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
            margin: 20px 0 10px 0;
            text-align: center;
        }
    }



</style>

<script>

import values from '../mixins-vue/values.mixin';
import floating_dialog from '../templates/dialog_box.vue';

export default {

    components: {
        'floating_dialog': floating_dialog,
    },

    mixins: [
        values
    ],

    props: {
        uploadUrl: {
            type: String,
            default: null
        },
        allowedFormats: {
            type: Array,
            default: function () {
                return null;
            }
        },
        maxFileSize: {
            type: Number,
            default: 10000000   // 10Mb
        }
    },

    data () {
        return {
            Locale: window.Locale,
            dialogComponent: null,
            isFileSelected: false,
            selectedFile: null,
            selectedFileName: null,
            changed: false,
            errorMessage: null,
            uploading: false,
        }
    },

    mounted (){
        this.dialogComponent = this.$children[0];
    },

    methods: {

        resetDialog(){
            this.isFileSelected = false;
            this.selectedFile = null;
            this.selectedFileName =  null;
            this.changed = false;
        },

        openUploadDialog: function(){
            // this.resetDialog();
            this.dialogComponent.openDialog();
        },

        closeUploadDialog: function(){
            this.dialogComponent.closeDialog();
            this.resetDialog();
        },

        openFileSelection(){
            let input_file = this.dialogComponent.$el.querySelector('input[name="file_upload"]');
            input_file.click();
        },

        validateFile: function(event){

            let errorMessage = null;
            this.errorMessage = null;

            if(event.target.files.length>0){

                this.selectedFile = event.target.files[0];
                this.selectedFileName =  this.selectedFile.name;
                this.isFileSelected = true;
                let extension = this.selectedFileName.split('.').pop();

                // Prevent upload if too big
                if(this.selectedFile.size > this.maxFileSize){
                    errorMessage = Locale.getLabel('modular-forms::common.upload.too_big');
                    errorMessage = errorMessage.replace('__maxFileSize__', this.maxFileSize/1000000);
                    this.isFileSelected = false;
                }

                // Check for allowed formats
                if(this.allowedFormats!==null && !this.allowedFormats.includes(extension)){
                    errorMessage = Locale.getLabel('modular-forms::common.upload.not_valid_format');
                    this.isFileSelected = false;
                }

                let regex = /^[a-zA-Z0-9-_.&()\s]{1,250}\.[a-zA-Z0-9]{2,5}$/;
                if(!regex.test(this.selectedFileName)){
                    errorMessage = Locale.getLabel('modular-forms::common.upload.not_valid_filename');
                    this.isFileSelected = false;
                }
            }

            if(errorMessage!==null){
                this.errorMessage = errorMessage;
            }

            event.target.value = '';
        },

        uploadFile: function () {
            let _this = this;
            let data = new FormData();
            data.append('file_upload', this.selectedFile);
            this.uploading = true;

            fetch(this.uploadUrl, {
                method: 'post',
                headers: {
                    "X-CSRF-Token": window.Laravel.csrfToken
                },
                body: data
            })
                .then((response) => response.json())
                .then(function(data){
                    _this.applySelection(data);
                })
                .catch(function (data) {
                    _this.errorMessage = Locale.getLabel('modular-forms::common.upload.error');
                })
                .finally(function (data) {
                    _this.uploading = false;
                    _this.loading = false;
                    _this.changed = true;
                });
        },

        applySelection: function(response){
            let value = {
                'original_filename': response.original_filename,
                'temp_filename': response.temp_filename,
                'download_link': response['download_link'],
                'changed': true
            };
            this.emitValue(value);
            this.closeUploadDialog();
        },

        deleteSelection: function () {
            this.changed = true;
            this.emitValue({
                'original_filename': null,
                'temp_filename': null,
                'download_link': null,
                'changed': true
            });
        },

    }

}


</script>
