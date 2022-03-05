import Vue from 'vue';

/**
 * Show MakeToast
 */
export const MakeToast = ({
	variant = null,
	title,
	content,
	toaster = 'b-toaster-bottom-right',
	autoHideDelay = 1500
}) => {
	const vm = new Vue();

	vm.$bvToast.toast(content, {
		title: title,
		variant: variant,
		toaster: toaster,
		solid: true,
		autoHideDelay: autoHideDelay,
		appendToast: true
	});
};
