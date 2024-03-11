import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
//import purge from '@sakadda/vite-plugin-laravel-purgecss'
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import vue from '@vitejs/plugin-vue'
import DefineOptions from 'unplugin-vue-define-options/vite'

export default defineConfig({
    plugins: [
        DefineOptions(),
        vue(),
        // purge([
        //    'svg'
        // ]),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        ViteImageOptimizer()
    ],
});
