import router from '@/router';
import getPageTitle from '@/utils/getPageTitle';

router.beforeEach(async (to, from, next) => {
	document.title = getPageTitle(to.meta.title);

	next();
});
