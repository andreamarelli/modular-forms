export default {

    data: function () {
        return {
            not_applicable: null,
            not_available: null,
        }
    },

    methods:{

        __init_applicable: function(){
            if(this.enable_not_applicable===true
                && 'not_applicable' in this.records[0]
            ){
                if(this.module_type.includes('GROUP_')){
                    let first_group_key = Object.keys(this.groups)[0];
                    this.not_applicable = this.records[first_group_key][0]['not_applicable']===true;
                    this.not_available = this.records[first_group_key][0]['not_available']===true;
                } else {
                    this.not_applicable = this.records[0]['not_applicable']===true;
                    this.not_available = this.records[0]['not_available']===true;
                }
            }
        },

        toggleNotApplicable: function () {
            let _this = this;
            this.not_applicable = !this.not_applicable;
            this.not_available = false;
            this.records = [];
            this.records.push(this.__no_reactive_copy(this.empty_record));
            this.__arrange_records_by_group();
            if(this.module_type.includes('GROUP_')){
                let first_group_key = Object.keys(this.groups)[0];
                this.common_fields.forEach(function (field) {
                    _this.records[first_group_key][0][field['name']] = null;
                });
                this.records[first_group_key][0]['not_applicable'] = this.not_applicable === true ? true : null;
            } else {
                this.common_fields.forEach(function (field) {
                    _this.records[0][field['name']] = null;
                });
                this.records[0]['not_applicable'] = this.not_applicable === true ? true : null;
            }
        },

        toggleNotAvailable: function () {
            let _this = this;
            this.not_available = !this.not_available;
            this.records = [];
            this.records.push(this.__no_reactive_copy(this.empty_record));
            this.__arrange_records_by_group();
            if(this.module_type.includes('GROUP_')){
                let first_group_key = Object.keys(this.groups)[0];
                this.common_fields.forEach(function (field) {
                    _this.records[first_group_key][0][field['name']] = null;
                });
                this.records[first_group_key][0]['not_available'] = this.not_available === true ? true : null;
            } else {
                this.common_fields.forEach(function (field) {
                    _this.records[0][field['name']] = null;
                });
                this.records[0]['not_available'] = this.not_available === true ? true : null;
            }
        }

    }
}
