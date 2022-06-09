module.exports = {
    publicPath: process.env.NODE_ENV === 'production' ? "/static" : "/",
    // publicPath: "./",
    outputDir: "../App/static",
    assetsDir: "./",
    devServer: {
      proxy: 'http://192.168.100.24:80'
    },
    css: {
      loaderOptions: {
        sass: {
          data: '@import "@/includes/_variables.scss";'
        }
      }
    }

  }
