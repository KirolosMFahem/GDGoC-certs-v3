import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/grapes.js'],
            refresh: true,
        }),
    ],
    server: {
        cors: true,
        host: '127.0.0.1',
        hmr: {
            host: '127.0.0.1',
        },
    },
});
