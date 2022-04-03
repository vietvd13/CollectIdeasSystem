import * as RequestApi from '../request';

const URL = 'dasboard/category';
export function getCategoryDashboard() {
	return RequestApi.getAll(URL);
}
