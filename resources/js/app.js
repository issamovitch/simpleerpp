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

// JQuery
$(document).on("shown.bs.modal", ".modal", function () {
    $('input:first', this). trigger('focus')
})

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
