import * as RequestApi from '../request';

const URL = '/idea';

export function postIdeas(data) {
	return RequestApi.postOne(URL, data);
}

export function getListIdeas() {
	return RequestApi.getAll(URL);
}
