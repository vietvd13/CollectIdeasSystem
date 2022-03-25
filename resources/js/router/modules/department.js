import Layout from '@/layout';

const Department = {
	path: '/department-management',
	name: 'DepartmentManagement',
	meta: {
		title: 'ROUTER.DEPARTMENT'
	},
	component: Layout,
	redirect: {
		name: 'DepartmentManagementIndex'
	},
	children: [
		{
			path: 'list',
			name: 'DepartmentManagementIndex',
			meta: {
				title: 'ROUTER.DEPARTMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Department Management List" */ '@/pages/DepartmentManagement/index'
				)
		}
	]
};

export default Department;
