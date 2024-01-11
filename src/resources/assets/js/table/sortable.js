import filter from "../mixins-vue/filter.mixin";
import sorter from "../mixins-vue/sorter.mixin";
import paginate from "../mixins-vue/paginate.mixin";
import checkboxes from "../mixins-vue/checkboxes.mixin";


export default {

    mixins: [
        filter,
        sorter,
        paginate,
        checkboxes,
    ] ,

    data: function () {
        return {
            list: null,
            pageSize: 50
        }
    },

    computed: {

        items() {
            let items = this.list;
            items = this.filterList(items);     // from filter mixin
            items = this.sortList(items);       // from sorter mixin
            items = this.paginateList(items);   // from paginate mixin
            return items;
        }

    }

};
