import store from '@/store';
import router from '@/router';
import { mount, createLocalVue } from '@vue/test-utils';
import Login from '@/pages/Login';

describe('TEST SCREEN LOGIN', () => {
	test('Check Logo is exits', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Login, {
			localVue,
			router,
			store
		});

		const ZoneLogo = wrapper.find('.login-form-content__logo');
		expect(ZoneLogo.exists()).toBe(true);

		const Logo = ZoneLogo.find('img');
		expect(Logo.exists()).toBe(true);

		wrapper.destroy();
	});

	test('Check form input account and password', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Login, {
			localVue,
			router,
			store
		});

		expect(wrapper.find('#input-account').element.value).toEqual('');
		expect(wrapper.find('#input-password').element.value).toEqual('');

		await wrapper.setData({
			User: {
				account: 'admin@gmail.com',
				password: 'password'
			}
		});

		expect(wrapper.find('#input-account').element.value).toEqual('admin@gmail.com');
		expect(wrapper.find('#input-password').element.value).toEqual('password');

		const ZoneButtonLogin = wrapper.find('.login-form-content__footer');
		const ButtonLogin = ZoneButtonLogin.find('button');
		expect(ButtonLogin.exists()).toBe(true);
		expect(ButtonLogin.text()).toEqual('LOGIN.BUTTON_LOGIN');

		wrapper.destroy();
	});

	test('Check toggle show password', async () => {
		const localVue = createLocalVue();
		const wrapper = mount(Login, {
			localVue,
			router,
			store
		});

		expect(wrapper.vm.isProcess).toEqual(false);

		const IconShowPassword = wrapper.find('.fa-eye');
		expect(IconShowPassword.exists()).toBe(false);

		wrapper.destroy();
	});
});
