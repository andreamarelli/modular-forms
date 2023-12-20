export default {

    props: {
        preload_records: {
            type: Array,
            default: () => []
        },
    },

    methods: {

        openPreloadDialog(){
            this.__retrieve_preload_data();
            this.openDialog();
        },

        __retrieve_preload_data: function(){
            let _this = this;
            $.ajax({
                url: window.Laravel.baseUrl + 'api/' + this.module_key.split('__')[0] + '/preload',
                type: "POST",
                data: {
                    '_token': window.Laravel.csrfToken,
                    'module_key': _this.module_key,
                    'form_id': _this.form_id,
                }
            })
                .done(function (response) {
                    _this.preload_records = response['records'];
                    _this.container.querySelector('.preload_container').innerHTML = response['view'];
                })
        },

        show_previous_year: function(year){
            this.container.querySelector(".preload_preview").style.display = 'none';
            this.container.querySelector(".preload_button").classList.remove('active-disabled');
            this.container.querySelector(".preload_button").classList.add('basic');
            this.container.querySelector(".preload_preview.year_" + year).style.display = 'inline-block';
            this.container.querySelector(".preload_button.year_" + year).classList.remove('basic');
            this.container.querySelector(".preload_button.year_" + year).classList.remove('active-disabled');
        },

        apply_preload_one_record: function (year, index) {
            let _this = this;
            let record = _this.preload_records[year][index];
            if (_this.predefined_values !== null && record['__predefined']) {
                let pred_field =_this.predefined_values.field;
                _this.records.forEach(function(r, i) {
                    if(record[pred_field] === r[pred_field]){
                        _this.records.splice(i, 1, record);
                    }
                });
            } else {
                _this.records.push(record);
            }
        },

        // apply_preload_all: function (year) {
        //     let _this = this;
        //     let records = this.preload_records[year];
        //     records.forEach(function(record) {
        //         _this.records.push(record);
        //     });
        // }

    }
}
