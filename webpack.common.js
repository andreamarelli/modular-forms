const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { VueLoaderPlugin } = require('vue-loader')
const CopyPlugin = require("copy-webpack-plugin");
const tailwindcss = require('tailwindcss');

module.exports = {

    entry: {
        index: ['./src/resources/assets/index.js', './src/resources/assets/index.scss'],
        vendor: ['./src/resources/assets/vendor.js']
    },

    output: {
        path: path.resolve(__dirname, 'dist'),
    },

    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '~$': path.resolve(__dirname, '..', 'node_modules'),
            'vendor': path.resolve(__dirname, 'vendor'),
            'assets': path.resolve(__dirname, 'src', 'resources', 'assets'),
            'fonts': path.resolve(__dirname, 'src', 'resources', 'assets', 'fonts'),
        }
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                enforce: "pre",
                use: ["source-map-loader"],
            },
            {
                test: /\.[s]*css$/,
                use: [
                    'vue-style-loader',
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            esModule: false,
                        },
                    },
                    'css-loader',
                    'postcss-loader',
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
                            outputPath: 'images',
                            publicPath: 'images'
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
                        outputPath: 'fonts',
                        publicPath: 'fonts'
                    }
                }]
            },
            {
                test: /flags\/4x3\/([a-z\-]+).svg$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'flags/4x3',
                        publicPath: 'flags/4x3'
                    }
                }]
            },
            {
                test: /flags\/1x1\/([a-z\-]+).svg$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'flags/1x1',
                        publicPath: 'flags/1x1'
                    }
                }]
            }
        ],
    },

    plugins: [
        tailwindcss,
        new VueLoaderPlugin(),
        new CopyPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, 'src', 'resources', 'assets', 'images'),
                    to: path.resolve(__dirname, 'dist', 'images')
                },
            ],
        }),
    ]
};
