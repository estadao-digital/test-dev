var gulp    = require('gulp');
var minifyCSS = require('gulp-minify-css');
var uglify  = require('gulp-uglify');
var htmlmin = require('gulp-htmlmin');

var concat = require('gulp-concat');
var stripDebug = require('gulp-strip-debug');
var rename = require('gulp-rename'); 


var autoprefix = require('gulp-autoprefixer');


var jsStart = '../base/js/',  
    jsDest = 'global/js',
    cssStart = '',  
    cssDest = 'global/css';


gulp.task('default', function () {	



 	gulp.src(cssStart+'/**/*.css')
 	.pipe(concat('main.css'))
    .pipe(minifyCSS())   
  	.pipe(gulp.dest(cssDest))



    gulp.src([
    jsStart+'/vendor/jquery-1.11.3.min.js',
    jsStart+'/vendor/modernizr-2.8.3.min.js',
    jsStart+'/bootstrap/bootstrap.js',
    jsStart+'/angular.js',
    jsStart+'/main.js',
    jsStart+'/jquery.maskedinput.js']) 
    .pipe(concat('script-global.js'))
    .pipe(gulp.dest(jsDest))
    .pipe(concat('script-global.min.js'))
    .pipe(uglify())
    .pipe(stripDebug())
    .pipe(gulp.dest(jsDest));
   

	/*gulp.src('*.php')
    .pipe(htmlmin({collapseWhitespace: true}))
    .pipe(gulp.dest('min'))*/

});

