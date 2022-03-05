import router from '@/router';
import store from '@/store';
import { isLogged } from '@/utils/auth';
import getPageTitle from '@/utils/getPageTitle';
import { setRoutes } from '@/utils/setRoutes';

const whiteList = ['/login'];

router.beforeEach(async (to, from, next) => {
	document.title = getPageTitle(to.meta.title);

	const isUserLogged = isLogged();

	if (isUserLogged) {
		if (to.path === '/login') {
			next({ path: '/' });
		} else {
			const hasRoles = store.getters.roles && store.getters.roles.length > 0;

			if (hasRoles) {
				next();
			} else {
				try {
					const res = await store.dispatch('auth/getUserInfo');
					const ROLES = res['roles'];
					const accessRoutes = await store.dispatch('permission/generateRoutes', {
						roles: ROLES,
						permissions: []
					});
					setRoutes(accessRoutes);
					next({ ...to, replace: true });
				} catch {
					await store.dispatch('auth/resetToken');
					next(`/login`);
				}
			}
		}
	} else {
		if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
			next();
		} else {
			next(`/login`);
		}
	}
});
