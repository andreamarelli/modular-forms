import {unref} from "vue";

export function useArrangeRecords(component_data) {

    const module_type = component_data.module_type;
    const group_key_field = component_data.group_key_field;
    const accordion_title_field = component_data.accordion_title_field;
    const records = unref(component_data.records);

    function accordionTitles(){
        let accordion_titles = [];
        if(module_type === 'ACCORDION') {
            records.forEach((record, index) => {
                let title = record[accordion_title_field] || '';
                accordion_titles.push(title);
            });
        } else if(module_type === 'GROUP_ACCORDION') {
            records.forEach((record, index) => {
                let group_key = record[group_key_field];
                let title = record[accordion_title_field] || '';
                accordion_titles[group_key] = accordion_titles[group_key] || [];
                accordion_titles[group_key].push(title);
            });
        }
        return accordion_titles;
    }

    function recordIsInGroup(record, group_key) {
        if(module_type.includes('GROUP_')){
            return record[group_key_field] === group_key;
        }
        return true;
    }

    function numRecordsInGroup(group_key) {
        if(module_type.includes('GROUP_')){
            return records.filter(record => record[group_key_field] === group_key).length;
        }
        return records.length;
    }

    function indexInGroup(index, group_key){
        if(module_type.includes('GROUP_')){

            let group_index = 0;
            records.forEach((record, i) => {

                if(record[group_key_field] === group_key && i <= index){
                    group_index++;
                }

            });

            return group_index - 1;
        }
        return index + 1;
    }

    return {
        accordionTitles,
        recordIsInGroup,
        numRecordsInGroup,
        indexInGroup
    }
}
