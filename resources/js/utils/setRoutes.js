import router from '@/router';

export function setRoutes(accessRoutes = []) {
	const len = accessRoutes.length;
	let idx = 0;

	while (idx < len) {
		router.addRoute(accessRoutes[idx]);

		idx++;
	}
}
