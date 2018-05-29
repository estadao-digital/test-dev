// Karma configuration
// Generated on Fri Sep 18 2015 09:45:46 GMT-0300 (BRT)

module.exports = function(config) {
  config.set({

    // --------------------------------------------------------------------
    // As seguintes configurações foram definidas no gulpfile.js
    files: [],
    reporters: [],
    coverageReporter: {},
    singleRun: true,
    autoWatch: true,
    // --------------------------------------------------------------------

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine', 'jasmine-matchers'],


    // list of files to exclude
    exclude: [
        'app/components/Kernel/libs/jquery-ui.js',
        'app/components/Kernel/libs/jquery.slimscroll.min.js',
        'app/components/Kernel/directive/ui-fullscreen.js',
        'app/components/Kernel/directive/ui-jq.js',
        'app/components/Kernel/directive/ui-nav.js',
        'app/components/Kernel/directive/ui-toggleclass.js',
        'app/components/Kernel/controller/AppCtrl.js'
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
        'app/**/!(*.spec).js': 'coverage'
    },

    junitReporter: {
        outputDir: 'reports/test', // results will be saved as $outputDir/$browserName.xml
        subDir: 'browser',
        outputFile: 'test_results.xml' // if included, results will be saved as $outputDir/$browserName/$outputFile
    },

    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,

    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['PhantomJS'],
  });
};
