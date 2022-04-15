import { getNameRole } from '@/utils/helper';
import { obj2Path } from '@/utils/obj2Path';
import { validEmail, validPassword, isEmptyOrWhiteSpace } from '@/utils/validate';

describe('TEST FUNCTION HELPER', () => {
	test('getNameRole', async () => {
		expect(getNameRole('ADMIN')).toEqual('Admin');
		expect(getNameRole('QAM')).toEqual('Quality Assurance Manager');
		expect(getNameRole('QAC')).toEqual('Quality Assurance Coordinator');
		expect(getNameRole('STAFF')).toEqual('Staff');
		expect(getNameRole('')).toEqual('');
		expect(getNameRole('123123')).toEqual('');
		expect(getNameRole(null)).toEqual('');
		expect(getNameRole(undefined)).toEqual('');
		expect(getNameRole([])).toEqual('');
		expect(getNameRole({})).toEqual('');
		expect(getNameRole('QAWE!@#!@%#$@%')).toEqual('');
		expect(getNameRole('   %')).toEqual('');
	});

	test('obj2Path', async () => {
		expect(
			obj2Path({
				name: 'cat'
			})
		).toEqual('name=cat');
		expect(
			obj2Path({
				name: 'cat',
				age: 10
			})
		).toEqual('name=cat&age=10');
		expect(obj2Path()).toEqual('');
		expect(obj2Path(null)).toEqual('');
		expect(obj2Path(undefined)).toEqual('');
		expect(obj2Path([])).toEqual('');
	});

	test('validEmail', async () => {
		expect(validEmail('vuducviet0131@gmail.com')).toBe(true);
		expect(validEmail('vietvd@gmail.com')).toBe(true);
		expect(validEmail('vietvd@gmail')).toBe(false);
		expect(validEmail('vietvd@gmail')).toBe(false);
		expect(validEmail('vietvd')).toBe(false);
		expect(validEmail('@gmail.com')).toBe(false);
		expect(validEmail('.com')).toBe(false);
		expect(validEmail('&&^%$$##@.com')).toBe(false);
	});

	test('validPassword', async () => {
		expect(validPassword('password')).toBe(true);
		expect(validPassword('vietvd1310')).toBe(true);
		expect(validPassword('viet asd qwe qwe qwe qwe qwe qwe qwe qwe')).toBe(false);
		expect(validPassword('!@#$%^&*()')).toBe(true);
		expect(validPassword('         ')).toBe(false);
	});

	test('isEmptyOrWhiteSpace', async () => {
		expect(isEmptyOrWhiteSpace('')).toBe(true);
		expect(isEmptyOrWhiteSpace('    ')).toBe(true);
		expect(isEmptyOrWhiteSpace('text')).toBe(false);
		expect(isEmptyOrWhiteSpace('text number')).toBe(false);
		expect(isEmptyOrWhiteSpace('@#$@#$')).toBe(false);
		expect(isEmptyOrWhiteSpace('12354456')).toBe(false);
		expect(isEmptyOrWhiteSpace('sdfs 123 123sdsdf')).toBe(false);
	});
});
