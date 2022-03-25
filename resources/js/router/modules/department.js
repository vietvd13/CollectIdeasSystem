import Layout from '@/layout';

const Department = {
	path: '/department-management',
	name: 'DepartmetManagement',
	meta: {
		title: 'Department Management'
	},
	component: Layout,
	redirect: {
		name: 'DepartmetManagement'
	},
	children: [
		{
			path: 'list',
			name: 'DepartmetManagement',
			meta: {
				title: 'Department Management'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/DepartmentManagement/index'
				)
		}
	]
};

export default Department;
