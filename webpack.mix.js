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

let paths = {
    sass_src: 'resources/assets/sass',
    js_src: 'resources/assets/js',
    css_public: 'public/css',
    js_public: 'public/js',
    fonts_public: 'public/fonts',
    node_modules: 'node_modules'
}

// Pages css
mix.sass(`${paths.sass_src}/pages/home.scss`, `${paths.css_public}/pages/home.css`)

// Page js
mix.js(`${paths.js_src}/pages/home.js`, `${paths.js_public}/pages/home.js`)

// Global css
mix.sass(`${paths.sass_src}/global.scss`, `${paths.css_public}/global.css`)

// Global js
mix.js([
    `${paths.js_src}/vendors/bootstrap.js`,
    `${paths.js_src}/vendors/app.js`,
], `${paths.js_public}/global.js`)

// Alias JS directory.
mix.webpackConfig({
    resolve: {
        alias: {
            rich: path.resolve(__dirname, 'resources/assets/js')
        }
    }
})
