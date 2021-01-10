"use strict";

var autoPrefixBrowserList = ['last 2 version', 'safari 5', 'ie 11', 'opera 12.1', 'ios 6', 'android 4'];

// var jsonSass = require('gulp-json-scss');
const gulp = require("gulp");
const sass = require("gulp-dart-sass");
sass.compiler = require("node-sass");
const gutil = require('gulp-util');

const autoprefixer = require('gulp-autoprefixer');

gulp.task('dev', watch);
gulp.task('sass-dev', gulp.series([
    compilaJsonVars,
    compilaSassDev
]));
gulp.task('sass-vars', compilaJsonVars);
gulp.task('sass-prod', gulp.series([
    compilaJsonVars,
    compilaSassProd    
]));

function watch() {
    gulp.watch(["_scss/*.scss"], gulp.series([
       compilaSassProd    
    ]));
}

function compilaSassDev(){
    return gulp
    .src("_scss/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(autoprefixer({overrideBrowserslist: autoPrefixBrowserList, cascade: true}))
    .pipe(gulp.dest('assets/css'));
}

function compilaSassProd(){
    return gulp
    .src(['_scss/*.scss'])
    .pipe(sass({outputStyle: "compressed"}).on("error", sass.logError))
    .pipe(autoprefixer({overrideBrowserslist: autoPrefixBrowserList,cascade: true}))
    .pipe(gulp.dest('assets/css'));
}
