const path = require('path');
const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');

module.exports = merge(common, {
    mode: 'production',

    output: {
        filename: 'modular_forms_[name].debug.js'
    },
});
