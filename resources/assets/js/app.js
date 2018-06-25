
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import InstantSearch from 'vue-instantsearch';

Vue.use(InstantSearch);

import store from './vuex/store';

Vue.prototype.$log = console.log;

import PortalVue from 'portal-vue';

Vue.use(PortalVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('dropdown-menu', require('./components/navigation/DropdownMenu.vue'));
require('./components/settings/AppSettings.js');
require('./components/shop/ShopIndex.js');
require('./components/shop/ShoppingCart.js');

import { mapGetters } from 'vuex';

const app = new Vue({
    el: '#app',
    store,

    computed: {
        ...mapGetters([
            'user',
        ])
    },

    mounted: function () {
        this.fetchCurrentUserWith(['cart']);
    },

    methods: {
        async fetchCurrentUserWith(relations = []) {
            const { data } = await axios.get("/api/current-user", { params: { with: relations } })
            this.$store.dispatch('setUser', data)
        }
    }
});
