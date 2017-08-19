import axios from 'axios'

window.axios = axios

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
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

// Add a request interceptor.
window.axios.interceptors.request.use(config => {

    // Do something before request is sent.
    $('.page-loading').show()

    return config
}, error => {
    // Do something with request error
    return Promise.reject(error);
});

// Add a response interceptor
window.axios.interceptors.response.use(response => {

    // Do something with response data.
    $('.page-loading').hide()

    return response
}, error => {
    // Do something with response error
    $('.page-loading').hide()

    return Promise.reject(error);
});
