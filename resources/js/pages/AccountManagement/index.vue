<template>
	<div class="account-management">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="account-management__header">
			<div class="account-management__header-title">
				<h4>{{ $t('USER.TITLE') }}</h4>
			</div>
			<div class="account-management__header-actions">
				<button class="btn btn-primary" @click="handleModal()" v-b-modal.modal-1>{{
					$t('USER.CREATE_USER')
				}}</button>
			</div>
		</div>
		<div class="account-management__searching">
			<div class="account-management__searching-filter">
				<label for="filer">{{ $t('USER.SEARCH_BY.ROLE') }}</label>
				<b-form-select v-model="selected" @change="handleSearchByRole()">
					<b-form-select-option :value="null">{{
						$t('USER.SELECT_ROLE')
					}}</b-form-select-option>
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
						v-model="keyword"
						@change="handleSearchByKeyWords()"
					></b-form-input>
					<b-input-group-append>
						<b-button variant="primary" @click="handleSearchByKeyWords()"
							><i class="fas fa-search"></i
						></b-button>
					</b-input-group-append>
				</b-input-group>
			</div>
		</div>
		<div class="account-management__content mt-3">
			<b-table
				id="my-table"
				class="text-left"
				:fields="vFileds"
				:items="listUser"
				responsive
				:outlined="false"
				:fixed="false"
			>
				<template #cell(roles)="item">
					{{ item.item.roles[0].name }}
				</template>
				<template #cell(avatar_path)="item">
					<img
						:src="`storage/${item.item.avatar_path}`"
						width="100px"
						height="100px"
						style="border-radius: 50%"
						alt=""
					/>
				</template>
				<template #cell(actions)="item">
					<button @click="handleModal(item.item.id)" class="btn btn-warning">
						<i class="fas fa-edit"></i>
					</button>
					<button @click="handleDeleteUser(item.item.id)" class="btn btn-danger">
						<i class="fas fa-trash-alt"></i>
					</button>
				</template>
			</b-table>
			<b-pagination
				aria-controls="my-table"
				v-model="params.page"
				:per-page="params.per_page"
				:total-rows="rows"
			></b-pagination>

			<b-modal
				id="modal-1"
				v-model="showModal"
				:title="action === 'CREATE' ? $t('USER.FORM.TITLE') : 'EDIT User'"
				centered
			>
				<div class="row mt-2">
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('USER.FORM.EMAIL') }}</label>
						<b-form-input
							:readonly="action === 'EDIT' ? true : false"
							v-model="newUser.email"
						></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.PASSWORD') }}</label>
						<b-form-input type="password" v-model="newUser.password"></b-form-input>
					</div>
					<div class="row mt-2"> </div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.NAME') }}</label>
						<b-form-input type="text" v-model="newUser.name"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('USER.FORM.ROLE') }}</label>
						<b-form-select v-model="newUser.role">
							<b-form-select-option :value="null">{{
								$t('USER.SELECT_ROLE')
							}}</b-form-select-option>
							<b-form-select-option
								v-for="(role, index) in options"
								:key="index"
								:value="role.id"
							>
								{{ role.name }}
							</b-form-select-option>
						</b-form-select>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('USER.FORM.DEPARTMENT') }}</label>
						<b-form-select v-model="newUser.department_id">
							<b-form-select-option :value="null">{{
								$t('USER.FORM.SELECT_DEPARTMENT')
							}}</b-form-select-option>
							<b-form-select-option
								v-for="(department, index) in listDepartments"
								:key="index"
								:value="department.id"
							>
								{{ department.name }}
							</b-form-select-option>
						</b-form-select>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.BIRTH') }}</label>
						<b-form-input type="date" v-model="newUser.birth"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.AVATAR') }}</label>
						<b-form-file
							id="upload-images"
							type="file"
							accept="image/*"
							v-model="newUser.avatar"
						></b-form-file>
					</div>
				</div>
				<template #modal-footer>
					<div>
						<b-button
							class="btn btn-primary"
							v-if="action === 'CREATE'"
							@click="handleCreateUser()"
						>
							{{ $t('USER.FORM.CREATE') }}
						</b-button>

						<b-button
							class="btn btn-primary"
							v-if="action === 'EDIT'"
							@click="handleEditUser()"
						>
							{{ $t('USER.FORM.SAVE') }}
						</b-button>

						<b-button class="btn btn-danger" @click="showModal = false">
							{{ $t('USER.FORM.CLOSE') }}
						</b-button>
					</div>
				</template>
			</b-modal>
		</div>
	</div>
</template>

<script>
	import { getUserTable, postUser, deleteUser, getOneUser, editUser } from '@/api/modules/user';
	import { getListRole } from '@/api/modules/role';
	import { getDepartment } from '@/api/modules/department';
	import { MakeToast } from '@/toast/toastMessage';
	import { validPassword, validEmail, isEmptyOrWhiteSpace } from '../../utils/validate';
	import LazyLoad from '../../layout/Lazyload.vue';
	export default {
		name: 'AccountManagementList',
		components: {
			LazyLoad
		},
		data() {
			return {
				params: {
					per_page: 5,
					page: 1
				},
				selected: null,
				options: [],
				isLoading: false,
				listUser: [],
				listDepartments: [],
				newUser: {
					email: '',
					password: '',
					name: '',
					role: null,
					birth: '',
					avatar: null,
					department_id: null
				},
				action: '',
				showModal: false,
				keyword: '',
				ids: 0,
				total: 0,
				vFileds: [
					{
						key: 'id',
						label: this.$t('USER.TABLE.HEADING.ID')
					},
					{
						key: 'avatar_path',
						label: this.$t('USER.TABLE.HEADING.AVATARS')
					},
					{
						key: 'email',
						label: this.$t('USER.TABLE.HEADING.EMAIL')
					},
					{
						key: 'name',
						label: this.$t('USER.TABLE.HEADING.NAME')
					},
					{
						key: 'roles',
						label: this.$t('USER.TABLE.HEADING.ROLE')
					},
					{
						key: 'birth',
						label: this.$t('USER.TABLE.HEADING.BIRTH')
					},
					{
						key: 'actions',
						label: this.$t('USER.TABLE.HEADING.ACTIONS')
					}
				]
			};
		},
		computed: {
			rows() {
				return this.total;
			},
			isChangePage() {
				return this.params.page;
			}
		},
		watch: {
			isChangePage() {
				this.handleGetListUser();
			}
		},
		created() {
			this.handleGetListUser();
			this.getRole();
			this.handleGetDepartment();
		},
		methods: {
			async handleModal(id) {
				console.log(id, 'EDIT');
				this.ids = id;
				if (this.ids) {
					(this.action = 'EDIT'),
						await getOneUser(id)
							.then(res => {
								this.newUser.name = res.data.name;
								this.newUser.email = res.data.email;
								res.data.roles.map(item => {
									this.newUser.role = item.id;
								});
								this.newUser.birth = res.data.birth;
							})
							.catch(err => {
								console.log(err);
							});
				} else {
					this.isResetDataModal();
					this.action = 'CREATE';
					console.log('CREATE');
				}
				this.showModal = true;
			},
			async getRole() {
				await getListRole()
					.then(res => {
						this.options = res;
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleGetDepartment() {
				try {
					const res = await getDepartment();
					this.listDepartments = res.data.data;
				} catch (error) {
					console.log(error);
				}
			},
			async handleGetListUser() {
				this.isLoading = true;
				await getUserTable(this.params)
					.then(res => {
						if (res.status === 200) {
							this.listUser = res.data.data;
							this.total = res.data.total;
							console.log(this.listUser);
							this.isLoading = false;
						}
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleCreateUser() {
				console.log(this.newUser);
				let files = document.getElementById('upload-images').files[0];
				let formData = new FormData();
				formData.append('avatar_path', files);
				formData.append('name', this.newUser.name);
				formData.append('email', this.newUser.email);
				formData.append('password', this.newUser.password);
				formData.append('birth', this.newUser.birth);
				formData.append('role', this.newUser.role);
				formData.append('department_id', this.newUser.department_id);
				if (
					isEmptyOrWhiteSpace(this.newUser.name) ||
					isEmptyOrWhiteSpace(this.newUser.birth) ||
					this.newUser.role === null
				) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				} else if (!validEmail(this.newUser.email)) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.EMAIL')
					});
				} else if (!validPassword(this.newUser.password)) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.PASSWORD')
					});
				} else {
					await postUser(formData)
						.then(res => {
							if (res.status === 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('USER.FORM.SUCCESS')
								});
								this.handleGetListUser();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			async handleEditUser() {
				this.action = 'EDIT';
				let formData = new FormData();
				let files = document.getElementById('upload-images').files[0];
				formData.append('avatar_path', files);
				formData.append('name', this.newUser.name);
				formData.append('birth', this.newUser.birth);
				formData.append('role', this.newUser.role);
				formData.append('department_id', this.newUser.department_id);
				if (
					isEmptyOrWhiteSpace(this.newUser.name) ||
					isEmptyOrWhiteSpace(this.newUser.birth) ||
					this.newUser.role === null
				) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				} else {
					await editUser(this.ids, formData)
						.then(res => {
							if (res.status == 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('USER.FORM.SUCCESS')
								});
								this.handleGetListUser();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			handleDeleteUser(id) {
				this.$bvModal
					.msgBoxConfirm('Do you want to delete this user?', {
						title: 'Warning',
						size: 'sm',
						buttonSize: 'sm',
						okVariant: 'danger',
						okTitle: 'OK',
						cancelTitle: 'Cancel',
						footerClass: 'p-2',
						hideHeaderClose: false,
						centered: true
					})
					.then(value => {
						if (value === true) {
							deleteUser(id)
								.then(res => {
									if (res.status === 200) {
										MakeToast({
											variant: 'success',
											title: this.$t('TOAST.SUCCESS'),
											content: 'Successfully to delete this user'
										});
										this.handleGetListUser();
									} else {
										MakeToast({
											variant: 'warning',
											title: this.$t('TOAST.WARNING'),
											content: 'You can not delete this user'
										});
									}
									console.log(res);
								})
								.catch(err => {
									console.log(err);
								});
						}
					});
			},
			isResetDataModal() {
				console.log('RESET DATA');
				this.newUser = {
					email: '',
					password: '',
					name: '',
					role: null,
					birth: '',
					department_id: null
				};
			},
			handleSearchByKeyWords() {
				this.listUser = this.listUser.filter(item => {
					if (item.name.toLowerCase() == this.keyword.toLowerCase()) {
						return item;
					} else if (this.keyword == '') {
						this.handleGetListUser();
					} else {
						this.listUser = [];
					}
				});
			},
			handleSearchByRole() {
				this.listUser = this.listUser.filter(item => {
					if (item.roles[0].id === this.selected) {
						return item;
					} else if (this.selected === null) {
						this.handleGetListUser();
					} else {
						console.log('No data');
					}
				});
			}
		}
	};
</script>
