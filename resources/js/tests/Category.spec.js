import store from '@/store';
import router from '@/router';
import { mount, createLocalVue } from '@vue/test-utils';
import CategoryManagement from '../pages/CategoryManagement';
import { isEmptyOrWhiteSpace } from '@/utils/validate';

describe('TEST FUNCTION IN SCREEN CATEGORY', () => {
	test('TEST RENDER COMPONENT TEMPLATE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		const CATEGORY_MANAGEMENT = wrapper.find('.category-management');
		expect(CATEGORY_MANAGEMENT.exists()).toBe(true);

		const HEADER = CATEGORY_MANAGEMENT.find('.category-management__header');
		expect(HEADER.exists()).toBe(true);

		const SEARCHING = CATEGORY_MANAGEMENT.find('.category-management__searching');
		expect(SEARCHING.exists()).toBe(true);

		const CONTENT = CATEGORY_MANAGEMENT.find('.category-management__content');
		expect(CONTENT.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER LOADING COMPONENT', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
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
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		const HEADER = wrapper.find('.category-management__header');
		expect(HEADER.exists()).toBe(true);

		const TITLE = HEADER.find('.category-management__header-title');
		expect(TITLE.text()).toEqual('CATEGORY.TITLE');

		const ACTIONS = wrapper.find('.category-management__header-actions');
		expect(ACTIONS.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER SEACHERING', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		const SEACHERING = wrapper.find('.category-management__searching');
		expect(SEACHERING.exists()).toBe(true);

		const FILTER = wrapper.find('.category-management__searching-filter');
		expect(FILTER.exists()).toBe(true);
		const LABEL_FILTER = FILTER.find('label');
		expect(LABEL_FILTER.exists()).toBe(true);
		expect(LABEL_FILTER.text()).toEqual('CATEGORY.SEARCH_BY.TYPE');
		expect(FILTER.find('select').exists()).toBe(true);

		const KEYWORD = wrapper.find('.category-management__searching-keyword');
		expect(KEYWORD.exists()).toBe(true);
		const LABEL_KEYWORD = KEYWORD.find('label');
		expect(LABEL_KEYWORD.exists()).toBe(true);
		expect(LABEL_KEYWORD.text()).toEqual('CATEGORY.SEARCH_BY.KEYWORD');
		expect(KEYWORD.find('input').exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER TABLE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		const CONTENT = wrapper.find('.category-management__content');
		expect(CONTENT.exists()).toBe(true);

		const TABLE = CONTENT.find('table');
		expect(TABLE.exists()).toBe(true);

		const HEAD_TABLE = TABLE.find('thead');
		expect(HEAD_TABLE.exists()).toBe(true);

		const TITLE_HEAD = HEAD_TABLE.findAll('th');
		expect(TITLE_HEAD.length).toEqual(6);

		wrapper.destroy();
	});

	test('TEST FUNCTION rows', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.rows).toEqual(0);

		wrapper.destroy();
	});

	test('TEST FUNCTION isChangePage', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.isChangePage).toEqual(1);

		wrapper.destroy();
	});

	test('TEST FUNCTION name', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.name).toEqual('');

		wrapper.destroy();
	});

	test('TEST FUNCTION isEmptyOrWhiteSpace', async () => {
		expect(isEmptyOrWhiteSpace('')).toBe(true);
		expect(isEmptyOrWhiteSpace('    ')).toBe(true);
		expect(isEmptyOrWhiteSpace('text')).toBe(false);
		expect(isEmptyOrWhiteSpace('text number')).toBe(false);
		expect(isEmptyOrWhiteSpace('@#$@#$')).toBe(false);
		expect(isEmptyOrWhiteSpace('12354456')).toBe(false);
		expect(isEmptyOrWhiteSpace('sdfs 123 123sdsdf')).toBe(false);
	});

	test('TEST FUNCTION isResetDataModal', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		wrapper.vm.isResetDataModal();
		expect(JSON.stringify(wrapper.vm.newCategory)).toEqual(
			JSON.stringify({
				id: '',
				topic_name: '',
				start_collect_date: '',
				end_collect_date: '',
				description: ''
			})
		);

		wrapper.destroy();
	});

	test('TEST FUNCTION handleExportCSV', async () => {
		const handleExportCSV = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleExportCSV();
		expect(handleExportCSV).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION isResetDataModal', async () => {
		const isResetDataModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		isResetDataModal();
		expect(isResetDataModal).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleSearchByKeyWords', async () => {
		const handleSearchByKeyWords = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleSearchByKeyWords();
		expect(handleSearchByKeyWords).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleDeleteCategory', async () => {
		const handleDeleteCategory = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleDeleteCategory();
		expect(handleDeleteCategory).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleEditCategory', async () => {
		const handleEditCategory = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleEditCategory();
		expect(handleEditCategory).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleCreateCategory', async () => {
		const handleCreateCategory = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleCreateCategory();
		expect(handleCreateCategory).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleGetListCategory', async () => {
		const handleGetListCategory = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleGetListCategory();
		expect(handleGetListCategory).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleModal', async () => {
		const handleModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleModal();
		expect(handleModal).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION handleDetailIdeas', async () => {
		const handleDetailIdeas = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(CategoryManagement, {
			localVue,
			router,
			store
		});

		handleDetailIdeas();
		expect(handleDetailIdeas).toHaveBeenCalled();

		wrapper.destroy();
	});
});
