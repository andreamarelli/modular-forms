// Utilities & frameworks
window._ = require('lodash');
window.axios = require('axios');
window.$ = window.jQuery = require('jquery');

// Vue
window.Vue = require('vue');
window.vueBus = new window.Vue();

// Vuex
window.Vuex = require('vuex');
window.Vue.use(window.Vuex);