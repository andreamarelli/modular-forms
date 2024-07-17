import {nextTick, readonly, toRaw, unref, ref} from "vue";

export function useSave(component_data) {

    // variables from component
    let records = component_data.records;
    let records_backup = component_data.records_backup;
    const status = component_data.status;
    const form_id = component_data.form_id;
    const module_key = component_data.module_key;
    const action_url = component_data.action_url;
    let error_messages = ref([]);

    /**
     * Replace records iteratively with given records
     */
    function replaceRecords(newRecords) {
        // remove everything from records
        records.forEach(function (record, index) {
            delete records[index];
        });
        // add back new records
        newRecords.forEach(function (record, index) {
            records[index] = JSON.parse(JSON.stringify(newRecords[index]));
        });
    }

    /**
     * Replace records_backup with given records
     */
    function replaceRecordsBackup(newRecords) {
        // remove everything from records
        records_backup.forEach(function (record, index) {
            delete records_backup[index];
        });
        // add back new records
        newRecords.forEach(function (record, index) {
            records_backup[index] = JSON.parse(JSON.stringify(newRecords[index]));
        });
    }


    function resetModule(){
        replaceRecords(component_data.records_backup);
        nextTick().then(() => {
            status.value = 'idle';
        });
    }

    function saveModule(){

        let data = {
            records_json: window.ModularForms.Helpers.Payload.encode(records),
            form_id: form_id,
            module_key: module_key,
        };
        if(form_id !== null){
            data._method = 'PATCH';
        }

        fetch(action_url, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": window.Laravel.csrfToken,
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then(function(data){

                if (data.status === 'success') {
                    // On create redirect to edit view
                    if(form_id == null){
                        window.location.href = data.edit_url;
                    } else {

                        replaceRecords(data.records);
                        replaceRecordsBackup(data.records);
                        component_data.last_update.date = data.last_update.date;

                        // TODO


                        nextTick().then(() => {
                            status.value = 'saved';
                        });
                    }
                } else if(data.status === 'validation_error') {
                    setErrorStatus(data);
                }

            })
            .catch(function (error) {
                setErrorStatus(error);
                saveModuleFailCallback(error);
                saveModuleAlwaysCallback(error);
            });
    }

    function setErrorStatus(data){
        status.value = 'error';
        // remove all error messages
        error_messages.value = [];
        // add errors from response
        if(data.hasOwnProperty('errors')){
            Object.keys(data['errors']).forEach(function (field) {
                data['errors'][field].forEach(function (message) {
                    error_messages.value.push(message);
                });
            });
        }
    }


    // Allows additional executions by child components
    function resetModuleCallback(){}
    function saveModuleDoneCallback(response){}
    function saveModuleFailCallback(response){}
    function saveModuleAlwaysCallback(response){}


    return{
        resetModule,
        saveModule,
        error_messages,
        resetModuleCallback,
        saveModuleDoneCallback,
        saveModuleFailCallback,
        saveModuleAlwaysCallback
    }
}
