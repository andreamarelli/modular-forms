const path = require('path');
const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');

module.exports = merge(common, {
    mode: 'development',

    output: {
        path: path.resolve(__dirname, 'dist/prod'),
        filename: 'modular_forms_[name].js'
    }

});
