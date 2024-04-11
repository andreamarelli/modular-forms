 import {readonly, ref, toRaw, unref} from 'vue';

export function useDataStatus(component_data) {

    const NOT_APPLICABLE_KEY = 'not_applicable';
    const NOT_AVAILABLE_KEY = 'not_available';

    const not_applicable = ref(false);
    const not_available =  ref(false);

    // variables from component
    const enable_not_applicable = unref(component_data.enable_not_applicable);
    const module_type = unref(component_data.module_type);
    const groups = unref(component_data.groups);
    const records = unref(component_data.records);
    const empty_record = unref(component_data.empty_record);

    function initialize(){
        if(enable_not_applicable){

            let record = module_type.includes('GROUP_')
                ? records[Object.keys(groups)[0]][0]
                : records[0];
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

        if(module_type.includes('GROUP_')) {
            Object.keys(groups).forEach(function (group_key) {
                records[group_key].splice(1);
                records[group_key][0] = Object.assign({}, empty_record);
                records[group_key][0][toggle_key] = toggle_value === true ? true : null;
            });

        } else {
            records.forEach(function (item, index) {
                if(index === 0){
                    records[index] = Object.assign({}, empty_record);
                    records[index][toggle_key] = toggle_value === true ? true : null;
                } else {
                    delete records[index];
                }
            });
        }
    }


    return {initialize, isNotApplicable, isNotAvailable, toggle}
 }