/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
let moment = require('moment');
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue' //Importing
window.Vue = require('vue').default;
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('bot-form', require('./components/bot/BotForm.vue').default);
Vue.component('expert-icons', require('./components/expertsIcon/ExpertIcons.vue').default);
Vue.component('bot-list', require('./components/bot/BotList.vue').default);
Vue.component('bot-trades', require('./components/bot/BotTrades.vue').default);
Vue.component('session-stats', require('./components/partials/SessionStats').default);
Vue.component('bot-stats', require('./components/partials/BotStats').default);
Vue.component('market-widget', require('./components/widgets/MarketWidget').default);
axios.defaults.headers.common = {'Authorization': `Bearer ${window.API_TOKEN}`, 'Content-Type': `application/json`}
Vue.prototype.$isAdmin = window.IS_ADMIN;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.mixin({
    methods: {
        datetimeFormat: datetime => {
            if(datetime !== null) {
                return moment.utc(datetime).local().format("YYYY-MM-DD hh:mm A")
            } else {
                return 'NA';
            }

        },
        tradeTypes: function tradeTypes(trade) {
            var tradeType = 'NA';

            switch (trade.trade_type) {
                case 'INITIAL-BUY':
                    tradeType = 'Initial Buy';
                    break;

                case 'SELL-ALL':
                    tradeType = 'Sell | Session ended';
                    break;

                case 'SELL-IND':
                    tradeType = trade.comment;
                    break;

                case 'COVER-BUY':
                    tradeType = trade.comment;
                    break;

                case 'COVER-PROFIT':
                    tradeType = trade.comment;
                    break;
            }
            return tradeType;
        }
    }
})

const app = new Vue({
    el: '#app',
});
