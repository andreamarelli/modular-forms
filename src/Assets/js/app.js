window.ModularForms = {}

// Loading mixins
window.ModularForms.Mixins = {};
window.ModularForms.MixinsVue = {
    'dropdown' : require('./mixins-vue/dropdown.mixin').default,
    'filter' : require('./mixins-vue/filter.mixin').default,
    'paginate' : require('./mixins-vue/paginate.mixin').default,
    'sorter' : require('./mixins-vue/sorter.mixin').default,
    'tooltip' : require('./mixins-vue/tooltip.mixin').default,
    'values' : require('./mixins-vue/values.mixin').default
};

// Load components
require('./module/controller.js');  // window.ModuleController
require('./table/sortable.js');     // window.ModularForms.SortableTable
