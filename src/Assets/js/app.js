window.ModularForms = {}

// Loading mixins
window.ModularForms.Mixins = {
    'Animation': require('./mixins/animation.js').default,
    'Input': require('./mixins/input.js').default,
    'Locale': require('./mixins/locale.js').default
};
window.ModularForms.MixinsVue = {
    'dropdown': require('./mixins-vue/dropdown.mixin').default,
    'filter': require('./mixins-vue/filter.mixin').default,
    'paginate': require('./mixins-vue/paginate.mixin').default,
    'sorter': require('./mixins-vue/sorter.mixin').default,
    'tooltip': require('./mixins-vue/tooltip.mixin').default,
    'values': require('./mixins-vue/values.mixin').default
};

// Load components
require('./module/controller.js');  // window.ModuleController
require('./table/sortable.js');     // window.ModularForms.SortableTable

// Load INPUT components (old - to be reviewed/deleted)
Vue.component('currency-unit', require('./inputs/old/currency-unit.vue').default);
Vue.component('dropdown-simple', require('./inputs/old/dropdown-simple.vue').default);
Vue.component('dropdown-entity', require('./inputs/old/dropdown-entity.vue').default);
Vue.component('dropdown-related', require('./inputs/old/dropdown-related.vue').default);
