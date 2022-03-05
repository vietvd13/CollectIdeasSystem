import Vue from 'vue';
import Vuex from 'vuex';

import app from './modules/app';
import auth from './modules/auth';
import permission from './modules/permission';

import getters from './getters';

Vue.use(Vuex);

const modules = {
	app,
	auth,
	permission
};

const store = new Vuex.Store({
	modules,
	getters
});

export default store;
