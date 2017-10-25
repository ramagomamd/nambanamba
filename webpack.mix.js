let mix = require('laravel-mix');
let WebpackRTLPlugin = require('webpack-rtl-plugin');

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

mix.sass('resources/assets/sass/frontend/app.scss', 'public/css/frontend.css')
    .sass('resources/assets/sass/backend/app.scss', 'public/css/backend.css')
    .js([
        'resources/assets/js/frontend/app.js',
        'resources/assets/js/plugin/sweetalert/sweetalert.min.js',
        'resources/assets/js/plugins.js'
    ], 'public/js/frontend.js')
    .js([
        'resources/assets/js/backend/app.js',
        'resources/assets/js/plugin/sweetalert/sweetalert.min.js',
        'resources/assets/js/plugins.js'
    ], 'public/js/backend.js')
    .js('resources/assets/js/backend/album.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/artist.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/category.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/genre.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/general.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/single.js', 'public/js/backend/music')
    .js('resources/assets/js/backend/track.js', 'public/js/backend/music')
    .copy('node_modules/vue-multiselect/dist/vue-multiselect.min.css', 
            'public/css/vendor/vue-multiselect/vue-multiselect.min.css')
    .webpackConfig({
        plugins: [
            new WebpackRTLPlugin('/css/[name].rtl.css')
        ]
    });

if(mix.inProduction){
    mix.version();
}