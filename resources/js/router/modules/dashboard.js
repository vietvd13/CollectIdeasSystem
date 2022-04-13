import Layout from '@/layout';

const Dashboard = {
	path: '/dashboard',
	name: 'Dashboard',
	meta: {
		title: 'ROUTER.DASHBOARD',
		roles: ['ADMIN', 'QAM']
	},
	component: Layout,
	redirect: {
		name: 'DashboardIndex'
	},
	children: [
		{
			path: 'index',
			name: 'DashboardIndex',
			meta: {
				title: 'ROUTER.DASHBOARD'
			},
			component: () => import(/* webpackChunkName: "Dashboard" */ '@/pages/Dashboard/index')
		}
	]
};

export default Dashboard;
