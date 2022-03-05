import Vue from 'vue';
import Vuex from 'vuex';

import app from './modules/app';
import auth from './modules/auth';

import getters from './getters';

Vue.use(Vuex);

const modules = {
	app,
	auth
};

const store = new Vuex.Store({
	modules,
	getters
});

export default store;
