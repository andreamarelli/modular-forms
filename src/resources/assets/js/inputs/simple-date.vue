<template>

    <input class="field-edit field-date"
           type="text"
           readonly
           v-model=inputValue
           :id=id
           :name=id
    />

</template>

<style lang="scss" scoped>

    .field-date{
        width: 120px;
        max-width: 120px;
        text-align: center;
        cursor: pointer;
    }

</style>

<script>

    import values from '../mixins-vue/values.mixin';

    export default {

        mixins: [
            values
        ],

        props: {
            dateType: {
                type: String,
                default: 'day'
            },
            startDate: {
                type: String,
                default: null
            },
            endDate: {
                type: String,
                default: null
            }
        },

        data(){
            return {
                Locale: window.Locale,
                inputValue: this.value,
                datePicker: null
            }
        },

        watch: {
            inputValue(value){
                this.emitValue(value);
            }
        },

        mounted(){

            this.id = this.id!=='' && this.id!==null
                ? this.id
                : this._uid;

            let _this = this;

            let options = {
                locale: window.ModularFormsVendor.AirDatepicker.locale[window.Locale.getLocale()],
                autoClose: true,
                toggleSelected: false,
                onSelect({date, formattedDate, datepicker}){
                    _this.inputValue = formattedDate
                },
                buttons: ['clear']
            };

            if(this.startDate!==null){
                options.minDate = this.startDate;
            }
            if(this.endDate!==null){
                options.maxDate = this.endDate;
            }

            if(this.dateType === 'day'){
                options.dateFormat = "yyyy-MM-dd";
                if(this.value !== null){
                    options.selectedDates = [this.value];
                }
            } else if(this.dateType === 'year'){
                options.dateFormat = "yyyy";
                options.view = "years";
                options.minView = "years";
                if(this.value !== null) {
                    options.selectedDates = [this.value + '-01-01'];
                }
            }

            this.datePicker = new window.ModularFormsVendor.AirDatepicker('#' + this.id, options);
        },

        methods: {

        }

    }
</script>
