const path = require('path');
const { VueLoaderPlugin } = require('vue-loader')

module.exports = {
    entry: {
        modular_forms: './src/assets/js/app.js',
        modular_forms_vendor: './src/assets/js/vendor.js',
        modular_forms_vendor_leaflet: './src/assets/js/vendor.js',
        modular_forms_style: './src/assets/sass/app.scss',
        modular_forms_vendor_style: './src/assets/sass/vendor.scss',
    },

    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].bundle.js'
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
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader',
                ],
            },
            {
                test: /\.scss$/i,
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
                test: /flags\/\dx\d\/([a-z\-]+).svg$/,
                // type: 'asset/inline'
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[path][name].[ext]',
                        outputPath: 'flags'
                    }
                }]
            }
        ],
    },

    plugins: [
        new VueLoaderPlugin()
    ]
};
