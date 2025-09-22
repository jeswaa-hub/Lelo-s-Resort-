import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/components/loading-screen.css',
                'resources/js/components/loading-screen.js',
            ],
            refresh: true,
        }),
    ],
});
