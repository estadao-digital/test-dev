var gulp = require('gulp');
var concat = require('gulp-concat');
var concatCSS = require('gulp-concat-css');
var cleanCSS = require('gulp-clean-css');
var pump = require('pump');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

gulp.task('minify-css', function(cb) {
    pump([
        gulp.src('./resources/assets/css/*.css'),
        concatCSS("./style.css"),
        cleanCSS({
            compatibility: 'ie8',
            specialComments:0
        }),
        rename({suffix: '.min'}),
        gulp.dest('./public/css')
    ],cb);
});

gulp.task('minify-core', function(cb) {
    pump([
        gulp.src([
            './resources/assets/js/jquery-3.2.1.min.js',
            './resources/assets/js/bootstrap.js',
            './resources/assets/js/lib/*.js',
        ]),
        concat('core.js'),
        uglify(),
        rename({suffix: '.min'}),
        gulp.dest('./public/js')
    ],cb);
});

gulp.task('minify-components', function(cb) {
    pump([
        gulp.src([
            './resources/assets/js/components/*.js',

        ]),
        concat('components.js'),
        uglify(),
        rename({suffix: '.min'}),
        gulp.dest('./public/js')
    ],cb);
});

gulp.task('default',['minify-css','minify-core', 'minify-components']);