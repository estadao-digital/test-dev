/*
module.exports = {
  publicPath: process.env.NODE_ENV === 'development' ? process.env.BASE_URL : 'localhost/'
}*/

module.exports = {
  chainWebpack: config => {
    config
      .plugin('html')
      .tap(args => {
        args[0].title = 'Carros - Estadão'
        return args
      })
  }
}
