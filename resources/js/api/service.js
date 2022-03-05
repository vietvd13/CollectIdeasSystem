import axios from 'axios';
import i18n from '@/lang';
import { getLanguage } from '@/lang/helper/getLang';
import { MakeToast } from '@/toast/toastMessage';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
	baseURL: baseURL,
	timeout: 100000
});

service.interceptors.request.use(
	config => {
		config.headers['Accept-Language'] = getLanguage();

		return config;
	},
	error => {
		Promise.reject(error);
	}
);

service.interceptors.response.use(
	response => {
		return response.data;
	},
	error => {
		const isCheckTitle = i18n.te(error.response.data.title);
		const isCheckContent = i18n.te(error.response.data.message);

		if (isCheckTitle && isCheckContent) {
			MakeToast({
				variant: 'danger',
				title: i18n.t(error.response.data.title),
				content: i18n.t(error.response.data.message)
			});
		}

		return Promise.reject(error);
	}
);

export { service };
