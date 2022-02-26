import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from './modules/login';
import errorRoute from './modules/error';

export const constantRoutes = [
	Login,
	errorRoute,
	{
		path: '*',
		redirect: { name: 'PageNotFound' }
	}
];

export const asyncRoutes = [];

const createRouter = () =>
	new VueRouter({
		scrollBehavior: () => ({ y: 0 }),
		routes: constantRoutes
	});

const router = createRouter();

export function resetRouter() {
	const newRouter = createRouter();
	router.matcher = newRouter.matcher;
}

export default router;
