
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import Notifications from 'vue-notification'
import moment from 'moment'

window.Vue = Vue

// Set pusher key for local and production.
if(window.location.hostname == 'richc-m.com') {
    return pusherKey = 'b84b59d73bf72a926560'
} else {
    return pusherKey = '3176398c2181a23ceb7f'
}

const customPlugin = {
    install(Vue, options) {
        // Add generate select options to Vue instance method.
        Vue.prototype.selectizeDbData = (data) => {
            return data.map(item => {
                return {
                    text: item.name,
                    value: item.id
                }
            })
        }
    }
}

window.Vue.filter('formatDate', value => {
    if (value) {
        return moment(String(value)).format('DD-MM-YYYY HH:mm:ss')
    }
})

window.Vue.use(Notifications)
window.Vue.use(customPlugin)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
