import { asyncRoutes, constantRoutes } from '@/router';

function canAccess(roles, permissions, route) {
	if (route.meta) {
		let hasRole = true;
		let hasPermission = true;

		if (route.meta.roles || route.meta.permissions) {
			hasRole = false;
			hasPermission = false;

			if (route.meta.roles) {
				hasRole = roles.some(role => route.meta.roles.includes(role));
			}

			if (route.meta.permissions) {
				hasPermission = permissions.some(permission =>
					route.meta.permissions.includes(permission)
				);
			}
		}

		return hasRole || hasPermission;
	}

	return true;
}

function filterAsyncRoutes(routes, roles, permissions) {
	const res = [];

	routes.forEach(route => {
		const tmp = { ...route };

		if (canAccess(roles, permissions, tmp)) {
			if (tmp.children) {
				tmp.children = filterAsyncRoutes(tmp.children, roles, permissions);
			}
			res.push(tmp);
		}
	});

	return res;
}

const state = {
	routes: [],
	addRoutes: []
};

const mutations = {
	SET_ROUTES: (state, routes) => {
		state.addRoutes = routes;
		state.routes = constantRoutes.concat(routes);
	}
};

const actions = {
	generateRoutes({ commit }, { roles, permissions }) {
		return new Promise(resolve => {
			let accessedRoutes;

			if (roles.includes('ADMIN')) {
				accessedRoutes = asyncRoutes || [];
			} else {
				accessedRoutes = filterAsyncRoutes(asyncRoutes, roles, permissions);
			}

			commit('SET_ROUTES', accessedRoutes);
			resolve(accessedRoutes);
		});
	}
};

export default {
	namespaced: true,
	state,
	mutations,
	actions
};
