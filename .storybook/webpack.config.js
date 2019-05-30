const path = require('path')
const {
  appSCSSLoader,
  moduleSCSSLoader,
  fileLoader
} = require(path.join(__dirname, '../webpack.common.js'))

module.exports = async ({config}) => {

  config.module.rules = [
    {
      test: /\.jsx$/,
      exclude: /node_modules/,
      loader: 'babel-loader'
    },
    {...appSCSSLoader},
    {...moduleSCSSLoader({ verbatim: false })},
    {...fileLoader}
  ]

  config.resolve.modules.push('node_modules', path.join(__dirname, '../resources/assets/js'), path.join(__dirname, '../resources/assets/img'))
  config.resolve.extensions.push('.js', '.jsx', '.json')

  return config
};
