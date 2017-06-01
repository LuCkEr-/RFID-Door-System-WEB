const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .scripts([
       'bower_components/jquery/dist/jquery.js',
       'bower_components/bootstrap/dist/js/bootstrap.js',
       'bower_components/metisMenu/dist/metisMenu.js',
       'resources/assets/js/sb-admin-2.js',
       'bower_components/datatables/media/js/jquery.dataTables.js',
       'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js',
       'bower_components/datatables-responsive/js/dataTables.responsive.js'
   ], 'public/js/bundle.js')
   .styles([
       'bower_components/metisMenu/dist/metisMenu.css',
       'resources/assets/css/sb-admin-2.css',
       'bower_components/datatables/media/css/dataTables.bootstrap.css',
       'bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
       'node_modules/vue2-autocomplete-js/dist/style/vue2-autocomplete.css'
   ], 'public/css/bundle.css')
   .less('resources/assets/less/sb-admin-2.less', 'public/css')
   .less('bower_components/font-awesome/less/font-awesome.less', 'public/css')
   .less('bower_components/bootstrap/less/bootstrap.less', 'public/css')
   .extract(['vue', 'axios', 'debounce', 'element-ui']);

mix.browserSync({
    proxy: 'rfid-door-system-web.app',
    host: '192.168.10.9',
    open: false,
    notify: false
});
