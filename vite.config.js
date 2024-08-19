import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'
import { fileURLToPath, URL } from "url";

export default defineConfig({
    server: {
        hmr: {
            overlay: true,
            host: 'localhost',
            protocol: 'ws'
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                // 'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            // '@': path.resolve(__dirname, 'resources/js')
            "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
        },
    },
});
