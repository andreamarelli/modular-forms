import {computed, toRaw, unref} from "vue";

export function useArrangeRecords(component_data) {

    const module_type = unref(component_data.module_type);
    const groups = unref(component_data.groups);
    const group_key_field = unref(component_data.group_key_field);
    const records = unref(component_data.records);
    const empty_record = unref(component_data.empty_record);

    /**
     * Re-organize records for groups (from array to set of arrays organized by group)
     * Applied only for GROUP_ACCORDION and GROUP_TABLE
     */
    function arrange_by_group() {
        if(module_type.includes('GROUP_')){

            records.forEach(function (item, index) {
                // Add groups key if not exists
                records[item[group_key_field]] = records[item[group_key_field]] || [];
                // Add item to group
                let group_index = records[item[group_key_field]].length;
                records[item[group_key_field]][group_index] = records[item[group_key_field]][group_index] || {};
                Object.keys(item).forEach(function(key){
                    records[item[group_key_field]][group_index][key] = JSON.parse(JSON.stringify(item[key]));
                });
                // Remove original item
                delete records[index];
            });


            // Add empty record for each group (if no records)
            Object.keys(groups).forEach(function (key) {
              if(!records[key]){
                records[key] = [Object.assign({}, empty_record)];
                records[key][0][group_key_field] = key;
              }
            })

        }
    }

    return {arrange_by_group}
}
