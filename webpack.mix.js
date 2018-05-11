let mix = require('laravel-mix');

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
//检测文件变动，自动刷新页面
// mix.browserSync('my-domain.dev');


// mix.js('resources/assets/js/app.js', 'public/js')
//     .js('resources/assets/js/simditor.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css')
//    .sass('resources/assets/sass/simditor.scss', 'public/css');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    .copyDirectory('resources/assets/editor/js', 'public/js')
   .sass('resources/assets/sass/simditor.scss', 'public/css');

if(mix.inProduction()){
    mix.version();
}