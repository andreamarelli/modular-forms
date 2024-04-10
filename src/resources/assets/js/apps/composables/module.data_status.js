 import {readonly, ref, toRaw, unref} from 'vue';
 import {useArrangeRecords} from "./module.arrange_records.js";

export function useDataStatus(component_data) {

    const NOT_APPLICABLE_KEY = 'not_applicable';
    const NOT_AVAILABLE_KEY = 'not_available';

    const not_applicable = ref(false);
    const not_available =  ref(false);

    // variables from component
    const enable_not_applicable = unref(component_data.enable_not_applicable);
    const module_type = unref(component_data.module_type);
    const common_fields = unref(component_data.common_fields);
    const groups = unref(component_data.groups);
    const records = ref(component_data.records);
    const empty_record = unref(component_data.empty_record);

    function initialize(){
        if(enable_not_applicable){

            let record = module_type.includes('GROUP_')
                ? records.value[Object.keys(groups)[0]][0]
                : records.value[0];
            record = Object.assign({}, record);

            if(NOT_APPLICABLE_KEY in record){
                not_applicable.value = record[NOT_APPLICABLE_KEY]===true;
                not_available.value = record[NOT_AVAILABLE_KEY]===true;
            }
        }
    }

    function isNotApplicable(){
        return not_applicable.value;
    }

    function isNotAvailable(){
        return not_available.value;
    }

    function toggle(toggle_key){
        if(toggle_key === NOT_APPLICABLE_KEY){
            not_applicable.value = !not_applicable.value;
            return updateRecords(NOT_APPLICABLE_KEY, not_applicable.value);
        } else if(toggle_key === NOT_AVAILABLE_KEY){
            not_available.value = !not_available.value;
            return updateRecords(NOT_AVAILABLE_KEY, not_available.value);
        }
    }

    function updateRecords(toggle_key, toggle_value){

        let new_records = [];

        if(module_type.includes('GROUP_')){
            // generate empty structure
            new_records = component_data.arrange_by_group(new_records);
            // inject common fields
            let first_group_key = Object.keys(groups)[0];
            common_fields.forEach(function (field) {
                if(field['name'] in records.value[first_group_key][0]){
                    new_records[first_group_key][0][field['name']] = records.value[first_group_key][0][field['name']];
                }
            });
            // set toggle value
            new_records[first_group_key][0][toggle_key] = toggle_value === true ? true : null;

        } else {
            // generate empty structure
            new_records.push(Object.assign({}, empty_record));
            // inject common fields
            common_fields.forEach(function (field) {
                if(field['name'] in records.value[0]){
                    new_records[0][field['name']] = records.value[0][field['name']];
                }
            });
            // set toggle value
            new_records[0][toggle_key] = toggle_value === true ? true : null;
        }

        return new_records;
    }


    return {initialize, isNotApplicable, isNotAvailable, toggle}
 }
