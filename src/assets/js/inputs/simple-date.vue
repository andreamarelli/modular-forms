<template>

    <input class="field-edit"
           type="text"
           readonly
           v-model=inputValue
           :id=id
           :name=id
    />

</template>

<style lang="scss" scoped>

    .simple-date input{
        width: 100px;
        max-width: 100px;
        text-align: center;
        cursor: pointer;
    }

</style>

<script>

    export default {

        mixins: [
            window.ModularForms.MixinsVue.values
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

            let _this = this;

            let options = {
                locale: window.AirDatepicker.locale[window.Locale.getLocale()],
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

            this.datePicker = new window.AirDatepicker('#' + this.id, options);
        },

        methods: {

        }

    }
</script>
