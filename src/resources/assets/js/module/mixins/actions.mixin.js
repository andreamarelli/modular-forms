export default {

    data: function () {
        return {
            not_applicable: null,
            not_available: null,
        }
    },

    methods:{

        __init_applicable: function(){
            if(this.enable_not_applicable){
                if(this.module_type.includes('GROUP_')) {
                    let first_group_key = Object.keys(this.groups)[0];
                    if('not_applicable' in this.records[first_group_key][0]){
                        this.not_applicable = this.records[first_group_key][0]['not_applicable']===true;
                        this.not_available = this.records[first_group_key][0]['not_available']===true;
                    }
                } else {
                    if('not_applicable' in this.records[0]){
                        this.not_applicable = this.records[0]['not_applicable']===true;
                        this.not_available = this.records[0]['not_available']===true;
                    }
                }
            }
        },

        toggleNotApplicable: function () {
            this.not_applicable = !this.not_applicable;
            this.not_available = false;
            this._toggleNotApplicableNotAvailable();
        },

        toggleNotAvailable: function () {
            this.not_available = !this.not_available;
            this.not_applicable = false;
            this._toggleNotApplicableNotAvailable();
        },

        _toggleNotApplicableNotAvailable(){
            let _this = this;
            this.records = [];
            if(this.module_type.includes('GROUP_')){
                this.__arrange_records_by_group();
                let first_group_key = Object.keys(this.groups)[0];
                this.common_fields.forEach(function (field) {
                    if(field['name'] in _this.records[first_group_key][0]){
                        _this.records[first_group_key][0][field['name']] = null;
                    }
                });
                this.records[first_group_key][0]['not_applicable'] = this.not_applicable === true ? true : null;
            } else {
                this.records.push(this.__no_reactive_copy(this.empty_record));
                this.common_fields.forEach(function (field) {
                    if(field['name'] in _this.records[0]) {
                        _this.records[0][field['name']] = null;
                    }
                });
                this.records[0]['not_applicable'] = this.not_applicable === true ? true : null;
            }
        }

    }
}
