<template>
	<div class="account-management">
		<div class="account-management__header">
			<div class="account-management__header-title">
				<h4>Người dùng</h4>
			</div>
			<div class="account-management__header-actions">
				<button class="btn btn-primary" v-b-modal.modal-1>Tạo người dùng</button>
			</div>
			<b-modal id="modal-1" title="Create User" ok-title="Create">
				<div class="row mt-2">
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Tên đăng nhập</label>
						<b-form-input></b-form-input>
					</div>
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Mật khẩu</label>
						<b-form-input></b-form-input>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Email</label>
						<b-form-input></b-form-input>
					</div>
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Tên người dùng</label>
						<b-form-input></b-form-input>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Vai trò</label>
						<b-form-select v-model="selected" :options="options"></b-form-select>
					</div>
					<div class="col-md-6 col-sm-12 col-lg-6">
						<label for="">Ngày sinh</label>
						<b-form-input type="date"></b-form-input>
					</div>
				</div>
			</b-modal>
		</div>
		<div class="account-management__searching">
			<div class="account-management__searching-filter">
				<label for="filer">Vai trò</label>
				<b-form-select v-model="selected" :options="options"></b-form-select>
			</div>
			<div class="account-management__searching-keyword">
				<label for="keyword">Keyword</label>
				<b-input-group>
					<b-form-input placeholder="Enter the keyword"></b-form-input>
					<b-input-group-append>
						<b-button variant="primary"><i class="fas fa-search"></i></b-button>
					</b-input-group-append>
				</b-input-group>
			</div>
		</div>
		<div class="account-management__content mt-3">
			<b-table-simple class="text-center" responsive :outlined="false" :fixed="false">
				<b-thead>
					<b-th>
						<span>ID</span>
					</b-th>
					<b-th>
						<span>Tên Đăng Nhập</span>
					</b-th>
					<b-th>
						<span>Họ và Tên</span>
					</b-th>
					<b-th>
						<span>Vai trò</span>
					</b-th>
					<!-- <b-th>
						<span>Date of Birth</span>
					</b-th>
					<b-th>
						<span>Email</span>
					</b-th>
					<b-th>
						<span>Status</span>
					</b-th> -->
					<b-th>
						<span>Action</span>
					</b-th>
				</b-thead>
				<b-tbody>
					<tr v-for="(users, index) in listUser" :key="index">
						<td>{{ index + 1 }}</td>
						<td>{{ users.name }}</td>
						<td>{{ users.name }}</td>
						<td>{{ users.name }}</td>
						<td><i class="fas fa-ellipsis-h"></i></td>
					</tr>
					<LazyLoad @lazyload="handleGetListUser()" />
				</b-tbody>
			</b-table-simple>
			<b-pagination
				v-model="currentPage"
				:per-page="perPage"
				aria-controls="my-table"
			></b-pagination>
		</div>
	</div>
</template>

<script>
	import { getUserTable, postUser } from '@/api/modules/user';
	import LazyLoad from '../../layout/Lazyload.vue';
	export default {
		name: 'AccountManagementList',
		components: {
			LazyLoad
		},
		data() {
			return {
				perPage: 2,
				currentPage: 1,
				selected: null,
				options: [
					{ value: null, text: 'Role' },
					{ value: 'staff', text: 'Staff' },
					{ value: 'qa', text: 'QA Manager' },
					{ value: 'admin', text: 'Admin' }
				],
				loading: false,
				listUser: []
			};
		},
		computed: {},
		methods: {
			async handleGetListUser() {
				const param = {
					page: this.currentPage,
					per_page: this.perPage
				};
				await getUserTable(param)
					.then(res => {
						if (res.status === 200) {
							this.listUser.push(res.data.data);
							this.listUser.map(item => {
								this.listUser = item;
							});
						}
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleCreateUser() {
				const data = {};
				await postUser(data)
					.then(res => {
						if (res.status === 200) {
							console.log(res);
						}
					})
					.catch(err => {
						console.log(err);
					});
			}
		}
	};
</script>
