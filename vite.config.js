import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Global styles (e.g., Tailwind + Bootstrap)
                'resources/js/app.js',  // Global scripts (e.g., Bootstrap)
            ],
            refresh: true,
        }),
    ],
});