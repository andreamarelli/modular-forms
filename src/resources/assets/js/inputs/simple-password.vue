<template>

    <span>
        <input type="password"
           :id=id
           :name=id
           v-model="inputValue"
           class="field-edit"
        />
    </span>

</template>

<script>

    import values from '../mixins-vue/values.mixin';

    export default {

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
