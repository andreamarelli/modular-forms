// Utilities & frameworks
window._ = require('lodash');
window.axios = require('axios');
window.$ = window.jQuery = require('jquery');

// Vue
window.Vue = require('vue').default;
window.vueBus = new window.Vue();

// Vuex
window.Vuex = require('vuex');
window.Vue.use(window.Vuex);

// Bootstrap + related packages
require('bootstrap');
require('bootstrap-select');
require('bootstrap-datepicker');
require('select2');
require('select2/dist/js/i18n/fr');
window.$.fn.select2.defaults.set("theme", "bootstrap");

// Other packages
window.AutoNumeric = require('autonumeric');
