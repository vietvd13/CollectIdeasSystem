import { mount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import router from '@/router';
import i18n from '@/lang';
import Login from '@/pages/Login';

describe('Name of the group', () => {
	test('should first', () => {
		const localVue = createLocalVue();
		const wrapper = mount(Login, {
			localVue,
			router,
			store,
			i18n
		});

		const BUTTON = wrapper.find('.login-form-content__footer');
		expect(BUTTON.exists()).toBe(true);
		const TEXT = BUTTON.find('button').text();
		console.log(TEXT);

		console.log(store.getters.language);

		wrapper.destroy();
	});
});
