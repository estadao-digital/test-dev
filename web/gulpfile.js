var gulp      = require('gulp');
var concat    = require('gulp-concat');
var uglify    = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var jshint    = require('gulp-jshint');
var stylish   = require('jshint-stylish');
var karma     = require('karma');
var path      = require('path');

// ----------------------------------------------------------------------------
// ------------------- DEFINIÇÃO DAS TAREFAS AUTOMATIZADAS --------------------
// ----------------------------------------------------------------------------

gulp.task('default', ['test:dev']);
gulp.task('watch', ['jshint', 'test'], runWatch);
gulp.task('jshint', runJshint);
// Tarefas de Testes
gulp.task('test', ['build:vendor', 'build'], singleRunTests);
gulp.task('test:dev', ['build:vendor', 'build'], watchTests);
// Tarefas de build
gulp.task('build', ['jshint', 'build:css', 'build:vendor'], buildSource);
gulp.task('build:vendor', ['jshint'], buildVendor);
gulp.task('build:css', buildCss);

// ----------------------------------------------------------------------------
// ------------------- DEFINIÇÃO DAS VARIÁVEIS UTILIZADAS ---------------------
// ----------------------------------------------------------------------------

// Variáveis de projeto
var sourceFileName = 'akfw.min.js';

// Source files são todos os arquivos da aplicação com exceção dos arquivos de
// teste unitário.
var sourceFiles = [
    'app/app.module.js',
    'app/**/*.js',
    '!app/**/*.spec.js'
];

// Source files para o jshint (não colocar arquivos do tema, pois estao fora do padrao).
var sourceJsHint = [];
sourceJsHint = sourceFiles.concat([
    '!app/components/Kernel/**/*.js'
]);

// Todos as bibliotecas utilizadas pela aplicação. Qualquer nova biblioteca que
// for utilizada pela aplicação deverá entrar nesta lista.
var vendor = [
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/angular/angular.min.js',
    'node_modules/angular-filter/dist/angular-filter.min.js',
    'node_modules/angular-ui-router/release/angular-ui-router.min.js',
    'node_modules/angular-mocks/angular-mocks.js',
    'node_modules/angular-resource/angular-resource.min.js',
    'node_modules/angular-translate/dist/angular-translate.min.js',
    'node_modules/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js',
    'node_modules/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js',
    'node_modules/angular-translate-storage-local/angular-translate-storage-local.min.js',
    'node_modules/angular-cookies/angular-cookies.min.js',
    'node_modules/ngstorage/ngStorage.min.js',
    'node_modules/angular-sanitize/angular-sanitize.min.js',
    'node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js',
    'node_modules/screenfull/dist/screenfull.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/angularjs-toaster/toaster.min.js',
    'node_modules/ng-file-upload/dist/ng-file-upload-shim.min.js',
    'node_modules/ng-file-upload/dist/ng-file-upload.min.js',
    'node_modules/ng-table/dist/ng-table.min.js',
    'node_modules/angular-animate/angular-animate.js',
    'node_modules/chosen-jquery/lib/chosen.jquery.min.js',
    'node_modules/angular-input-masks/releases/angular-input-masks-dependencies.min.js',
    'node_modules/angular-input-masks/releases/angular-input-masks.min.js',
    'node_modules/oclazyload/dist/ocLazyLoad.min.js',
    'node_modules/jquery-sparkline/jquery.sparkline.min.js',
    'node_modules/angular-ui-sortable/src/sortable.js',
    'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
    'node_modules/ng-file-upload/dist/ng-file-upload.min.js',
    'node_modules/angular-ui-select/select.min.js',
    'node_modules/amcharts/amcharts.js',
    'node_modules/amcharts/serial.js',
    'node_modules/amcharts/gauge.js',
    'node_modules/amcharts/pie.js',
    'node_modules/amcharts/themes/light.js',
    'node_modules/amcharts/themes/dark.js',
    'node_modules/amcharts/themes/black.js',
    'node_modules/amcharts/plugins/export/export.js',
    'node_modules/amcharts/plugins/export/libs/pdfmake/pdfmake.min.js',
    'node_modules/amcharts/plugins/export/libs/jszip/jszip.min.js',
    'node_modules/amcharts/plugins/export/libs/fabric.js/fabric.min.js',
    'node_modules/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js',
    'node_modules/amcharts/lang/pt.js',
    'node_modules/moment/moment.js',
    'node_modules/moment/locale/pt-br.js',
    'node_modules/angular-date-time-input/src/dateTimeInput.js',
    'node_modules/angular-bootstrap-datetimepicker/src/js/datetimepicker.js',
    'node_modules/angular-bootstrap-datetimepicker/src/js/datetimepicker.templates.js',
    'node_modules/ng-select-all-on-focus/dist/rb-select-all-on-focus.min.js',
    'node_modules/angular-ui-scroll/dist/ui-scroll.min.js'
];
// São todos os arquivos utilizados no testes. Arquivos vendor + source + specs.
var testFiles = vendor.concat([
    'app/**/app.module.js',
    'app/**/*.module.js',
    'app/**/*.js'
]);

// Arquivos que se alterados devem reexecutar a tarefa de watch.
var watches = [
    'app/**/*.js',
    'app/**/*.html'
];
// Diretório de distribuição dos arquivos source e vendor compilados.
// ATENÇÂO: Não apague este diretório pois tem outros arquivos do template.
var dist = 'assets/js/';

// ----------------------------------------------------------------------------
// ------------------- DEFINIÇÃO DE FUNÇÕES ---------------------
// ----------------------------------------------------------------------------

// Executa os tests unitários uma única vez gerando os relatórios necessários
// para o Server CI
function singleRunTests() {
    new AkerTestRunner(testFiles).run();
}

// Inicia o servidor Karma em modo watch e não gera os relatórios de CI
function watchTests() {
    gulp.watch('app/**/*', ['jshint', 'build', 'build:vendor']);
    new AkerTestRunner(testFiles).setWatchMode().run();
}

// Executa o watch do gulp
function runWatch() {
    gulp.watch(watches, ['jshint', 'test']);
}

// Executa o jshint nos arquivos source em busca de erros de sintax.
function runJshint() {
    return gulp.src(sourceJsHint)
        .pipe(jshint())
        .pipe(jshint.reporter(stylish))
        .pipe(jshint.reporter('gulp-checkstyle-jenkins-reporter', {
            filename: 'reports/checkstyle/jshint.xml'
        }))
        .pipe(jshint.reporter('fail'));
}

// Concatena os arquivos source e executa o uglify.
function buildSource() {
    return gulp.src(sourceFiles)
        .pipe(concat(sourceFileName))
        // .pipe(uglify())
        .pipe(gulp.dest(dist));
}

// Concatena os arquivos listados em vendor. Não faz o uglify porque os arquivos
// importados normalmente são os minificados e também para não haver algum
// problema de código já que são bibliotecas de terceiros.
function buildVendor() {
    return gulp.src(vendor)
        .pipe(concat('vendor.min.js'))
        .pipe(gulp.dest(dist));
}

// Concatena os arquivos css da aplicacao e de terceiros.
function buildCss() {
    return gulp.src([
        'assets/css/custom.css'
    ]).pipe(uglifycss())
        .pipe(concat('app-custom.min.css'))
        .pipe(gulp.dest('assets/css'));
}

// ----------------------------------------------------------------------------
// ------------------------- DEFINIÇÃO DE PROTOTYPES --------------------------
// ----------------------------------------------------------------------------

// Este prototype faz uma interface com o karma para executar os tests recebidos
// como parâmetro no contrutor.
function AkerTestRunner(testFiles) {
    this.setSingleRunMode();
    this.testFiles = testFiles;
}

// Define o modo do karma como SingleRunMode para o projeto
AkerTestRunner.prototype.setSingleRunMode = function() {
    this.singleRun = true;
    this.reporters = ['progress', 'coverage', 'junit'];
    this.coverageReporterTypes = [{
        type: 'text-summary'
    }, {
        type: 'html',
        dir: 'reports',
        subdir: 'coverage/html'
    }, {
        type: 'cobertura',
        dir: 'reports',
        subdir: 'coverage',
        file: 'coverage.xml'
    }];

    return this;
};

// Define o modo Watch para o ambiente de desenvolvimento
AkerTestRunner.prototype.setWatchMode = function() {
    this.reporters = ['mocha', 'coverage'];
    this.coverageReporterTypes = [{
        type: 'text-summary'
    }, {
        type: 'html',
        dir: 'reports',
        subdir: 'coverage/html'
    }];
    this.singleRun = false;

    return this;
};

// Cria e executa o servidor do Karma
AkerTestRunner.prototype.run = function() {
    var server = new karma.Server({
        configFile: path.join(__dirname, '/karma.conf.js'),
        singleRun: this.singleRun,
        autoWatch: !this.singleRun,
        files: this.testFiles,
        coverageReporter: {
            dir: 'coverage',
            reporters: this.coverageReporterTypes
        },
        reporters: this.reporters
    }, function() {});

    server.start();
};
