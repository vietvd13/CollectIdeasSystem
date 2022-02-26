const Login = {
	path: '/login',
	name: 'Login',
	hidden: true,
	component: () => import(/* webpackChunkName: "Login" */ '@/pages/Login/index.vue'),
	meta: {
		title: 'ROUTER.LOGIN',
		icon: ''
	}
};

export default Login;
