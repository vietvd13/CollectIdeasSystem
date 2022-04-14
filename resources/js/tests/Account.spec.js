import store from '@/store';
import router from '@/router';
import { mount, createLocalVue } from '@vue/test-utils';
import Account from '@/pages/AccountManagement';
import { validEmail, validPassword } from '@/utils/validate';

describe('TEST FUNCTION IN SCREEN ACCOUNT', () => {
	test('TEST RENDER COMPONENT ACCOUNT MANAGEMENT', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store
		});

		const Container = wrapper.find('.account-management');
		expect(Container.exists()).toBe(true);

		const Header = Container.find('.account-management__header');
		expect(Header.exists()).toBe(true);

		const Content = Container.find('.account-management__content');
		expect(Content.exists()).toBe(true);

		wrapper.destroy();
	});

	test('TEST RENDER DATA', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.params).toEqual({
			per_page: 5,
			page: 1
		});
		expect(wrapper.vm.isProcess).toEqual(false);
		expect(wrapper.vm.selected).toEqual(null);
		expect(wrapper.vm.options).toEqual([]);
		expect(wrapper.vm.isLoading).toEqual(true);
		expect(wrapper.vm.listUser).toEqual([]);
		expect(wrapper.vm.listDepartments).toEqual([]);
		expect(wrapper.vm.newUser).toEqual({
			email: '',
			password: '',
			name: '',
			role: null,
			birth: '',
			avatar: null,
			department_id: null
		});
		expect(wrapper.vm.action).toEqual('');
		expect(wrapper.vm.showModal).toEqual(false);
		expect(wrapper.vm.keyword).toEqual('');
		expect(wrapper.vm.ids).toEqual(0);
		expect(wrapper.vm.total).toEqual(0);

		wrapper.destroy();
	});

	test('TEST HOOK CREATED', async () => {
		const handleGetListUser = jest.fn();
		const getRole = jest.fn();
		const handleGetDepartment = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleGetListUser,
				getRole,
				handleGetDepartment
			}
		});

		expect(handleGetListUser).toHaveBeenCalled();
		expect(getRole).toHaveBeenCalled();
		expect(handleGetDepartment).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION isResetModal', async () => {
		const isResetModal = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				isResetModal
			}
		});

		wrapper.vm.isResetModal();

		expect(wrapper.vm.newUser).toEqual({
			avatar: null,
			email: '',
			password: '',
			name: '',
			role: null,
			birth: '',
			department_id: null
		});

		wrapper.destroy();
	});

	test('TEST FUNCTION GET ROLE', async () => {
		const getRole = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				getRole
			}
		});

		await wrapper.vm.getRole();
		expect(getRole).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION CREATE ACCOUNT', async () => {
		const handleCreateUser = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleCreateUser
			}
		});

		await wrapper.vm.handleCreateUser();
		expect(handleCreateUser).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION EDIT ACCOUNT', async () => {
		const handleEditUser = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleEditUser
			}
		});

		await wrapper.vm.handleEditUser();
		expect(handleEditUser).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION DELETE ACCOUNT', async () => {
		const handleDeleteUser = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleDeleteUser
			}
		});

		await wrapper.vm.handleDeleteUser();
		expect(handleDeleteUser).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION HANDLE SEARCH BY KEYWORD', async () => {
		const handleSearchByKeyWords = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleSearchByKeyWords
			}
		});

		await wrapper.vm.handleSearchByKeyWords();
		expect(handleSearchByKeyWords).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION HANDLE SEARCH BY ROLE', async () => {
		const handleSearchByRole = jest.fn();

		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store,
			methods: {
				handleSearchByRole
			}
		});

		await wrapper.vm.handleSearchByRole();
		expect(handleSearchByRole).toHaveBeenCalled();

		wrapper.destroy();
	});

	test('TEST FUNCTION VALIDATE EMAIL', async () => {
		expect(validEmail('vuducviet0131@gmail.com')).toBe(true);
		expect(validEmail('vietvd@gmail.com')).toBe(true);
		expect(validEmail('vietvd@gmail')).toBe(false);
		expect(validEmail('vietvd@gmail')).toBe(false);
		expect(validEmail('vietvd')).toBe(false);
		expect(validEmail('@gmail.com')).toBe(false);
		expect(validEmail('.com')).toBe(false);
		expect(validEmail('&&^%$$##@.com')).toBe(false);
	});

	test('TEST FUNCTION VALIDATE PASSSWORD', async () => {
		expect(validPassword('password')).toBe(true);
		expect(validPassword('vietvd1310')).toBe(true);
		expect(validPassword('viet asd qwe qwe qwe qwe qwe qwe qwe qwe')).toBe(false);
		expect(validPassword('!@#$%^&*()')).toBe(true);
		expect(validPassword('         ')).toBe(false);
	});

	test('TEST FUNCTION DATA RENDER HEADER TABLE', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store
		});

		const HEADER = [
			{
				key: 'id',
				label: 'USER.TABLE.HEADING.ID'
			},
			{
				key: 'avatar_path',
				label: 'USER.TABLE.HEADING.AVATARS'
			},
			{
				key: 'email',
				label: 'USER.TABLE.HEADING.EMAIL'
			},
			{
				key: 'name',
				label: 'USER.TABLE.HEADING.NAME'
			},
			{
				key: 'roles',
				label: 'USER.TABLE.HEADING.ROLE'
			},
			{
				key: 'birth',
				label: 'USER.TABLE.HEADING.BIRTH'
			},
			{
				key: 'actions',
				label: 'USER.TABLE.HEADING.ACTIONS'
			}
		];

		expect(JSON.stringify(wrapper.vm.vFileds)).toEqual(JSON.stringify(HEADER));

		wrapper.destroy();
	});

	test('TEST HOOK COMPUTED', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Account, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.rows).toEqual(0);
		expect(wrapper.vm.isChangePage).toEqual(1);

		wrapper.destroy();
	});
});
