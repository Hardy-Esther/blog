const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .copyDirectory('resources/extra/editor/js', 'public/js')
    .copyDirectory('resources/extra/login/js', 'public/js')
    .copyDirectory('resources/extra/select2/js', 'public/js')
    .copyDirectory('resources/extra/editor/css', 'public/css')
    .copyDirectory('resources/extra/login/css', 'public/css')
    .copyDirectory('resources/extra/select2/css', 'public/css');
