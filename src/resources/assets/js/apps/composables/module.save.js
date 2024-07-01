import {nextTick, readonly, unref} from "vue";

export function useSave(component_data) {

    // variables from component
    const module_type = unref(component_data.module_type);
    const groups = unref(component_data.groups);
    const records = unref(component_data.records);
    const empty_record = unref(component_data.empty_record);
    const records_backup = readonly(component_data.records_backup);
    const status = component_data.status;

    function reset(){

        records.forEach(function (record, index) {
            if(records_backup[index]){
                records[index] = JSON.parse(JSON.stringify(records_backup[index]));
            } else {
                delete records[index];
            }
        })

        nextTick().then(() => {
            component_data.status.value = 'idle';
        });

    }

    function save(){}


    return{reset, save}
}
