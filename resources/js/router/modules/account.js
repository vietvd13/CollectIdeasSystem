import Layout from '@/layout';

const AccountManagement = {
	path: '/account-management',
	name: 'AccountManagement',
	meta: {
		title: 'ROUTER.ACCOUNT_MANAGEMENT'
	},
	component: Layout,
	redirect: {
		name: 'AccountManagementList'
	},
	children: [
		{
			path: 'list',
			name: 'AccountManagementList',
			meta: {
				title: 'ROUTER.ACCOUNT_MANAGEMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/AccountManagement/index'
				)
		}
	]
};

export default AccountManagement;
