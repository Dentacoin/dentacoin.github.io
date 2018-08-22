var webpack = require( 'webpack' ),
	NODE_ENV = process.env.NODE_ENV || 'development';

const entryPointNames = [
	'blocks',
	'components',
	'date',
	'editor',
	'element',
	'i18n',
	'utils',
	'data',
];

const packageNames = [
	'hooks',
];

const externals = {
	react: 'React',
	'react-dom': 'ReactDOM',
	'react-dom/server': 'ReactDOMServer',
	tinymce: 'tinymce',
	moment: 'moment',
	jquery: 'jQuery',
};

[ ...entryPointNames, ...packageNames ].forEach( name => {
	externals[ `@wordpress/${ name }` ] = {
		this: [ 'wp', name ],
	};
} );


var webpackConfig = {
		entry: './block.js',
		output: {
			path: __dirname,
			filename: 'block.build.js',
		},
		externals,
		module: {
			loaders: [
				{
					test: /.js$/,
					loader: 'babel-loader',
					exclude: /node_modules/,
				},
			],
		},
		plugins: [
			new webpack.DefinePlugin( {
				'process.env.NODE_ENV': JSON.stringify( NODE_ENV )
			} ),
		]
	};

if ( 'production' === NODE_ENV ) {
	webpackConfig.plugins.push( new webpack.optimize.UglifyJsPlugin() );
}

module.exports = webpackConfig;
