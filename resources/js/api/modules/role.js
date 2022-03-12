import * as RequestApi from '../request';

const URL = '/roles';

export function getListRole() {
	return RequestApi.getAll(URL);
}
