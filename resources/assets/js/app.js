
window._ = require('lodash');
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}