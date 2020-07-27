window._ = require('lodash')

// npm i bootstrap
// npm i jquery
// npm i popper


try {
    window.Popper = require('popper.js').default
    window.$ = window.jQuery = require('jquery')

    require('bootstrap')

} catch (e) { }



window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'