import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [ 'resources/js/dashApp.js' ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/apps',
            '@dash': '/resources/js/dashApp.js',
        }
    },
});
