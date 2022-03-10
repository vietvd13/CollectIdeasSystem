import Layout from '@/layout';

const CategoryManagement = {
	path: '/category-management',
	name: 'CategoryManagement',
	meta: {
		title: 'Category Management'
	},
	component: Layout,
	redirect: {
		name: 'CategoryManagementList'
	},
	children: [
		{
			path: 'list',
			name: 'CategoryManagementList',
			meta: {
				title: 'CATEGORY'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/CategoryManagement/index'
				)
		}
	]
};

export default CategoryManagement;
