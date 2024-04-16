import {ref} from "vue";

export function useList(component_data) {

    const sortBy = ref(component_data.sortBy || null);
    const sortDir = ref(component_data.sortDir || 'asc');

    function sortList(items){
        return sortBy!==null
            ? sorter(items)
            : items;
    }

    function sorter(data){
        return data.sort(function (a, b) {
            let dir = sortDir.value==='asc' ? 1 : -1;
            let text_a = getAttribute(a, sortBy.value || '');
            let text_b = getAttribute(b, sortBy.value || '');
            if(typeof text_a !== "undefined" && typeof text_b !== "undefined"){
                if(text_a.toString().toLowerCase() > text_b.toString().toLowerCase()){ return dir; }
                if(text_a.toString().toLowerCase() < text_b.toString().toLowerCase()){ return -1*dir; }
            }
            return 0;
        });
    }

    function getAttribute (item, attribute){

        let value = null;

        /* More than 1 level deep */
        if(attribute.includes('.')){
            let path = attribute.split('.');
            value = item;
            for (let i = 0; i < path.length; ++i) {
                value = value.hasOwnProperty(path[i]) ? value[path[i]] : '';
            }
        }
        /* simple attribute */
        else {
            value = item[attribute];
        }

        value = value===null ? '' : value;

        return value;
    }

    return {sortList}

}
