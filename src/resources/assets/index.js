
window.Laravel = window.Laravel || {};
window.ModularForms = {};

// Loading mixins
window.ModularForms.Mixins = {
    'Accordion': require('./js/mixins/accordion.js').default,
    'Animation': require('./js/mixins/animation.js').default,
    'Cookies': require('./js/mixins/cookie.js').default,
    'Locale': require('./js/mixins/locale.js').default,
    'Payload': require('./js/mixins/payload.js').default
};
window.ModularForms.MixinsVue = {
    'ajax': require('./js/mixins-vue/ajax.mixin').default,
    'checkboxes': require('./js/mixins-vue/checkboxes.mixin.js').default,
    'filter': require('./js/mixins-vue/filter.mixin').default,
    'paginate': require('./js/mixins-vue/paginate.mixin').default,
    'sorter': require('./js/mixins-vue/sorter.mixin').default,
    'values': require('./js/mixins-vue/values.mixin').default,
};
window.ModularForms.FiltersVue = {
    'pretty_number': require('./js/mixins-vue/filters/pretty_number.js').default,
};

window.Locale = window.ModularForms.Mixins.Locale; // Alias

// Load Vuex Store
require('./js/store/store.js'); // window.ModularForms.formStore

// Load components
require('./js/module/controller.js');  // window.ModularForms.ModuleController
require('./js/table/sortable.js');     // window.ModularForms.SortableTable

// Load TEMPLATES components
window.ModularForms.Template = {
    'flag': require('./js/templates/flag.vue').default,
    'redlist_category': require('./js/templates/redlist_category.vue').default,
    'floating_dialog': require('./js/templates/dialog.vue').default
};

window.Vue.component('date', require('./js/templates/date.vue').default);
window.Vue.component('floating_dialog', require('./js/templates/dialog.vue').default);
window.Vue.component('flag', window.ModularForms.Template.flag);
window.Vue.component('gauge', require('./js/templates/gauge.vue').default);
window.Vue.component('last_update', require('./js/templates/last_update.vue').default);
window.Vue.component('progress_bar', require('./js/templates/progress_bar.vue').default);
window.Vue.component('redlist_category', window.ModularForms.Template.redlist_category);
window.Vue.component('redlist_link', require('./js/templates/redlist_link.vue').default);
window.Vue.component('user', require('./js/templates/user.vue').default);
window.Vue.component('tooltip', require('./js/templates/tooltip.vue').default);

// Load INPUT "abstract" component
window.Vue.component('selectorDialog', require('./js/inputs/components/selector/dialog.vue').default);

// Load INPUT components
window.Vue.component('checkbox-boolean', require('./js/inputs/checkbox-boolean.vue').default);
window.Vue.component('dropdown', require('./js/inputs/dropdown.vue').default);
window.Vue.component('dropdown-related', require('./js/inputs/dropdown-related.vue').default);
window.Vue.component('editor', require('./js/inputs/editor.vue').default);
window.Vue.component('rating', require('./js/inputs/rating.vue').default);
window.Vue.component('simple-date', require('./js/inputs/simple-date.vue').default);
window.Vue.component('simple-email', require('./js/inputs/simple-email.vue').default);
window.Vue.component('simple-numeric', require('./js/inputs/simple-numeric.vue').default);
window.Vue.component('simple-password', require('./js/inputs/simple-password.vue').default);
window.Vue.component('simple-text', require('./js/inputs/simple-text.vue').default);
window.Vue.component('simple-textarea', require('./js/inputs/simple-textarea.vue').default);
window.Vue.component('simple-url', require('./js/inputs/simple-url.vue').default);
window.Vue.component('selector-species_animal', require('./js/inputs/selector-species_animal.vue').default);
window.Vue.component('toggle', require('./js/inputs/toggle.vue').default);
window.Vue.component('upload', require('./js/inputs/upload.vue').default);
