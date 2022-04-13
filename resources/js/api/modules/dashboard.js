import * as RequestApi from '../request';

const URL = 'dasboard';
export function getCategoryDashboard() {
	return RequestApi.getAll(`${URL}/category`);
}

export function getTotal() {
	return RequestApi.getAll(`${URL}/total`);
}

export function getChartDonut(params) {
	return RequestApi.getAllByParams(`${URL}/chart-donut`, params);
}

export function downloadFile(params) {
	return RequestApi.getAllByParams(`${URL}/export/category`, params);
}
