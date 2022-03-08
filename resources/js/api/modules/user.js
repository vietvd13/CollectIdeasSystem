import * as RequestApi from '../request';

const URL = '/users';

export function postUser(data) {
	return RequestApi.postOne(URL, data);
}

export function getUserTable(params) {
	return RequestApi.getAll(URL, params);
}

export function editUser(id, data) {
	return RequestApi.putOne(`${URL}/${id}`, data);
}
export function getOneUser(id) {
	return RequestApi.getOne(`${URL}/${id}`);
}

export function deleteUser(id) {
	return RequestApi.deleteOne(`${URL}/${id}`);
}
