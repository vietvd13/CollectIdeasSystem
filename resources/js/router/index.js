import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from './modules/login';
import errorRoute from './modules/error';
import Dashboard from './modules/dashboard';
import AccountManagement from './modules/account';
import PostIdeas from './modules/UserIdeas';
import CategoryManagement from './modules/category';
import Department from './modules/department';

export const constantRoutes = [
	Login,
	{
		path: '/',
		redirect: { name: 'Dashboard' },
		hidden: true
	},
	Dashboard,
	Department,
	AccountManagement,
	CategoryManagement,
	PostIdeas,
	
	errorRoute,
	{
		path: '*',
		hidden: true,
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
