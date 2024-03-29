import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
// import svgLoader from 'vite-svg-loader';
import path from 'path';

/** @type {import('vite').UserConfig} */
export default defineConfig({
    define: {
        'process.env.NODE_ENV': '"development"'
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            // '~': path.resolve(__dirname, '..', 'node_modules'),
            // '@': path.resolve(__dirname, 'src/resources/assets'),
            '@common/vue': path.resolve(__dirname, 'resources/assets/js/common/vue'),
            '@component/map': path.resolve(__dirname, 'resources/assets/js/map/vue/components'),
            '@store/map': path.resolve(__dirname, 'resources/assets/js/map/vue/stores'),
        },
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                }
            },
        }),
        laravel({
            input: [
                path.resolve(__dirname, 'src', 'resources', 'assets', 'vendor.js'),
                path.resolve(__dirname, 'src', 'resources', 'assets', 'index.js'),
                path.resolve(__dirname, 'src', 'resources', 'assets', 'index.css'),
            ],
            publicDirectory: 'dist',
            refresh: true,
        }),
        // svgLoader(),
    ],
});
