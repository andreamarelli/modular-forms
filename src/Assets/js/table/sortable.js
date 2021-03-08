window.ModularForms.SortableTable = Vue.extend({

    mixins: [
        window.MixinsVue.filter,
        window.MixinsVue.sorter,
        window.MixinsVue.paginate
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

});
