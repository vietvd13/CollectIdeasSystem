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
			<b-table-simple
				id="my-table"
				class="text-center"
				responsive
				:outlined="false"
				:fixed="false"
				:items="listUser"
			>
				<b-thead>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.ID') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.AVATARs') }}</span>
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
						<td>
							<img :src="`$storage/${users.avatar_path}`" width="100px" alt="No Image Found" />
						</td>
						<td>{{ users.email }}</td>
						<td>{{ users.name }}</td>
						<td>{{ users.roles.name }}</td>
						<td>{{ users.birth }}</td>
						<td>
							<button @click="handleModal(users.id)" class="btn btn-warning">
								<i class="fas fa-edit"></i>
							</button>
							<button @click="handleDeleteUser(users.id)" class="btn btn-danger">
								<i class="fas fa-trash-alt"></i>
							</button>
						</td>
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
				aria-controls="my-table"
				v-model="params.currentPage"
				:per-page="params.perPage"
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
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.BIRTH') }}</label>
						<b-form-input type="date" v-model="newUser.birth"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('USER.FORM.AVATAR') }}</label>
						<b-form-file id="upload-images" type="file" accept="image/*" v-model="newUser.avatar"></b-form-file>
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
	import { MakeToast } from '@/toast/toastMessage';
	import { validPassword, validEmail, isEmptyOrWhiteSpace } from '../../utils/validate';
	import LazyLoad from '../../layout/Lazyload.vue';
	const paramInit = {
		perPage: 5,
		currentPage: 1
	};
	export default {
		name: 'AccountManagementList',
		components: {
			LazyLoad
		},
		data() {
			return {
				params: { ...paramInit },
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
				},
				action: '',
				showModal: false,
				keyword: '',
				ids: 0
			};
		},
		computed: {
			rows() {
				return this.listUser.length;
			},
			isChangePage() {
				return this.params.currentPage;
			}
		},
		watch: {
			isChangePage() {
				this.handleGetListUser();
			}
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
								console.log(res.data);
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
					const res = getDepartment();
					this.listDepartments = res.data.data
				} catch (error) {
					console.log(error);
				}	
			},
			async handleGetListUser() {
				this.isLoading = true;
				await getUserTable()
					.then(res => {
						if (res.status === 200) {
							this.listUser = res.data.data;
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
				formData.append('avatar', files)
				formData.append('name', this.newUser.name)
				formData.append('email', this.newUser.email)
				formData.append('password', this.newUser.password)
				formData.append('birth', this.newUser.birth)
				formData.append('role', this.newUser.role)
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
				const data = {
					name: this.newUser.name,
					new_password: this.newUser.password,
					birth: this.newUser.birth,
					role: this.newUser.role
				};
				if (
					isEmptyOrWhiteSpace(data.name) ||
					isEmptyOrWhiteSpace(data.birth) ||
					data.role === null
				) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				} else if (!validPassword(data.new_password)) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.PASSWORD')
					});
				} else {
					console.log(data);
					await editUser(this.ids, data)
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
					birth: ''
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
