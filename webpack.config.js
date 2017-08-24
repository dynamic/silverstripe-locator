/* global process */
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const Path = require('path');

const env = process.env.NODE_ENV || 'dev';

const paths = {
  srcJs: Path.resolve('client', 'src', 'js'),
  srcSass: Path.resolve('client', 'src', 'scss'),
  dist: Path.resolve('client', 'dist'),
};

module.exports = {
  entry: {
    main: Path.join(paths.srcJs, 'boot', 'index.jsx'),
    // map: Path.join(paths.srcSass, 'main.scss'),
  },
  output: {
    path: paths.dist,
    filename: Path.join('js', '[name].js'),
  },
  devtool: (env !== 'production') ? 'source-map' : false,
  resolve: {
    modules: [
      paths.srcSass,
      paths.srcJs,
      'node_modules',
    ],
    alias: {
      'handlebars': 'handlebars/dist/handlebars.js',
    },
    extensions: ['.js', '.jsx', '.json'],
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /(node_modules)/,
        loader: 'babel-loader',
        options: {
          presets: [
            ['es2015', { modules: false }],
            'es2016',
            'es2017',
            'react',
          ],
          plugins: ['transform-object-rest-spread'],
          comments: false,
          cacheDirectory: (env !== 'production'),
        },
      },
      {
        test: /\.scss$/,
        loader: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            {
              loader: 'css-loader',
              options: {
                sourceMap: true,
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                sourceMap: true,
                plugins: [
                  autoprefixer(),
                ],
              },
            },
            {
              loader: 'resolve-url-loader',
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true,
                includePaths: [paths.srcSass, paths.srcJs],
              },
            },
          ],
          // to counter the `css/` in the ExtractTextPlugin() call
          publicPath: '../',
        }),
      },
      {
        test: /\.(png|gif|jpe?g|svg)$/,
        loader: 'file-loader',
        options: {
          name: Path.join('images', '[name].[ext]'),
        },
      },
    ],
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: JSON.stringify(env),
      },
    }),
    new webpack.optimize.CommonsChunkPlugin({
      names: ['vendor'],
      // move any modules inside "node_modules" to inside the vendor dist file
      minChunks: module => module.context && module.context.indexOf('/node_modules/') > -1,
    }),
    new ExtractTextPlugin({ filename: Path.join('css', '[name].css'), allChunks: true }),
  ],
};
