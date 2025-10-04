import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss', // use CSS here only if you don't want SCSS
                'resources/js/app.js'
            ],
            refresh: true, // do NOT put any "np" here
        }),
    ],
});
