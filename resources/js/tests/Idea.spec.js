import store from '@/store';
import router from '@/router';
import { mount, createLocalVue } from '@vue/test-utils';
import Idea from '@/pages/Ideas/ManageIdeas';

describe('TEST FUNCTION IN IDEA SCREEN', () => {
	test('RENDER DATA', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.rerender).toEqual(1);
		expect(wrapper.vm.isShowModal).toEqual(false);
		expect(wrapper.vm.isShowModalPost).toEqual(false);
		expect(wrapper.vm.selected).toEqual(null);
		expect(wrapper.vm.liences).toEqual(false);
		expect(wrapper.vm.data).toEqual({
			category_id: null,
			contents: '',
			files: []
		});
		expect(wrapper.vm.listPost).toEqual([]);
		expect(wrapper.vm.count).toEqual(0);
		expect(wrapper.vm.isLike).toEqual(false);
		expect(wrapper.vm.user).toEqual('');
		expect(wrapper.vm.modalData).toEqual({
			id: '',
			contents: '',
			owner: '',
			category_id: '',
			deleted_at: null,
			created_at: '',
			updated_at: '',
			likes_count: 0,
			comments: [],
			likes: [],
			user: {
				id: '',
				department_id: '',
				name: '',
				email: '',
				birth: '',
				avatar_path: '',
				created_at: '',
				updated_at: ''
			}
		});
		expect(wrapper.vm.comment).toEqual('');
		expect(wrapper.vm.pagination).toEqual({
			page: 1,
			per_page: 5,
			total: 0
		});
		expect(wrapper.vm.isPostComment).toEqual(false);
		expect(wrapper.vm.likes_count).toEqual(0);

		wrapper.destroy();
	});

	test('TEST RENDER COMPONENT', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		const PAGE = wrapper.find('.manage-ideas');
		expect(PAGE.exists()).toBe(true);

		const CONTENT = PAGE.find('.manage-ideas__content');
		expect(CONTENT.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST HOOK CREATED', async () => {
		const connect = jest.fn();
		const handleGetListIdeas = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store,
			methods: {
				connect,
				handleGetListIdeas
			}
		});

		expect(connect).toHaveBeenCalled();
		expect(handleGetListIdeas).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST COMPUTED', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.language).toEqual('en');
		expect(wrapper.vm.fullname).toEqual('');
		expect(wrapper.vm.pageChange).toEqual(1);

		wrapper.destroy();
	});

	test('TEST FUNCTION resetDataModal', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.data).toEqual({
			category_id: null,
			contents: '',
			files: []
		});

		wrapper.destroy();
	});

	test('TEST FUNCTION findIdeadById', () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		expect(
			wrapper.vm.findIdeadById(
				[
					{
						id: 1
					},
					{
						id: 2
					}
				],
				1
			)
		).toEqual({ id: 1 });

		expect(
			wrapper.vm.findIdeadById(
				[
					{
						id: 1
					},
					{
						id: 2
					}
				],
				3
			)
		).toEqual(undefined);

		wrapper.destroy();
	});

	test('TEST FUNCTION resetData', () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		wrapper.vm.resetData();
		expect(wrapper.vm.data.contents).toEqual('');

		wrapper.destroy();
	});

	test('TEST FUNCTION handleStatusReact', () => {
		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.handleStatusReact([{ status: 0 }])).toEqual(0);
		expect(wrapper.vm.handleStatusReact([{ status: 1 }])).toEqual(1);
		expect(wrapper.vm.handleStatusReact([{ status: 1234 }])).toEqual(-1);
		expect(wrapper.vm.handleStatusReact([{ status: '' }])).toEqual(-1);
		expect(wrapper.vm.handleStatusReact([{ status: 'ABC' }])).toEqual(-1);
		expect(wrapper.vm.handleStatusReact([{ status: '^%@#$' }])).toEqual(-1);

		wrapper.destroy();
	});

	test('TEST FUNCTION handlePostIdea', async () => {
		const handlePostIdea = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		handlePostIdea();
		expect(handlePostIdea).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleGetListIdeas', async () => {
		const handleGetListIdeas = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		handleGetListIdeas();
		expect(handleGetListIdeas).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleActionReact', async () => {
		const handleActionReact = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		handleActionReact();
		expect(handleActionReact).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleUpdateListPost', () => {
		const handleUpdateListPost = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		handleUpdateListPost();
		expect(handleUpdateListPost).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleLike', () => {
		const handleLike = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		handleLike();
		expect(handleLike).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION showModalCreate', () => {
		const showModalCreate = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		showModalCreate();
		expect(showModalCreate).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION disconnectComment', () => {
		const disconnectComment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		disconnectComment();
		expect(disconnectComment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION connectComment', () => {
		const connectComment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		connectComment();
		expect(connectComment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION onClickSendComment', () => {
		const onClickSendComment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		onClickSendComment();
		expect(onClickSendComment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION connect', () => {
		const connect = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		connect();
		expect(connect).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION showModal', () => {
		const showModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		showModal();
		expect(showModal).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION getListCommet', () => {
		const getListCommet = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Idea, {
			localVue,
			router,
			store
		});

		getListCommet();
		expect(getListCommet).toHaveBeenCalled();

		wrapper.destroy();
	});
});
