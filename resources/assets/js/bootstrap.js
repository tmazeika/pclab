window._ = require('lodash');
window.$ = require('jquery');
window.axios = require('axios');

// noinspection JSUnresolvedVariable
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};
