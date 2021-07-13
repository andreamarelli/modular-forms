const path = require('path');
const { VueLoaderPlugin } = require('vue-loader')

module.exports = {

    entry: {
        index: './src/assets/js/app.js',
        vendor: './src/assets/js/vendor.js',
        vendor_leaflet: './src/assets/js/vendor.js',
        style: './src/assets/sass/app.scss',
        vendor_style: './src/assets/sass/vendor.scss',
    },

    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'modular_forms_[name].js'
    },

    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '~$': path.resolve(__dirname, '../', 'node_modules/'),
            'assets': path.resolve(__dirname, 'src/', 'assets/'),
            'fonts': path.resolve(__dirname, 'src/', 'assets/', 'fonts/'),
        }
    },

    module: {
        rules: [
            {
                test: /\.[s]*css$/,
                use: [
                    'vue-style-loader',
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ],
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.(png|jpg|gif)$/i,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192,
                            name: '[name].[ext]',
                            outputPath: 'images'
                        },
                    },
                ],
            },
            {
                test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
                exclude: /flags\/\dx\d\/([a-z\-]+).svg$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts'
                    }
                }]
            },
            {
                test: /flags\/4x3\/([a-z\-]+).svg$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'flags/4x3'
                    }
                }]
            },
            {
                test: /flags\/1x1\/([a-z\-]+).svg$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'flags/1x1'
                    }
                }]
            }
        ],
    },

    plugins: [
        new VueLoaderPlugin()
    ]
};
