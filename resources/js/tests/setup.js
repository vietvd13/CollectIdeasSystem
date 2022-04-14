import Vue from 'vue';
require('dotenv').config();

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import { config } from '@vue/test-utils';
config.mocks.$t = key => key;

Vue.config.productionTip = false;
config.showDeprecationWarnings = false;

const noop = () => {};
Object.defineProperty(window, 'scrollTo', { value: noop, writable: true });

window.Pusher = require('pusher-js');
import Echo from 'laravel-echo';
window.Echo = new Echo({
	broadcaster: 'pusher',
	key: process.env.MIX_PUSHER_APP_KEY,
	cluster: process.env.MIX_PUSHER_APP_CLUSTER,
	forceTLS: true,
	wsHost: 'pusher.cat-dev.tech',
	wssPort: '6001',
	disableStats: true,
	enabledTransports: ['ws', 'flash']
});
