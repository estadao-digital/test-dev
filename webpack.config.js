const path = require('path');
module.exports = {
  entry: './src/_js/app.js',
  output: {
    path: path.resolve(__dirname, 'dist/js'),
    filename: 'app.js'
  }
};