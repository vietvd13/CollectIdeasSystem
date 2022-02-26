import Vue from 'vue';

class EventBus {
	constructor() {
		this.bus = new Vue();
	}

	/**
	 * Wait event bus
	 * @param {*} event
	 * @param {*} handler
	 */
	on(event, handler) {
		this.bus.$on(event, handler);
	}

	/**
	 * Do event bus only 1
	 * @param {*} event
	 * @param {*} handler
	 */
	once(event, handler) {
		this.bus.$once(event, handler);
	}

	/**
	 * Off event bus
	 * @param {*} event
	 * @param {*} handler
	 */
	off(event, handler) {
		this.bus.$off(event, handler);
	}

	/**
	 * Do event bus
	 * @param {*} event
	 * @param  {...any} args
	 */
	emit(event, ...args) {
		this.bus.$emit(event, ...args);
	}
}

export default {
	install(Vue) {
		const bus = new EventBus();

		Vue.prototype.$bus = bus;
	}
};
