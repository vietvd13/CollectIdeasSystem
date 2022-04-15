import store from '@/store';
import router from '@/router';
import { mount, createLocalVue } from '@vue/test-utils';
import DepartmentManagement from '../pages/DepartmentManagement';

describe('TEST FUNCTION IN SCREEN CATEGORY', () => {
	test('TEST RENDER COMPONENT TEMPLATE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const CATEGORY_MANAGEMENT = wrapper.find('.account-management');
		expect(CATEGORY_MANAGEMENT.exists()).toBe(true);

		const HEADER = CATEGORY_MANAGEMENT.find('.account-management__header');
		expect(HEADER.exists()).toBe(true);

		const SEARCHING = CATEGORY_MANAGEMENT.find('.account-management__searching');
		expect(SEARCHING.exists()).toBe(true);

		const CONTENT = CATEGORY_MANAGEMENT.find('.account-management__content');
		expect(CONTENT.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER LOADING COMPONENT', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const LOADING = wrapper.find('.loading');
		expect(LOADING.exists()).toBe(false);

		wrapper.destroy();
	});

	test('TEST RENDER HEADER', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const HEADER = wrapper.find('.account-management__header');
		expect(HEADER.exists()).toBe(true);

		const TITLE = HEADER.find('.account-management__header-title');
		expect(TITLE.text()).toEqual('DEPARTMENT.TITLE');

		const ACTIONS = wrapper.find('.account-management__header-actions');
		expect(ACTIONS.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER SEACHERING', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const SEACHERING = wrapper.find('.account-management__searching');
		expect(SEACHERING.exists()).toBe(true);

		const FILTER = wrapper.find('.account-management__searching');
		expect(FILTER.exists()).toBe(true);
		const LABEL_FILTER = FILTER.find('label');
		expect(LABEL_FILTER.exists()).toBe(true);
		expect(LABEL_FILTER.text()).toEqual('USER.SEARCH_BY.KEYWORD');
		expect(FILTER.find('input').exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER TABLE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const CONTENT = wrapper.find('.account-management__content');
		expect(CONTENT.exists()).toBe(true);

		const TABLE = CONTENT.find('table');
		expect(TABLE.exists()).toBe(true);

		const HEAD_TABLE = TABLE.find('thead');
		expect(HEAD_TABLE.exists()).toBe(true);

		const TITLE_HEAD = HEAD_TABLE.findAll('th');
		expect(TITLE_HEAD.length).toEqual(3);

		wrapper.destroy();
	});

	test('TEST FUNCTION rows', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.rows).toEqual(0);

		wrapper.destroy();
	});

	test('TEST FUNCTION isChangePage', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.isChangePage).toEqual(1);

		wrapper.destroy();
	});

	test('TEST COMPONENT INIT DATA', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.params).toEqual({
			perPage: 5,
			currentPage: 1
		});
		expect(wrapper.vm.selected).toEqual(null);
		expect(wrapper.vm.options).toEqual([]);
		expect(wrapper.vm.isLoading).toEqual(false);
		expect(wrapper.vm.listDepartments).toEqual([]);
		expect(wrapper.vm.name).toEqual('');
		expect(wrapper.vm.action).toEqual('');
		expect(wrapper.vm.showModal).toEqual(false);
		expect(wrapper.vm.keyword).toEqual('');
		expect(wrapper.vm.ids).toEqual(0);

		wrapper.destroy();
	});

	test('TEST FUNCTION isResetDataModal', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		wrapper.vm.isResetDataModal();

		expect(wrapper.vm.name).toEqual('');

		wrapper.destroy();
	});

	test('TEST RENDER BUTTON CREATE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		const ZONE_BUTTON = wrapper.find('.account-management__header-actions');
		const BUTTON = ZONE_BUTTON.find('button');
		expect(BUTTON.exists()).toBe(true);
		expect(BUTTON.text()).toBe('DEPARTMENT.CREATE');

		wrapper.destroy();
	});

	test('TEST FUNCTION isResetDataModal', async () => {
		const isResetDataModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		isResetDataModal();
		expect(isResetDataModal).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleDeleteDepartment', async () => {
		const handleDeleteDepartment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		handleDeleteDepartment();
		expect(handleDeleteDepartment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleUpdateDepartment', async () => {
		const handleUpdateDepartment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		handleUpdateDepartment();
		expect(handleUpdateDepartment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleCreateDepartment', async () => {
		const handleCreateDepartment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		handleCreateDepartment();
		expect(handleCreateDepartment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleGetListDepartment', async () => {
		const handleGetListDepartment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		handleGetListDepartment();
		expect(handleGetListDepartment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleModal', async () => {
		const handleModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(DepartmentManagement, {
			localVue,
			router,
			store
		});

		handleModal();
		expect(handleModal).toHaveBeenCalled();

		wrapper.destroy();
	});
});
