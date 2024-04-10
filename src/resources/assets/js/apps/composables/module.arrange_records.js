import {computed, unref} from "vue";

export function useArrangeRecords(component_data) {

    const module_type = unref(component_data.module_type);
    const common_fields = unref(component_data.common_fields);
    const groups = unref(component_data.groups);
    const group_key_field = unref(component_data.group_key_field);
    const records = unref(component_data.records);
    const empty_record = unref(component_data.empty_record);

    // Computed variables
    const common_fields_names = computed(() => common_fields.map((f => f['name'])));

    /**
     * Inject common fields values into empty record
     */
    function common_fields_in_empty_record(){
        let new_empty_record = Object.assign({}, empty_record);
        Object.keys(empty_record).forEach(function (key) {
            if(common_fields_names.value.includes(key)) {
                new_empty_record[key] = records[0][key];
            }
        });
        return new_empty_record;
    }

    /**
     * Re-organize records for groups (from array to set of arrays organized by group)
     * Applied only for GROUP_ACCORDION and GROUP_TABLE
     */
    function arrange_by_group(input_records) {

        const arranged_records = input_records || records;

        if(module_type.includes('GROUP_')){

            let records_by_group = {};
            // Add groups keys
            Object.keys(groups).forEach(function (key) {
                records_by_group[key] = [];
            });
            // Sort existing records (from plain records array) into groups
            arranged_records.forEach(function (item) {
                if (item[group_key_field] !== null) {
                    let group_key = item[group_key_field];
                    if(group_key in records_by_group){
                        records_by_group[group_key].push(item);
                    }
                }
            });
            // Add empty record for each group (if no records)
            Object.keys(records_by_group).forEach(function (key) {
                if (records_by_group[key].length === 0) {
                    records_by_group[key].push(Object.assign({}, empty_record));
                    records_by_group[key][0][group_key_field] = key;
                }
            });
            return records_by_group;
        }
        return arranged_records;
    }

    return {common_fields_in_empty_record, arrange_by_group}
}
