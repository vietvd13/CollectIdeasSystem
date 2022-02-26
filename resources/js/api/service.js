import axios from 'axios';
import i18n from '@/lang';
import router from '@/router';
import { getToken } from '@/utils/handleToken';
import { getLanguage } from '@/lang/helper/getLang';
import { MakeToast } from '@/toast/toastMessage';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
	baseURL: baseURL,
	timeout: 100000
});

service.interceptors.request.use(
	config => {
		const token = getToken();
		config.headers['Accept-Language'] = getLanguage();

		if (token) {
			config.headers['Authorization'] = token;
		} else {
			if (router.currentRoute.path !== '/login') {
				router.push({ path: '/login' });
			}
		}

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
				variant: i18n.t('TOAST.WARNING'),
				title: i18n.t(error.response.data.title),
				content: i18n.t(error.response.data.message)
			});
		}

		return Promise.reject(error);
	}
);

export { service };
