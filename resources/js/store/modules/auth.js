import { postLogin, getUser } from '@/api/modules/auth';
import { isLogged, setLogged, removeToken } from '@/utils/auth';
import { resetRouter } from '@/router';

const state = {
	id: '',
	name: '',
	email: '',
	token: isLogged(),
	roles: []
};

const mutations = {
	SET_ID: (state, id) => {
		state.id = id;
	},
	SET_NAME: (state, name) => {
		state.name = name;
	},
	SET_EMAIL: (state, email) => {
		state.email = email;
	},
	SET_ROLES: (state, roles) => {
		state.roles = roles;
	}
};

const actions = {
	doLogin({ commit }, account) {
		return new Promise((resolve, reject) => {
			const URL = `/auth/login`;

			postLogin(URL, account)
				.then(res => {
					if (res['status'] !== 200) {
						reject();
					}

					const DATA = res['data'];

					commit('SET_ID', DATA['profile']['id']);
					commit('SET_NAME', DATA['profile']['name']);
					commit('SET_EMAIL', DATA['profile']['email']);
					commit('SET_ROLES', DATA['roles']);

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
					if (res['status'] !== 200) {
						reject();
					}

					const DATA = res['data'];

					commit('SET_ID', DATA['profile']['id']);
					commit('SET_NAME', DATA['profile']['name']);
					commit('SET_EMAIL', DATA['profile']['email']);
					commit('SET_ROLES', DATA['roles']);

					resolve(DATA);
				})
				.catch(err => {
					reject(err);
				});
		});
	},

	doLogout({ commit }) {
		commit('SET_ID', '');
		commit('SET_NAME', '');
		commit('SET_EMAIL', '');
		commit('SET_ROLES', []);

		removeToken();
		resetRouter();
	},
	resetToken({ commit }) {
		return new Promise(resolve => {
			commit('SET_ROLES', []);
			removeToken();
			resolve();
		});
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};
