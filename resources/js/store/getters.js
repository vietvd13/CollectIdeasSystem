const getters = {
	id: state => state.auth.id,
	name: state => state.auth.name,
	email: state => state.auth.email,
	roles: state => state.auth.roles,
	addRoutes: state => state.permission.addRoutes,
	permissionRoutes: state => state.permission.routes,
	language: state => state.app.language
};

export default getters;
