
// Load other js files
require('./module/controller.js');


// Loading mixins
import filter from './mixins-vue/filter.mixin';
import sorter from './mixins-vue/sorter.mixin';
import paginate from './mixins-vue/paginate.mixin';
window.Mixins = {};
window.MixinsVue = {
    'filter' : filter,
    'sorter' : sorter,
    'paginate' : paginate,
};
