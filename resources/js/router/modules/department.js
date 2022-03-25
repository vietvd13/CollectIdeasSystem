import Layout from '@/layout';

const Department = {
	path: '/department-management',
	name: 'DepartmentManagement',
	meta: {
		title: 'Department Management'
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
				title: 'Department Management'
			},
			component: () =>
				import(
					/* webpackChunkName: "Department Management List" */ '@/pages/DepartmentManagement/index'
				)
		}
	]
};

export default Department;
