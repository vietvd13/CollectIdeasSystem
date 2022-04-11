import { shallowMount, mount, createLocalVue } from '@vue/test-utils';
import CategoryManagement from '../pages/CategoryManagement';
import store from '@/store';
const COMPONENT = 'CategoryManagement';

describe(`TEST COMPONENT ${COMPONENT}`, () => {
	console.log(COMPONENT);
	it('Case 1: Test component render ', () => {
		const localVue = createLocalVue();
		const wrapper = shallowMount(CategoryManagement, { localVue, store });

		const LOADING = wrapper.find('.loading');
		expect(LOADING.exists()).toBe(false);

		wrapper.destroy();
	});
});
