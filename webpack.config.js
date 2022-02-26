const path = require('path');
const ChunkRenamePlugin = require('webpack-chunk-rename-plugin');

const plugins = [
	new ChunkRenamePlugin({
		initialChunksWithEntry: true,
		'/js/app': 'js/app.js',
		'/js/vendor': 'js/vendor.js'
	})
];

module.exports = {
	resolve: {
		extensions: ['.js', '.vue', '.json'],
		alias: {
			vue$: 'vue/dist/vue.esm.js',
			'@': path.join(__dirname, '/resources/js')
		}
	},
	plugins: plugins,
	output: {
		filename: '[name].js',
		chunkFilename: 'js/[name].[chunkhash:6].js'
	}
};
