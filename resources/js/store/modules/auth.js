import { postLogin, getUser } from '@/api/modules/auth';
import { isLogged, setLogged, removeToken } from '@/utils/auth';
import { resetRouter } from '@/router';

const state = {};

const mutations = {};

const actions = {
	doLogin({ commit }, account) {
		return new Promise((resolve, reject) => {
			const URL = `/auth/login`;

			postLogin(URL, account)
				.then(res => {
					console.log(res);

					setLogged('1');
					resolve();
				})
				.catch(err => {
					reject(err);
				});
		});
	},
	getUserInfo({ commit }) {
		return new Promise((resolve, reject) => {
			const URL = `/auth/user`;

			getUser(URL)
				.then(res => {
					const { data } = res;

					resolve(data);
				})
				.catch(err => {
					reject(err);
				});
		});
	},
	doLogout({ commit }) {
		removeToken();
		resetRouter();
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};
