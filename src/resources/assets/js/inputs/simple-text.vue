<template>

    <span>
        <input type="text"
               :id=id
               :name=id
               v-model="inputValue"
               class="field-edit"
               autocomplete="off"
        />
        <tooltip
            v-if=tooltipEnabled
            :anchor-elem-id=id
        >
            {{ inputValue }}
        </tooltip>
    </span>

</template>

<script>

    export default {

        mixins: [
            window.ModularForms.MixinsVue.values
        ],

        data() {
            return {
                tooltipEnabled: true,
            }
        },

        mounted() {
            this.container = this.$el;
        },

        watch: {
            inputValue(value) {
                this.emitValue(value);
            }
        }

    }

</script>
