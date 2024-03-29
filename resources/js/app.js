require('./bootstrap');

// InertiaJS
import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
Vue.use(InertiaApp)

// InertiaProgress
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init({
    delay: 250,
    color: '#0275d8',
    includeCSS: true,
    showSpinner: true,
})

// VueMeta
import VueMeta from 'vue-meta'
Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
})

// Routes
Vue.prototype.route = (...args) => route(...args).url()
Vue.prototype.current_route = (...args) => route().current(...args)
Vue.prototype.asset = (path) => Ziggy.baseUrl+path;

// VueToastr2
import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr')
Vue.use(VueToastr2)

// Language
Vue.prototype.__ = function(x){
    var file = x.split(".")[0]
    var key = x.split(".")[1]
    if(lang_to_vue[lang][file][key])
        return lang_to_vue[lang][file][key]
    else if(lang_to_vue["en"][file][key])
        return lang_to_vue["en"][file][key];
    return x;
}
Vue.prototype.countries = function(x){
    return lang_to_vue[lang]["countries"]
}

// Format Date
import moment from 'moment'
Vue.filter('format-date-time', function(value) {
    if (value) {
        return moment(String(value)).format('YYYY-MM-DD hh:mm')
    }
})

// VueHtmlToPaper
import VueHtmlToPaper from "vue-html-to-paper";
const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
        Vue.prototype.asset("node_modules/bootstrap/dist/css/bootstrap.css")
    ]
};
Vue.use(VueHtmlToPaper, options);

// ToggleButton
import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

// VeeValidate
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate, { fieldsBagName: 'veeFields' });
import { Validator } from 'vee-validate';
Validator.dictionary.container[lang].messages.required = Vue.prototype.__("l.This field is required")
Validator.dictionary.container[lang].messages.date_format = Vue.prototype.__("l.This field must be in the format yyyy-MM-dd")

// JQuery
$(document).on("shown.bs.modal", ".modal:not(.view)", function () {
    $('input:first', this). trigger('focus')
})

// Global Variables
Vue.prototype.colors = ["primary", "secondary", "info", "success", "warning", "danger", "black", "gray-dark", "gray", "indigo", "lightblue", "navy", "purple", "fuchsia", "pink", "maroon", "orange", "lime", "teal", "olive"]

// VueSelect
import '@desislavsd/vue-select/dist/vue-select.css'
import VueSelect from '@desislavsd/vue-select'
Vue.use(VueSelect, { /* options */ } ) // registers <v-select /> globally

// Initialize App
const app = document.getElementById('app')
new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(app)
