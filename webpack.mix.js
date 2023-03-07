let mix = require('laravel-mix')

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
	.sass('resources/assets/sass/app.scss', 'public/css')
	.version()
	.styles([
		'node_modules/admin-lte/bootstrap/css/bootstrap.min.css',
		'node_modules/admin-lte/dist/css/AdminLTE.min.css',
		// 'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.css',
		'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.css',
		'node_modules/admin-lte/dist/css/skins/skin-blue.min.css',
	], 'public/css/admin.css')
	.scripts([
		'node_modules/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
		'node_modules/admin-lte/bootstrap/js/bootstrap.min.js',
		'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js',
		'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
		'node_modules/admin-lte/dist/js/app.min.js',
	], 'public/js/admin.js')
	.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
	.copyDirectory('resources/assets/js/page-scripts', 'public/js/page-scripts')
	// .copyDirectory('node_modules/admin-lte/bootstrap/fonts', 'public/fonts')
	// .copyDirectory('node_modules/admin-lte/plugins/datatables/images/', 'public/css/images/')
	// .copyDirectory('node_modules/slick-carousel/slick/fonts/', 'public/fonts')
	.sourceMaps()
	// .browserSync('realbrokerconnection.app')


