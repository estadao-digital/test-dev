const path = require('path');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

var config = {
    entry: path.resolve(__dirname, './index.js'),

    mode: 'development',

    module: {
        rules: [
            { test: /\.js$/, use: "babel-loader", exclude: /node_modules/ },
            {
                test: /\.scss$/,
                use: ["style-loader", "css-loader", 'sass-loader?outputStyle=expanded']
            },
            {
                test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2)$/,
                use: {
                    loader: "url-loader",
                    options: {
                        limit: 8192,
                        publicPath: path.resolve(__dirname, 'dist/assets'),
                        outputPath: 'assets',
                    }
                }
            },
        ]
    },

    resolve: {
        extensions: ['.js']
    },

    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist')
    },
    plugins: []
};

module.exports = (env, argv) => {
    if (argv.mode === 'development') {
        config.plugins = [
            new BrowserSyncPlugin({
                host: 'localhost',
                port: 3000,
                server: { baseDir: ['./'] }
            }),
        ];
        config.devtool = 'inline-source-map';
    }
    return config;
};