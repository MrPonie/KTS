import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/components/navlist.js',
                'resources/js/components/user_button.js',
                'resources/js/components/select_search.js',
            ],
            refresh: true,
        }),
    ],
});
