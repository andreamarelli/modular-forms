
// Global variables - make them accessible from modules and from blade views
window.Laravel = window.Laravel || {};
window.ModularForms = {};
window.ModularFormsVendor = window.ModularFormsVendor || {};

// #############################################
// ###########  Helpers & Components  ###########
// #############################################
window.ModularForms.Helpers = window.ModularForms.Helpers || {};
window.ModularForms.Components = window.ModularForms.Components || {};

import Locale from "./js/helpers/locale.js";
window.ModularForms.Helpers.Locale = Locale;

import Animation from "./js/helpers/animation.js";
window.ModularForms.Helpers.Animation = Animation;

import Common from "./js/helpers/common.js";
window.ModularForms.Helpers.Common = Common;

// make selectorDialog component available for project custom selectors
import selectorDialog from "./js/inputs/components/selector-dialog.vue";
window.ModularForms.Components.selectorDialog = selectorDialog;

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

window.ModularForms.assetPath = '/vendor/modular-forms/';

import Accordion from './js/modules/accordion.js';
window.ModularForms.Accordion = Accordion;


// #############################################
// ##############  Images / SVGs  ##############
// #############################################

// Fonts
import.meta.glob([
    './images/*.{png,jpg,jpeg,gif,svg}',
    './fonts/*.{woff,woff2,ttf}',
    '~/@fortawesome/fontawesome-free/webfonts/*.{woff2,ttf}'
]);

// Flags
import 'flag-icons'


//
// window.ModularForms.assetPath = '/vendor/modular-forms/';
//
// mixins
// window.ModularForms.Mixins = {
//     Animation: require('./js/mixins/animation.js').default,
//     Cookies: require('./js/mixins/cookie.js').default,
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
// };
// window.ModularFormsVendor.Vue.component('date', require('./js/templates/date.vue').default);
// window.ModularFormsVendor.Vue.component('flag',  require('./js/templates/flag.vue').default),
// window.ModularFormsVendor.Vue.component('gauge', require('./js/templates/gauge.vue').default);
// window.ModularFormsVendor.Vue.component('last_update', require('./js/templates/last_update.vue').default);
// window.ModularFormsVendor.Vue.component('progress_bar', require('./js/templates/progress_bar.vue').default);
// window.ModularFormsVendor.Vue.component('redlist_category', require('./js/templates/redlist_category.vue').default);
// window.ModularFormsVendor.Vue.component('redlist_link', require('./js/templates/redlist_link.vue').default);
// window.ModularFormsVendor.Vue.component('user', require('./js/templates/user.vue').default);
// import tooltip from "./js/templates/tooltip.vue";
// window.ModularFormsVendor.Vue.app.component('tooltip', tooltip);

// const ModularForms = window.ModularForms;
// export { ModularForms };
