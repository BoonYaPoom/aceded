let mix = require('laravel-mix');

mix.js('resouces/js/app.js', 'public/js')
    .sourceMaps();