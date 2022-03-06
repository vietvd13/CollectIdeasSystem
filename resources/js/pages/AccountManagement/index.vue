<template>
	<div class="account-management">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="account-management__header">
			<div class="account-management__header-title">
				<h4>{{ $t('USER.TITLE') }}</h4>
			</div>
			<div class="account-management__header-actions">
				<button class="btn btn-primary" v-b-modal.modal-1>{{
					$t('USER.CREATE_USER')
				}}</button>
			</div>
			<b-modal
				id="modal-1"
				:title="$t('USER.FORM.TITLE')"
				:ok-title="$t('USER.FORM.CREATE')"
				@ok="handleCreateUser()"
			>
				<div class="row mt-2">
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('USER.FORM.EMAIL') }}</label>
						<b-form-input v-model="newUser.email"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.PASSWORD') }}</label>
						<b-form-input v-model="newUser.password"></b-form-input>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('USER.FORM.ROLE') }}</label>
						<b-form-select v-model="newUser.role">
							<b-form-select-option :value="null">Select</b-form-select-option>
							<b-form-select-option
								v-for="(role, index) in options"
								:key="index"
								:value="role.id"
							>
								{{ role.name }}
							</b-form-select-option>
						</b-form-select>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.BIRTH') }}</label>
						<b-form-input type="date" v-model="newUser.birth"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.NAME') }}</label>
						<b-form-input type="text" v-model="newUser.name"></b-form-input>
					</div>
				</div>
			</b-modal>
		</div>
		<div class="account-management__searching">
			<div class="account-management__searching-filter">
				<label for="filer">{{ $t('USER.SEARCH_BY.ROLE') }}</label>
				<b-form-select v-model="selected">
					<b-form-select-option :value="null">Select</b-form-select-option>
					<b-form-select-option
						v-for="(role, index) in options"
						:key="index"
						:value="role.id"
						>{{ role.name }}</b-form-select-option
					>
				</b-form-select>
			</div>
			<div class="account-management__searching-keyword">
				<label for="keyword">{{ $t('USER.SEARCH_BY.KEYWORD') }}</label>
				<b-input-group>
					<b-form-input
						:placeholder="$t('USER.SEARCH_BY.PLACEHOLDER_KEYWORD')"
					></b-form-input>
					<b-input-group-append>
						<b-button variant="primary"><i class="fas fa-search"></i></b-button>
					</b-input-group-append>
				</b-input-group>
			</div>
		</div>
		<div class="account-management__content mt-3">
			<b-table-simple
				class="text-center"
				responsive
				:per-page="perPage"
				:current-page="currentPage"
				:outlined="false"
				:fixed="false"
			>
				<b-thead>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.ID') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.EMAIL') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.NAME') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.ROLE') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.BIRTH') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.ACTIONS') }}</span>
					</b-th>
				</b-thead>
				<b-tbody>
					<tr v-for="(users, index) in listUser" :key="index">
						<td>{{ users.id }}</td>
						<td>{{ users.email }}</td>
						<td>{{ users.name }}</td>
						<td>{{ users.name }}</td>
						<td>{{ users.birth }}</td>
						<td><i class="fas fa-ellipsis-h"></i></td>
					</tr>
					<LazyLoad
						@lazyload="
							handleGetListUser();
							getRole();
						"
					/>
				</b-tbody>
			</b-table-simple>
			<b-pagination
				v-model="currentPage"
				:per-page="perPage"
				:total-rows="rows"
				aria-controls="my-table"
			></b-pagination>
		</div>
	</div>
</template>

<script>
	import { getUserTable, postUser } from '@/api/modules/user';
	import { getListRole } from '@/api/modules/role';
	import { MakeToast } from '@/toast/toastMessage';

	import LazyLoad from '../../layout/Lazyload.vue';
	export default {
		name: 'AccountManagementList',
		components: {
			LazyLoad
		},
		data() {
			return {
				perPage: 15,
				currentPage: 1,
				selected: null,
				options: [],
				isLoading: false,
				listUser: [],
				selected: null,
				newUser: {
					email: '',
					password: '',
					name: '',
					role: null,
					birth: ''
				}
			};
		},
		computed: {
			rows() {
				return this.listUser.length;
			},
			isChangePage() {
				return this.currentPage;
			}
		},
		watch: {
			isChangePage() {
				this.handleGetListUser();
			}
		},
		methods: {
			async getRole() {
				await getListRole()
					.then(res => {
						this.options = res;
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleGetListUser() {
				this.isLoading = true;
				const params = {
					page: this.currentPage,
					per_page: this.perPage
				};
				await getUserTable(params)
					.then(res => {
						if (res.status === 200) {
							console.log(params);
							this.listUser.push(res.data.data);
							this.listUser.map(item => {
								this.listUser = item;
							});

							this.isLoading = false;
						}
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleCreateUser() {
				const data = {
					name: this.newUser.name,
					email: this.newUser.email,
					password: this.newUser.password,
					birth: this.newUser.birth,
					role: this.newUser.role
				};
				await postUser(data)
					.then(res => {
						if (res.status === 200) {
							console.log(res);
							this.handleGetListUser();
							MakeToast({
								variant: 'success',
								title: this.$t('TOAST.SUCCESS'),
								content: this.$t('USER.FORM.SUCCESS')
							});
						}
					})
					.catch(err => {
						console.log(err);
					});
			}
		}
	};
</script>
