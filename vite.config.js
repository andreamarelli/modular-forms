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
    build:{
        outDir: 'dist',
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                index: 'src/resources/assets/index.js',
                css: 'src/resources/assets/index.css'
            },
            output: {
                assetFileNames: assetInfo => {
                    if (/\.woff$/.test(assetInfo.name)
                        || /\.woff2$/.test(assetInfo.name)
                        || /\.ttf$/.test(assetInfo.name)) {
                        return 'assets/fonts/[name][extname]'
                    } else if(/\.svg$/.test(assetInfo.name)){
                        return 'assets/svg/[name][extname]'
                    }
                    return 'assets/[name]-[hash][extname]'
                }
            },
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@assets': path.resolve(__dirname, 'src/resources/assets/'),
            '~': path.resolve(__dirname, 'node_modules/'),
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
    ]
});
