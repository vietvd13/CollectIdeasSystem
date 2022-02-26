import i18n from '@/lang';

const TITLE = process.env.MIX_APP_TITLE;

export default function getPageTitle(key) {
	const HASKEY = i18n.te(`${key}`);

	if (HASKEY) {
		const PAGENAME = i18n.t(`${key}`);
		return `${PAGENAME} | ${TITLE}`;
	}

	return `${TITLE}`;
}
