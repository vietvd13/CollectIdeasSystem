import * as RequestApi from '../request';

const URL = '/category';

export function postCategory(data) {
	return RequestApi.postOne(URL, data);
}

export function getCategoryTable(params) {
	return RequestApi.getAll(URL, params);
}

export function editCategory(id, data) {
	return RequestApi.putOne(`${URL}/${id}`, data);
}
export function getOneCategory(id) {
	return RequestApi.getOne(`${URL}/${id}`);
}

export function deleteCategory(id) {
	return RequestApi.deleteOne(`${URL}/${id}`);
}
