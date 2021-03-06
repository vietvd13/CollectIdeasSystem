import Layout from '@/layout';

const CategoryManagement = {
	path: '/category-management',
	name: 'CategoryManagement',
	meta: {
		title: 'ROUTER.CATEGORY_MANAGEMENT'
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
				title: 'ROUTER.CATEGORY_MANAGEMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Category Management List" */ '@/pages/CategoryManagement/index'
				)
		}
	]
};

export default CategoryManagement;
