import {nextTick, readonly, unref} from "vue";

export function useSave(component_data) {

    // variables from component
    const records = unref(component_data.records);
    const records_backup = readonly(component_data.records_backup);
    const status = component_data.status;
    const action_url = component_data.action_url;
    const action_method = component_data.action_method;

    function reset(){

        // remove everything from records
        records.forEach(function (record, index) {
            delete records[index];
        });
        // add back from records_backup
        records_backup.forEach(function (record, index) {
            records[index] = JSON.parse(JSON.stringify(records_backup[index]));
        });

        nextTick().then(() => {
            status.value = 'idle';
        });

    }

    function save(){

        console.log('Save records');
        console.log(action_url);
        console.log(JSON.stringify(records));

        // fetch(action_url, {
        //     method: action_method,
        //     headers: {
        //         "Content-Type": "application/json",
        //         "X-CSRF-Token": window.Laravel.csrfToken,
        //     },
        //     body: JSON.stringify(records),
        // })
        //     .then((response) => response.json())
        //     .then(function(data){
        //         console.log(data);
        //     });
    }


    return{reset, save}
}
