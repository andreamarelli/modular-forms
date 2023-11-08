<template>

    <dropdown
        v-model=selectedValue
        :dataValues=dropDownValues
    ></dropdown>

</template>


<script>

export default {

    props: {
        inputValue: {
            type: String,
            default: null
        },
        dataStructure: {
            type: Object,
            default: () => {}
        },
        relatedId: {
            type: String,
            default: ''
        }
    },

    data (){
        return {
            selectedValue: null,
            relatedValue: null,
            dropDownValues: '{}',
        }
    },

    watch: {
        selectedValue(value) {
            this.$emit('input', value);
        },
    },

    mounted(){
        this.selectedValue = this.inputValue;

        let relatedObj = document.getElementById(this.relatedId);
        this.relatedValue = relatedObj.value;

        this.updateList();

        let _this = this;
        relatedObj.addEventListener("change", function (e) {
            _this.relatedValue = e.target.value;
            _this.updateList();
        });
    },


    methods: {

        updateList: function () {
            if(this.relatedValue!==null){
                // Replace options in dropdown
                let dropDownValues = this.array_combine(this.dataStructure[this.relatedValue]);
                this.dropDownValues = JSON.stringify(dropDownValues);
                // Reset selectedValue if not in the refreshed options' list
                if(!(this.selectedValue in dropDownValues)){
                    this.selectedValue = null;
                }
            }
        },

        array_combine: function (list) {
            let new_list = {};
            for(let key in list) {
                if(list.hasOwnProperty(key)){
                    let value = list[key];
                    new_list[value] = value;
                }
            }
            return new_list;
        }

    }

}
</script>
