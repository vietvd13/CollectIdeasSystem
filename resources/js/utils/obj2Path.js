/**
 * Function convert Object to Path URL
 * @param {Object} obj
 * @returns String
 */
export function obj2Path(obj) {
	if (!obj) {
		return '';
	}

	var str = [];

	for (var p in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, p)) {
			str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]));
		}
	}

	return str.join('&');
}
