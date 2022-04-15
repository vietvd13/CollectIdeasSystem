<template>
	<div class="account-management">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="account-management__header">
			<div class="account-management__header-title">
				<h4>{{ $t('DEPARTMENT.TITLE') }}</h4>
			</div>
			<div class="account-management__header-actions">
				<button class="btn btn-primary" @click="handleModal()" v-b-modal.modal-1>{{
					$t('DEPARTMENT.CREATE')
				}}</button>
			</div>
		</div>
		<div class="account-management__searching">
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
				:per-page="params.perPage"
				:current-page="params.currentPage"
				:outlined="false"
				:fixed="false"
			>
				<b-thead>
					<b-th>
						<span>{{ $t('USER.TABLE.HEADING.ID') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('DEPARTMENT.TABLE.NAME') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('DEPARTMENT.TABLE.ACTIONS') }}</span>
					</b-th>
				</b-thead>
				<b-tbody>
					<tr v-for="(department, index) in listDepartments" :key="index">
						<td>{{ department.id }}</td>
						<td>{{ department.name }}</td>

						<td>
							<button @click="handleModal(department.id)" class="btn btn-warning">
								<i class="fas fa-edit"></i>
							</button>
							<button
								@click="handleDeleteDepartment(department.id)"
								class="btn btn-danger"
							>
								<i class="fas fa-trash-alt"></i>
							</button>
						</td>
					</tr>
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
				:title="
					action === 'CREATE'
						? $t('DEPARTMENT.ACTIONS.CREATE')
						: $t('DEPARTMENT.ACTIONS.EDIT')
				"
				centered
			>
				<div class="row mt-2">
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">Name</label>
						<b-form-input v-model="name"></b-form-input>
					</div>
				</div>
				<template #modal-footer>
					<div>
						<b-button
							class="btn btn-primary"
							v-if="action === 'CREATE'"
							@click="handleCreateDepartment()"
						>
							{{ $t('USER.FORM.CREATE') }}
						</b-button>

						<b-button
							class="btn btn-primary"
							v-if="action === 'EDIT'"
							@click="handleUpdateDepartment()"
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
	import {
		getDeparmentById,
		createDepartment,
		deleteDeparment,
		updateDepartment,
		getDepartment
	} from '@/api/modules/department';
	import { MakeToast } from '@/toast/toastMessage';
	import { isEmptyOrWhiteSpace } from '../../utils/validate';
	const paramInit = {
		perPage: 5,
		currentPage: 1
	};
	export default {
		name: 'DepartmentManagementList',
		data() {
			return {
				params: { ...paramInit },
				selected: null,
				options: [],
				isLoading: false,
				listDepartments: [],
				name: '',
				action: '',
				showModal: false,
				keyword: '',
				ids: 0
			};
		},
		computed: {
			rows() {
				return this.listDepartments.length;
			},
			isChangePage() {
				return this.params.currentPage;
			}
		},
		watch: {
			isChangePage() {
				this.handleGetListDepartment();
			}
		},
		methods: {
			async handleModal(id) {
				console.log(id, 'EDIT');
				this.ids = id;
				if (this.ids) {
					(this.action = 'EDIT'),
						await getDeparmentById(id)
							.then(res => {
								this.name = res.data.name;
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
			async handleGetListDepartment() {
				this.isLoading = true;
				await getDepartment()
					.then(res => {
						if (res.status === 200) {
							this.listDepartments = res.data.data;
							this.isLoading = false;
						}
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleCreateDepartment() {
				const data = {
					name: this.name
				};
				console.log(data);
				if (isEmptyOrWhiteSpace(data.name)) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				} else {
					await createDepartment(data)
						.then(res => {
							if (res.status === 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('USER.FORM.SUCCESS')
								});
								this.handleGetListDepartment();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			async handleUpdateDepartment() {
				this.action = 'EDIT';
				const data = {
					name: this.name
				};
				if (isEmptyOrWhiteSpace(data.name)) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				} else {
					console.log(data);
					await updateDepartment(this.ids, data)
						.then(res => {
							if (res.status == 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('USER.FORM.SUCCESS')
								});
								this.handleGetListDepartment();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			handleDeleteDepartment(id) {
				this.$bvModal
					.msgBoxConfirm('Do you want to delete this department?', {
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
							deleteDeparment(id)
								.then(res => {
									if (res.status === 200) {
										MakeToast({
											variant: 'success',
											title: this.$t('TOAST.SUCCESS'),
											content: 'Successfully to delete this user'
										});
										this.handleGetListDepartment();
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
				this.name = '';
			}
		}
	};
</script>
