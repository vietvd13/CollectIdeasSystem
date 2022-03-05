import Layout from '@/layout';

const AccountManagement = {
	path: '/account-management',
	name: 'AccountManagement',
	meta: {
		title: 'Account Management'
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
				title: 'Account Management List'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/AccountManagement/index'
				)
		}
	]
};

export default AccountManagement;
