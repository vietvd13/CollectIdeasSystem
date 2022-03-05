import Layout from '@/layout';

const Dashboard = {
	path: '/dashboard',
	name: 'Dashboard',
	meta: {
		title: 'Dashboard'
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
				title: 'Dashboard'
			},
			component: () => import(/* webpackChunkName: "Dashboard" */ '@/pages/Dashboard/index')
		}
	]
};

export default Dashboard;
