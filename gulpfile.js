"use strict";

var autoPrefixBrowserList = ['last 2 version', 'safari 5', 'ie 11', 'opera 12.1', 'ios 6', 'android 4'];

const gulp = require("gulp");
const sass = require("gulp-dart-sass");
sass.compiler = require("node-sass");
const gutil = require('gulp-util');

const autoprefixer = require('gulp-autoprefixer');

gulp.task('dev', watch);
gulp.task('sass-dev', gulp.series([
    compilaSassDev
]));
gulp.task('sass-prod', gulp.series([
    compilaSassProd    
]));

function watch() {
    gulp.watch(["src/_scss/*.scss"], gulp.series([
       compilaSassProd    
    ]));
}

function compilaSassDev(){
    return gulp
    .src("src/_scss/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(autoprefixer({overrideBrowserslist: autoPrefixBrowserList, cascade: true}))
    .pipe(gulp.dest('dist/css'));
}

function compilaSassProd(){
    return gulp
    .src(['src/_scss/*.scss'])
    .pipe(sass({outputStyle: "compressed"}).on("error", sass.logError))
    .pipe(autoprefixer({overrideBrowserslist: autoPrefixBrowserList,cascade: true}))
    .pipe(gulp.dest('dist/css'));
}
