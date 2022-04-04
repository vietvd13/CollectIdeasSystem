import * as RequestApi from '../request';

const URL = '/idea';

export function postIdeas(data) {
	return RequestApi.postOne(URL, data);
}

export function getListIdeas(PARAMS) {
	return RequestApi.getAllByParams(URL, PARAMS);
}

export function reactIdea(data) {
	return RequestApi.postOne(`${URL}/like`, data);
}

export function commentIdea(data) {
	return RequestApi.postOne(`${URL}/comment`, data);
}

export function commentscomments() {
	return RequestApi.getAll(`${URL}/comments/load`);
}
