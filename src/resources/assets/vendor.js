window.ModularFormsVendor = {}

// Utilities & frameworks
window.ModularFormsVendor.jQuery = require('jquery');
window.$ = window.ModularFormsVendor.jQuery // Alias

// Temporary replacement for mariuzzo/laravel-js-localization (need to wait support for packages loadTranslationsFrom method)
// Pull request #149 (https://github.com/rmariuzzo/Laravel-JS-Localization/pull/149)
// TODO: check if possible to switch back to mariuzzo/laravel-js-localization
import I18n from 'vendor/conedevelopment/i18n/resources/js/I18n.js';
window.ModularFormsVendor.I18n = I18n;

// Vue
window.ModularFormsVendor.Vue = require('vue').default;
window.Vue = window.ModularFormsVendor.Vue;     // Alias
window.ModularFormsVendor.Vuex = require('vuex');

// Other packages
window.ModularFormsVendor.AutoNumeric = require('autonumeric');
window.ModularFormsVendor.Base64 = require('js-base64');

// Vue-select
import vSelect from 'vue-select';
window.ModularFormsVendor.vSelect = vSelect;

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
window.ModularFormsVendor.Vue.use(CKEditor); // make the component global
window.ModularFormsVendor.ClassicEditor = ClassicEditor;

// AirDatepicker
import AirDatepicker from 'air-datepicker';
import AirDatepicker_locale_en from 'air-datepicker/locale/en';
import AirDatepicker_locale_fr from 'air-datepicker/locale/fr';
import AirDatepicker_locale_sp from 'air-datepicker/locale/es';
import AirDatepicker_locale_pt from 'air-datepicker/locale/pt';
window.ModularFormsVendor.AirDatepicker = AirDatepicker;
window.ModularFormsVendor.AirDatepicker.locale = {
    'en': AirDatepicker_locale_en,
    'fr': AirDatepicker_locale_fr,
    'sp': AirDatepicker_locale_sp,
    'pt': AirDatepicker_locale_pt,
}

// Floating UI (former Popper.js)
import {computePosition, autoUpdate, flip, shift, offset, arrow, size} from '@floating-ui/dom';
window.ModularFormsVendor.FloatingUI = {
    'computePosition': computePosition,
    'autoUpdate': autoUpdate,
    'flip': flip,
    'shift': shift,
    'offset': offset,
    'arrow': arrow,
    'size': size
};

const ModularFormsVendor = window.ModularFormsVendor;
export { ModularFormsVendor };
