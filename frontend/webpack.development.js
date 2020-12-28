const { resolve } = require('path')

const { HotModuleReplacementPlugin } = require('webpack')
const HtmlWebpackPlugin = require('html-webpack-plugin')

const PUBLIC_DIR = resolve(__dirname, '../web')

module.exports = {
  mode: 'development',
  entry: {
    app: resolve(__dirname, 'app.js')
  },
  output: {
    path: PUBLIC_DIR
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
      },
      {
        test: /\.css$/,
        use: [
          {
            loader: 'css-loader'
          }
        ]
      }
    ]
  },
  plugins: [
    new HotModuleReplacementPlugin(),
    new HtmlWebpackPlugin({
      appMountId: 'app',
      meta: {
        charset: 'utf-8',
        viewport: 'width=device-width, initial-scale=1'
      },
      template: resolve(PUBLIC_DIR, 'index.html')
    })
  ],
  devServer: {
    contentBase: PUBLIC_DIR,
    historyApiFallback: true,
    host: '0.0.0.0',
    hot: true,
    open: false,
    port: 1234,
    proxy: {
      '/api': {
        target: 'http://localhost:8080',
        pathRewrite: { '^/api': '' }
      }
    }
  },
  devtool: 'cheap-source-map',
  stats: 'minimal'
}
