import * as RequestApi from '../request';

const URL = '/department';

export function createDepartment(data) {
	return RequestApi.postOne(URL, data);
}

export function getDepartment() {
	return RequestApi.getAll(URL);
}

export function updateDepartment(id, data) {
	return RequestApi.putOne(`${URL}/${id}`, data);
}
export function getDeparmentById(id) {
	return RequestApi.getOne(`${URL}/${id}`);
}

export function deleteDeparment(id) {
	return RequestApi.deleteOne(`${URL}/${id}`);
}
