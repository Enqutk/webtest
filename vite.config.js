import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/kimem-landing.css',
                'resources/js/kimem-landing.js',
            ],
            refresh: true,
        }),
    ],
});
