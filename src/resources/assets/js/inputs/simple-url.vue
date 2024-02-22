<template>

    <simple-text
        v-model=inputValue
        :id=id
        :name=id
        :data-rules="dataRules!=='' ? dataRules+'|url' : 'url'"
    ></simple-text>

</template>

<script>

    import values from '../mixins-vue/values.mixin';
    import simple_text from './simple-text.vue';

    export default {

        components: {
            simple_text
        },

        mixins: [
            values
        ],

        watch: {
            inputValue(value){
                this.emitValue(value);
            }
        }



    }
</script>
