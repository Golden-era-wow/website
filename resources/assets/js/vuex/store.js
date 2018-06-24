import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import User from './modules/user';
import ShoppingCart from './modules/shopping-cart';

export default new Vuex.Store({
   modules: {
   	User,
   	ShoppingCart
   },
})