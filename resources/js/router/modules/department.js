import Layout from '@/layout';

const Department = {
	path: '/department-management',
	name: 'DepartmetManagement',
	meta: {
		title: 'ROUTER.DEPARTMENT'
	},
	component: Layout,
	redirect: {
		name: 'DepartmentManagement'
	},
	children: [
		{
			path: 'list',
			name: 'DepartmentManagement',
			meta: {
				title: 'ROUTER.DEPARTMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/DepartmentManagement/index'
				)
		}
	]
};

export default Department;
