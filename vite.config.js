import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // Add this line to import the Vue plugin

export default defineConfig({
    plugins: [
        vue(), // Ensure the Vue plugin is included here
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
