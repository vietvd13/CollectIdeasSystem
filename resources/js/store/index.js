import Vue from 'vue';
import Vuex from 'vuex';

import app from './modules/app';

import getters from './getters';

Vue.use(Vuex);

const modules = {
	app
};

const store = new Vuex.Store({
	modules,
	getters
});

export default store;
