/**
*
*  Gulp 4 - Renato Brunetti
*  Projeto: Estado de São Paulo - TEST-DEV
*
*  Desenvolvido por: Renato Brunetti
*  Data de Criação: 26/06/2019
*
**/

'use strict'

/**
* Variáveis
**/

// [ GULP ]
const gulp = require('gulp');

// [ ESTILO ] >> SASS + COMPASS
const sass = require('gulp-sass');
const compass = require('gulp-compass');
const minifycss = require('gulp-minify-css');
const cleanCSS = require('gulp-clean-css');

// [ IMAGENS ]
const imagemin = require('gulp-imagemin');
const changed = require('gulp-changed');

// [ JAVASCRIPT ]
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const gulpUtil = require('gulp-util');

// [ SEMÂNTICA ]
const minifyHTML = require('gulp-minify-html');
const htmlclean = require('gulp-htmlclean');
const minifyInline = require('gulp-minify-inline');

// [ NAVEGADOR SYNC + WATCH ]
const browserSync = require('browser-sync').create();

// [ AUTOPREFIXERS ]
const autoprefixer    = require('gulp-autoprefixer');
const AUTOPREFIXER_BROWSERS = [
	'ie >= 10',
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4.4',
	'bb >= 10'
];

// [ DELETE ]
const del = require('del');


/**
* Projeto Atual
**/

let jobName = 'desenvolvimento/test-dev';


/**
* Caminhos
**/

let paths;
function caminho(done){
	paths = {
		htaccesss: {
			src: './'+jobName+'/assets/.htaccess',
			dest: './'+jobName+'/dist/'
		},
		favicons: {
			src: './'+jobName+'/assets/favicon.*',
			dest: './'+jobName+'/dist/'
		},
		fonts: {
			src: './'+jobName+'/assets/fonts/**/*',
			dest: './'+jobName+'/dist/fonts/'
		},
		styles: {
			src: './'+jobName+'/assets/scss/**/*.scss',
			dest: './'+jobName+'/dist/css/'
		},
		javascripts: {
			src: './'+jobName+'/assets/js/**/*.js',
			dest: './'+jobName+'/dist/js/'
		},
		jquerys: {
			src: './'+jobName+'/assets/jquery/**/*',
			dest: './'+jobName+'/dist/jquery/'
		},
		imgs: {
			src: './'+jobName+'/assets/**/*.{jpg,png,gif,svg}',
			dest: './'+jobName+'/dist/'
		},
		pdfs: {
			src: './'+jobName+'/assets/**/*.pdf',
			dest: './'+jobName+'/dist/'
		},
		jsons: {
			src: './'+jobName+'/assets/**/*.json',
			dest: './'+jobName+'/dist/'
		},
		htmls: {
			src: './'+jobName+'/assets/**/*.html',
			dest: './'+jobName+'/dist/'
		},
		phps: {
			src: './'+jobName+'/assets/**/*.php',
			dest: './'+jobName+'/dist/'
		}
	};
	done();
}


/**
* Funções
**/

// [ CLEAN ] ------------------------------------------
function clean() {
  	return del([ './'+jobName+'/dist/' ]);
}

// [ HTACCESS ] -------------------------------------------
function htaccess() {
	return gulp.src(paths.htaccesss.src)
	.pipe(gulp.dest(paths.htaccesss.dest));
}

// [ FAVICON ] ----------------------------------------
function icon() {
	return gulp.src(paths.favicons.src)
	.pipe(gulp.dest(paths.favicons.dest));
}

// [ FONTS ] -----------------------------------------
function font() {
	return gulp.src(paths.fonts.src)
	.pipe(gulp.dest(paths.fonts.dest));
}

// [ PDF ] -------------------------------------------
function pdf() {
	return gulp.src(paths.pdfs.src)
	.pipe(gulp.dest(paths.pdfs.dest));
}

// [ JSON ] -------------------------------------------
function json() {
	return gulp.src(paths.jsons.src)
	.pipe(gulp.dest(paths.jsons.dest));
}

// [ JQUERY ] ----------------------------------------
function jquery() {
	return gulp.src(paths.jquerys.src)
	.pipe(gulp.dest(paths.jquerys.dest));
}

// [ HTML ] ------------------------------------------
function html() {
	var opts = {
		conditionals: true,
		spare:true
	};
	return gulp.src(paths.htmls.src)
	.pipe(minifyHTML(opts))
	.pipe(htmlclean({}))
	.pipe(minifyInline())
	.pipe(gulp.dest(paths.htmls.dest));
}

// [ PHP ] -------------------------------------------
function php() {
	return gulp.src(paths.phps.src)
	.pipe(htmlclean({
		protect: /<\!--%fooTemplate\b.*?%-->/g,
		edit: function(html) { return html.replace(/\begg(s?)\b/ig, 'omelet$1'); }
    }))
	.pipe(gulp.dest(paths.phps.dest));
}

// [ STYLE ] -----------------------------------------
function style() {
	return gulp.src(paths.styles.src)
	.pipe(compass({
		sass: './'+jobName+'/assets/scss',
		image: './'+jobName+'/dist/img'
    }))
    .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe(sass({includePaths: ['./'+jobName+'/assets/scss/']}))
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifycss())
	.pipe(gulp.dest(paths.styles.dest));
}

// [ JAVASCRIPT ] ------------------------------------
function javascript() {
	return gulp.src(paths.javascripts.src)
	// - Main
	.pipe(jshint())
	.pipe(jshint.reporter('default'))
	.pipe(concat('main.js'))
	.pipe(gulp.dest(paths.javascripts.dest))
	// - Minimizado
	.pipe(rename({ suffix: '.min' }))
	.pipe(uglify().on('error', gulpUtil.log))
	.pipe(gulp.dest(paths.javascripts.dest));
}

// [ IMAGENS ] ---------------------------------------
function img() {
	return gulp.src(paths.imgs.src)
	.pipe(changed('./'+jobName+'/dist/'))
	.pipe(imagemin([
		imagemin.gifsicle({interlaced: true}),
		imagemin.jpegtran({progressive: true}),
		imagemin.optipng({optimizationLevel: 5}),
		imagemin.svgo({
			plugins: [
			    {removeViewBox: true},
			    {cleanupIDs: false}
			]
		})
    ]))
    .pipe(gulp.dest(paths.imgs.dest));
}

// [ SYNC ] ------------------------------------------
// BrowserSync
function sync(done) {
	browserSync.init({
		/*server: {
			baseDir: "localhost/" + jobName + "/dist/"  //Wamp
		},
		port: 3000*/
		files: jobName + "/dist/",

		proxy: "localhost/" + jobName + "/dist/"  //Wamp
	});
	done();
}
// browserSync Reload
function syncReload(done) {
	browserSync.reload();
	done();
}

// [ WATCH ] -----------------------------------------
function watch() {

	gulp.watch(paths.htaccesss.src, gulp.series(htaccess, syncReload));
	gulp.watch(paths.favicons.src, gulp.series(icon, syncReload));
	gulp.watch(paths.fonts.src, gulp.series(font, syncReload));
	gulp.watch(paths.pdfs.src, gulp.series(pdf, syncReload));
	gulp.watch(paths.jsons.src, gulp.series(json, syncReload));
	gulp.watch(paths.jquerys.src, gulp.series(jquery, syncReload));

	gulp.watch(paths.htmls.src, gulp.series(html, syncReload));
	gulp.watch(paths.phps.src, gulp.series(php, syncReload));

	gulp.watch(paths.styles.src, gulp.series(style, syncReload));
	gulp.watch(paths.javascripts.src, gulp.series(javascript, syncReload));

	gulp.watch(paths.imgs.src, gulp.series(img, syncReload));
}


/**
* Atribuições GULP
**/

// Watch
const exp_watch = gulp.series(caminho, htaccess, icon, font, pdf, json, jquery, html, php, style, javascript, img, gulp.parallel(watch, sync));

/**
* Chamadas GULP
**/

// Default
exports.default = exp_watch;