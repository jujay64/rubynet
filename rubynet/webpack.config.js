require("babel-polyfill");

var config = {
   devtool: 'cheap-module-eval-source-map',
   entry: {
    main: [
      // configuration for babel6
      ['babel-polyfill', './src/js/main.js']
    ]
  },
 }