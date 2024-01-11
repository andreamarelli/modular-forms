<template>

    <span class="toggle">

        <input type="hidden" value="value" :id="id" :name="id" v-bind:value="value" class="toggle" />

        <div v-for="option in listOptions"
                :class="isSelected(option.value) ? 'active' : ''"
                v-on:click="setOption(option.value)"
        >{{ option.label }}</div>

    </span>


</template>

<script>

    import values from '../mixins-vue/values.mixin';

    export default {

        mixins: [
            values
        ],

        props: {
            dataValues: {
                type: String,
                default: '{}',
            }
        },

        data (){
            return {
                listOptions: this.buildOptionList(),
            }
        },

        mounted: function () {
            this.buildOptionList();
        },

        methods: {

            buildOptionList: function (){
                let dataValues = JSON.parse(this.dataValues);
                let data = [];
                for(let index in dataValues) {
                    if(index!=='_' && dataValues.hasOwnProperty(index)){
                        data.push({'label': dataValues[index], 'value': index});
                    }
                }
                this.listOptions = data;
            },

            isSelected: function(value){
                return value!==null
                    && this.inputValue!==null
                    && value.toString() === this.inputValue.toString();
            },

            setOption: function (value) {
                this.inputValue = this.inputValue===value ? null : value;
                this.emitValue(this.inputValue);
            }

        }

    }
</script>
