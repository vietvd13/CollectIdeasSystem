import * as RequestApi from '../request';

export function getCSRF(url) {
	return RequestApi.getOne(url);
}

export function postLogin(url, data) {
	return RequestApi.postOne(url, data);
}

export function getUser(url) {
	return RequestApi.getOne(url);
}
