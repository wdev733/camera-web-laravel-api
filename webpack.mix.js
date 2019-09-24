const mix = require('laravel-mix');

const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

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
    .sass('resources/sass/theme.scss', 'public/css');
mix.copy('resources/css/mask.css', 'public/css/mask.css');
// Copy images from resources/img folder to assets/img folder
mix.webpackConfig({
    plugins: [
        new CopyWebpackPlugin([{
            from: 'resources/img',
            to: 'assets/img', // Laravel mix will place this in 'public/assets/img'
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i,
            plugins: [
                imageminMozjpeg({
                    quality: 80,
                })
            ]
        })
    ]
});
