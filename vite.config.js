import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input:['resources/js/app.js','resources/js/admin.js'],
            ssr: ['resources/js/ssr.js','resources/js/admin-ssr.js'],
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
    ssr: {
        noExternal: [
            'laravel-vite-plugin',
            '@inertiajs/server',
            'vue3-google-map',
            'floating-vue',
            'vue-select',
            '@he-tree/vue'
        ],
    },
    optimizeDeps: {
        // fast-deep-equal doesnt have default export
        // https://github.com/vitejs/vite/issues/2679
        // include: ['@apollo/client/core', '@apollo/client/cache', '@apollo/client/link/context', 'fast-deep-equal'],
        // exclude: ['@apollo/react'],
    },
});
