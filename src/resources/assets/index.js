
// Global variables - make them accessible from modules and from blade views
window.Laravel = window.Laravel || {};
window.ModularForms = {};
window.ModularFormsVendor = window.ModularFormsVendor || {}
// window.Locale = require('./js/mixins/locale.js').default;

// ############################################
// ##################  Apps  ##################
// ############################################
window.ModularForms.Apps = window.ModularForms.Apps || {};

import Base from './js/apps/Base.js';
window.ModularForms.Apps.Base = Base;

import FormErrors from './js/apps/FormErrors.js';
window.ModularForms.Apps.FormErrors = FormErrors;

import Module from "./js/apps/Module.js";
window.ModularForms.Apps.Module = Module;

// ############################################
// ##############  Local assets  ##############
// ############################################

import Accordion from './js/modules/accordion.js';
window.ModularForms.Accordion = Accordion;




//
// window.ModularForms.assetPath = '/vendor/modular-forms/';
//
// mixins
// window.ModularForms.Mixins = {
//     Animation: require('./js/mixins/animation.js').default,
//     Cookies: require('./js/mixins/cookie.js').default,
//     Locale: window.Locale, // Alias
//     Payload: require('./js/mixins/payload.js').default
// };
//
// window.ModularForms.MixinsVue = {
//     checkboxes: require('./js/mixins-vue/checkboxes.mixin.js').default,
//     filter: require('./js/mixins-vue/filter.mixin').default,
//     paginate: require('./js/mixins-vue/paginate.mixin').default,
//     sorter: require('./js/mixins-vue/sorter.mixin').default,
//     values: require('./js/mixins-vue/values.mixin').default,
// };
//
// window.ModularForms.FiltersVue = {
//     pretty_number: require('./js/mixins-vue/filters/pretty_number.js').default,
// };
//
//
// // Load VueBus
// window.vueBus = new window.ModularFormsVendor.Vue();
// window.ModularFormsVendor.Vue.use(window.ModularFormsVendor.Vuex);
//
// // Load Vuex Store
// require('./js/store/store')
//
//
// // Load components
// require('./js/module/controller.js');  // window.ModularForms.ModuleController
// // import ModuleController from "./js/module/controller";
// import SortableTable from "./js/table/sortable";
// // window.ModularForms.ModuleController = ModuleController;
// window.ModularForms.SortableTable = SortableTable;
//
// // Load TEMPLATES components
// window.ModularForms.Template = {
//     flag: require('./js/templates/flag.vue').default,
//     redlist_category: require('./js/templates/redlist_category.vue').default,
//     floating_dialog: require('./js/templates/dialog.vue').default
// };
// window.ModularFormsVendor.Vue.component('date', require('./js/templates/date.vue').default);
// window.ModularFormsVendor.Vue.component('floating_dialog', require('./js/templates/dialog.vue').default);
// window.ModularFormsVendor.Vue.component('flag',  require('./js/templates/flag.vue').default),
// window.ModularFormsVendor.Vue.component('gauge', require('./js/templates/gauge.vue').default);
// window.ModularFormsVendor.Vue.component('last_update', require('./js/templates/last_update.vue').default);
// window.ModularFormsVendor.Vue.component('progress_bar', require('./js/templates/progress_bar.vue').default);
// window.ModularFormsVendor.Vue.component('redlist_category', require('./js/templates/redlist_category.vue').default);
// window.ModularFormsVendor.Vue.component('redlist_link', require('./js/templates/redlist_link.vue').default);
// window.ModularFormsVendor.Vue.component('user', require('./js/templates/user.vue').default);
// import tooltip from "./js/templates/tooltip.vue";
// window.ModularFormsVendor.Vue.app.component('tooltip', tooltip);
//
// // Load INPUT "abstract" component
// window.ModularFormsVendor.Vue.component('selectorDialog', require('./js/inputs/components/selector/dialog.vue').default);
// window.ModularForms.MixinsVue.selectorApiSearch = require('./js/inputs/components/selector/api-search.vue').default;
//
// // Load INPUT components
// window.ModularFormsVendor.Vue.component('checkbox-boolean', require('./js/inputs/checkbox-boolean.vue').default);
// window.ModularFormsVendor.Vue.component('dropdown', require('./js/inputs/dropdown.vue').default);
// window.ModularFormsVendor.Vue.component('dropdown-related', require('./js/inputs/dropdown-related.vue').default);
// window.ModularFormsVendor.Vue.component('editor', require('./js/inputs/editor.vue').default);
// window.ModularFormsVendor.Vue.component('rating', require('./js/inputs/rating.vue').default);
// window.ModularFormsVendor.Vue.component('simple-date', require('./js/inputs/simple-date.vue').default);
// window.ModularFormsVendor.Vue.component('simple-email', require('./js/inputs/simple-email.vue').default);
// window.ModularFormsVendor.Vue.component('simple-numeric', require('./js/inputs/simple-numeric.vue').default);
// window.ModularFormsVendor.Vue.component('simple-password', require('./js/inputs/simple-password.vue').default);
// window.ModularFormsVendor.Vue.component('simple-textarea', require('./js/inputs/simple-textarea.vue').default);
// window.ModularFormsVendor.Vue.component('simple-url', require('./js/inputs/simple-url.vue').default);
// window.ModularFormsVendor.Vue.component('selector-species_animal', require('./js/inputs/selector-species_animal.vue').default);
// window.ModularFormsVendor.Vue.component('toggle', require('./js/inputs/toggle.vue').default);
// window.ModularFormsVendor.Vue.component('upload', require('./js/inputs/upload.vue').default);
//
// const ModularForms = window.ModularForms;
// export { ModularForms };

// Fonts
import.meta.glob('./fonts/*');
import.meta.glob('~/@fortawesome/fontawesome-free/webfonts/*.{woff2,ttf}');

// Flags
import 'flag-icons'
