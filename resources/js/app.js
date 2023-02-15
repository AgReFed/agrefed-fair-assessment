/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueAxios from 'vue-axios'
import axios from 'axios'

require('./bootstrap');
window.Vue = require('vue').default;

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueAxios, axios)

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

Vue.prototype.$apiUrl = window.location.origin + "/api/"

async function fetchConfig() {
    // get contents of configuration table via api
    return await axios.get(Vue.prototype.$apiUrl + "config")
        .then((response) => {
            Vue.prototype.$config =  response.data
        })
        .catch((error) => {
            console.log("error fetching config settings from db! " + error)
            return false
        });
}

// load config settings first and then create fresh Vue app instance and attach it to the page
fetchConfig().then(() => {
    const app = new Vue({
        el: '#app'
    });
})

Vue.component('assessment', require('./components/Assessment.vue').default);
Vue.component('help', require('./components/Help.vue').default);
Vue.component('assessment_list', require('./components/AssessmentList.vue').default);
Vue.component('assessment_result', require('./components/AssessmentResult.vue').default);
