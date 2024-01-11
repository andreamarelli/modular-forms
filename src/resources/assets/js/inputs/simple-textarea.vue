<template>

    <span>
        <span v-if="disabled" id="simple-textarea" class="field-preview disabled" @input="onInput" v-text="originalValue"></span>
        <span v-else id="simple-textarea" class="field-preview" contenteditable @input="onInput" v-text="originalValue"></span>
    </span>

</template>

<script>

    import values from '../mixins-vue/values.mixin';

    export default {

        mixins: [
            values
        ],

        props:{
            disabled: {
                type: Boolean,
                default: false
            }
        },

        data (){
            return {
                originalValue: null
            }
        },

        mounted(){
            this.container = this.$el;
            this.originalValue = this.value;
        },

        watch: {
            inputValue(value){
                this.emitValue(value);
                // apply value to text-area but onInput
                if(document.activeElement.id!=='simple-textarea'){
                    this.container.querySelector('span').innerText = value;
                }
            }
        },
         methods:{
             onInput(e) {
                 this.inputValue = e.target.innerText;
             },
         }

    }

</script>
