import Layout from '@/layout';

const PostIdeas = {
	path: '/manage-post',
	name: 'PostManagement',
	meta: {
		title: 'ROUTER.IDEAS'
	},
	component: Layout,
	redirect: {
		name: 'PostManagementList'
	},
	hidden: true,
	children: [
		{
			path: 'list/:category',
			name: 'PostManagementList',
			meta: {
				title: 'ROUTER.IDEAS'
			},
			component: () =>
				import(/* webpackChunkName: "Ideas Management List" */ '@/pages/Ideas/ManageIdeas')
		},
		{
			path: 'detail',
			name: 'PostManagementDetail',
			meta: {
				title: 'ROUTER.IDEAS'
			},
			component: () =>
				import(/* webpackChunkName: "Ideas Management List" */ '@/pages/Ideas/IdeaDetail')
		}
	]
};

export default PostIdeas;
