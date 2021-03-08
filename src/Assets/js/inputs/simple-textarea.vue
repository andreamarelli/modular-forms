<template>

    <span>
        <span id="simple-textarea" class="field-preview" contenteditable @input="onInput" v-text="originalValue"></span>
    </span>

</template>

<script>


    export default {

        mixins: [
            window.ModularForms.MixinsVue.values
        ],

        data (){
            return {
                originalValue: null
            }
        },

        mounted(){
            this.container = $(this.$el)[0];
            this.originalValue = this.value;
        },

        watch: {
            inputValue(value){
                this.emitValue(value);
                if(this.originalValue === value && document.activeElement.id!=='simple-textarea'){
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
