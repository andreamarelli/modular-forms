// Utilities & frameworks
window._ = require('lodash');
window.axios = require('axios');
window.$ = window.jQuery = require('jquery');

// Temporary replacement for mariuzzo/laravel-js-localization (need to wait support for packages loadTranslationsFrom method)
// Pull request #149 (https://github.com/rmariuzzo/Laravel-JS-Localization/pull/149)
import I18n from 'vendor/conedevelopment/i18n/resources/js/I18n.js';
window.I18n = I18n;

// Vue
window.Vue = require('vue').default;
window.vueBus = new window.Vue();

// Vuex
window.Vuex = require('vuex');
window.Vue.use(window.Vuex);

// Bootstrap
require('bootstrap');

// Other packages
window.AutoNumeric = require('autonumeric');
window.Base64 = require('js-base64');
window.CKEditor = require( '@ckeditor/ckeditor5-vue2' )
window.ClassicEditor = require( '@ckeditor/ckeditor5-build-classic' )

// AirDatepicker
import AirDatepicker from 'air-datepicker';
import AirDatepicker_locale_en from 'air-datepicker/locale/en';
import AirDatepicker_locale_fr from 'air-datepicker/locale/fr';
import AirDatepicker_locale_sp from 'air-datepicker/locale/es';
import AirDatepicker_locale_pt from 'air-datepicker/locale/pt';
window.AirDatepicker = AirDatepicker;
window.AirDatepicker.locale = {
    'en': AirDatepicker_locale_en,
    'fr': AirDatepicker_locale_fr,
    'sp': AirDatepicker_locale_sp,
    'pt': AirDatepicker_locale_pt,
}

