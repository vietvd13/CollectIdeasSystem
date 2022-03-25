import i18n from '@/lang';

export function getNameRole(role) {
	switch (role) {
		case 'ADMIN': {
			return i18n.t('ROLE.ADMIN');
		}

		case 'QAM': {
			return i18n.t('ROLE.QAM');
		}

		case 'QAC': {
			return i18n.t('ROLE.QAC');
		}

		case 'STAFF': {
			return i18n.t('ROLE.STAFF');
		}

		default: {
			return '';
		}
	}
}
