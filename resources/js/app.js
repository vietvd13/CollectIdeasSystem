import 'core-js';
import Vue from 'vue';
import App from '@/pages/App.vue';
import '@/permission';
import router from '@/router';
import i18n from '@/lang';
import store from '@/store';
import Bus from '@/eventBus';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import '@/assets/font-awesome/css/all.min.css';
import '@/scss/_index.scss';

Vue.use(Bus);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.config.productionTip = false;

new Vue({
	el: '#app',
	router,
	store,
	i18n,
	render: h => h(App)
});
