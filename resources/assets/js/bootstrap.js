
// window._ = require('lodash')
window.Promise = require('bluebird')
window.Promise.config({
    warnings: true
})

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // window.moment = require('moment')
    window.moment = require('moment-timezone')
    window.$ = window.jQuery = window.jquery = require('jquery')
    window.SimpleBar = require('simplebar')

    require('bootstrap-sass')
    require('bootstrap-datepicker')
    require('slick-carousel')
    window.politespace = require('politespace')
    // window.Dropzone = require('dropzone')
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found')
}

/**
 * Register the jwt token as a common header so that api calls will send it along
 * automatically.
 */
let jwt = document.head.querySelector('meta[name="jwt-token"]')
if (jwt) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${jwt.content}`
}

window.axios.interceptors.response.use(function(response) {
    const token = response.headers.authorization
    window.axios.defaults.headers.common['Authorization'] = token

    return response;
}, function (error) {
    return Promise.reject(error)
})
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

if (window.pusher_key) {
    window.Pusher = require('pusher-js')
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: window.pusher_key,
        cluster: 'us2',
        encrypted: true
    })
}
