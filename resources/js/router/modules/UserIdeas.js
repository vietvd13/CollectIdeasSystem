import Layout from '@/layout';

const PostIdeas = {
	path: '/manage-post',
	name: 'PostManagement',
	meta: {
		title: 'Ideas Management'
	},
	component: Layout,
	redirect: {
		name: 'PostManagementList'
	},
	children: [
		{
			path: 'list',
			name: 'PostManagementList',
			meta: {
				title: 'ROUTER.ACCOUNT_MANAGEMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/Ideas/ManageIdeas'
				)
		},
		{
			path: 'detail',
			name: 'PostManagementDetail',
			meta: {
				title: 'ROUTER.ACCOUNT_MANAGEMENT'
			},
			component: () =>
				import(
					/* webpackChunkName: "Account Management List" */ '@/pages/Ideas/IdeaDetail'
				)
		}
	]
};

export default PostIdeas;
