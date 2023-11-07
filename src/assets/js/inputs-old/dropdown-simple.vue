<template>
    <span :class=dataClass>
        <select :id=id :name=id>
            <option :value=selectedValue selected="selected">{{ selectedLabel }}</option>
        </select>
    </span>

</template>

<script>

    export default {

        mixins: [
            window.ModularForms.MixinsVue.dropdown,
        ],

        mounted() {
            let elem = this.$el;
            elem.classList.remove('field-edit');
            if(elem.classList.contains('width100px')){
                elem.classList.remove('width100px');
                elem.querySelector('span.select2').classList.add('width100px');
                elem.querySelector('span.select2').style.width = "";
            }
        },

    }
</script>
