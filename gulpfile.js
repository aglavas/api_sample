var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

var gulp = require('gulp');
var swagger = require('gulp-swagger');
var Task = elixir.Task;

/**
 * Swagger yaml parser
 * @type String     command name
 * @type Function   callback function which will be triggered when command is called
 */
elixir.extend('swagger', function(input, output, options) {

    // Set defaults
    input = input || 'index-swagger.yaml';
    output = output || 'swagger.json';
    options = options || {};
    options.inputDest = options.inputDest || './resources/assets/swagger/';
    options.outputDest = options.outputDest || './public';

    // Set input for gulp-swagger
    input = options.inputDest + input;

    // Gulp task
    new Task('swagger', function() {
        return gulp.src(input)
            .pipe(swagger(output, {
                resolveInternal: false
            }))
            .pipe(gulp.dest(options.outputDest));
    })
        .watch(options.inputDest + '**');

});


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

//elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.swagger()
        .sass('app.scss')
});