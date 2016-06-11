var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

console.log(__dirname);

elixir(function(mix) {
    mix.less('variables.less', __dirname + '/resources/assets/css/bootstrap.css');
    mix.styles([
            '/resources/assets/css/bootstrap.css',
            'app.css'
        ], __dirname + '/public/css/style.css');

    mix.copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js');
    mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
    mix.copy('resources/assets/js/app.js', 'public/js/app.js');
});
