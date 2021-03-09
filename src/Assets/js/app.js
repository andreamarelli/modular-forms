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

window.Locale = window.ModularForms.Mixins.Locale; // Alias

// Load components
require('./module/controller.js');  // window.ModularForms.ModuleController
require('./table/sortable.js');     // window.ModularForms.SortableTable

// Load TEMPLATES components
window.ModularForms.Template = {
    'flag': require('./templates/flag.vue').default,
    'redlist_category': require('./templates/redlist_category.vue').default,
};
window.Vue.component('date', require('./templates/date.vue').default);
window.Vue.component('flag', window.ModularForms.Template.flag);
window.Vue.component('gauge', require('./templates/gauge.vue').default);
window.Vue.component('last_update', require('./templates/last_update.vue').default);
window.Vue.component('progress_bar', require('./templates/progress_bar.vue').default);
window.Vue.component('redlist_category', window.ModularForms.Template.redlist_category);
window.Vue.component('redlist_link', require('./templates/redlist_link.vue').default);
window.Vue.component('user', require('./templates/user.vue').default);

// Load INPUT components
window.Vue.component('checkbox-boolean', require('./inputs/checkbox-boolean.vue').default);
window.Vue.component('dropdown', require('./inputs/dropdown.vue').default);
window.Vue.component('simple-date', require('./inputs/simple-date.vue').default);
window.Vue.component('simple-email', require('./inputs/simple-email.vue').default);
window.Vue.component('simple-numeric', require('./inputs/simple-numeric.vue').default);
window.Vue.component('simple-password', require('./inputs/simple-password.vue').default);
window.Vue.component('simple-text', require('./inputs/simple-text.vue').default);
window.Vue.component('simple-textarea', require('./inputs/simple-textarea.vue').default);
window.Vue.component('simple-url', require('./inputs/simple-url.vue').default);
window.Vue.component('toggle', require('./inputs/toggle.vue').default);
window.Vue.component('rating', require('./inputs/rating.vue').default);
window.Vue.component('upload', require('./inputs/upload.vue').default);
window.ModularForms.Input = {
    'modalSelector': require('./inputs/components/modal-selector.vue').default
};

// Load INPUT components (old - to be reviewed/deleted)
window.Vue.component('currency-unit', require('./inputs-old/currency-unit.vue').default);
window.Vue.component('dropdown-entity', require('./inputs-old/dropdown-entity.vue').default);
window.Vue.component('dropdown-related', require('./inputs-old/dropdown-related.vue').default);
window.Vue.component('dropdown-simple', require('./inputs-old/dropdown-simple.vue').default);
