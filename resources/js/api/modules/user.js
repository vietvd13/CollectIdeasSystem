import * as RequestApi from '../request';

const URL = '/users';

export function postUser(data) {
	return RequestApi.postOne(URL, data);
}

export function getUserTable(params) {
	return RequestApi.getAll(URL, { params });
}
