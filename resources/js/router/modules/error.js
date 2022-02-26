const errorRoute = {
	path: '/page-not-found',
	name: 'PageNotFound',
	meta: {
		title: 'ROUTER.PAGE_NOT_FOUND',
		icon: ''
	},
	hidden: true,
	component: () =>
		import(/* webpackChunkName: "Page Not Found" */ '@/pages/PageNotFound/index.vue')
};

export default errorRoute;
