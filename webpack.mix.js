const mix = require('laravel-mix');
const config = require('./webpack.config');

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

mix.webpackConfig(config);

mix.js('resources/js/app.js', 'public/js')
	.vue({ version: 2 })
	.extract(['vue', 'axios', 'vuex', 'vue-router', 'vue-i18n', 'bootstrap-vue'])
	.sass('resources/sass/app.scss', 'public/css')
	.options({
		processCssUrls: true,
		postCss: [require('autoprefixer')]
	});

if (mix.inProduction()) {
	mix.version();
} else {
	mix.sourceMaps().webpackConfig({
		devtool: 'eval-cheap-module-source-map'
	});
}
