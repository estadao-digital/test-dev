'use strict';

var logger = require('../modules/logger');

var name = 'webpack-dev-server'; // default level is set on the client side, so it does not need
// to be set by the CLI or API

var defaultLevel = 'info';

function setLogLevel(level) {
  logger.configureDefaultLogger({
    level: level
  });
}

setLogLevel(defaultLevel);
module.exports = {
  log: logger.getLogger(name),
  setLogLevel: setLogLevel
};