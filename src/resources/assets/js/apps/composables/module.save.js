import {readonly, unref} from "vue";

export function useSave(component_data) {

    // variables from component
    const module_type = unref(component_data.module_type);
    const groups = unref(component_data.groups);
    const records = unref(component_data.records);
    const empty_record = unref(component_data.empty_record);
    const records_backup = readonly(component_data.records_backup);
    let status = unref(component_data.status);

    function reset(){

        if(module_type.includes('GROUP_')) {


        } else {
            records.forEach(function (record, index) {
                if(records_backup[index]){
                    records[index] = JSON.parse(JSON.stringify(records_backup[index]));
                } else {
                    delete records[index];
                }
            })
        }

        // status = 'idle';

    }

    function save(){}


    return{reset, save}
}
