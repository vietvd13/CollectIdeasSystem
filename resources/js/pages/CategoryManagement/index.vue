<template>
	<div class="category-management">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="category-management__header">
			<div class="category-management__header-title">
				<h4>{{ $t('CATEGORY.TITLE') }}</h4>
			</div>
			<div class="category-management__header-actions">
				<button class="btn btn-primary" @click="handleModal()" v-b-modal.modal-1>{{
					$t('CATEGORY.CREATE_CATEGORY')
				}}</button>
			</div>
		</div>
		<div class="category-management__searching">
			<div class="category-management__searching-filter">
				<label for="filer">{{ $t('CATEGORY.SEARCH_BY.TYPE') }}</label>
				<b-form-select v-model="selected">
					<b-form-select-option :value="null">{{
						$t('CATEGORY.SELECT_TYPE')
					}}</b-form-select-option>
					<b-form-select-option
						v-for="(type, index) in listCategory"
						:key="index"
						:value="type.topic_name"
						>{{ type.topic_name }}</b-form-select-option
					>
				</b-form-select>
			</div>
			<div class="category-management__searching-keyword">
				<label for="keyword">{{ $t('CATEGORY.SEARCH_BY.KEYWORD') }}</label>
				<b-input-group>
					<b-form-input
						:placeholder="$t('CATEGORY.SEARCH_BY.PLACEHOLDER_KEYWORD')"
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
		<div class="category-management__content mt-3">
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
						<span>{{ $t('CATEGORY.TABLE.HEADING.NAME') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('CATEGORY.TABLE.HEADING.START') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('CATEGORY.TABLE.HEADING.END') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('CATEGORY.TABLE.HEADING.DESCRIPTION') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('CATEGORY.TABLE.HEADING.OWNER') }}</span>
					</b-th>
					<b-th>
						<span>{{ $t('CATEGORY.TABLE.HEADING.ACTIONS') }}</span>
					</b-th>
				</b-thead>
				<b-tbody>
					<tr v-for="(Category, index) in listCategory" :key="index">
						<td>{{ Category.topic_name }}</td>
						<td>{{ Category.start_collect_date }}</td>
						<td>{{ Category.end_collect_date }}</td>
						<td>{{ Category.description }}</td>
						<td>{{ Category.user.name }}</td>
						<td>
							<button @click="handleModal(Category.id)" class="btn btn-warning">
								<i class="fas fa-edit"></i>
							</button>
							<button
								@click="handleDeleteCategory(Category.id)"
								class="btn btn-danger"
							>
								<i class="fas fa-trash-alt"></i>
							</button>
						</td>
					</tr>
					<LazyLoad
						@lazyload="
							handleGetListCategory();
							getOwner();
						"
					/>
				</b-tbody>
			</b-table-simple>
			<b-pagination
				v-model="params.currentPage"
				:per-page="params.perPage"
				:total-rows="rows"
				aria-controls="my-table"
			></b-pagination>
			<b-modal
				id="modal-1"
				v-model="showModal"
				:title="
					action === 'CREATE' ? $t('CATEGORY.FORM.TITLE') : $t('CATEGORY.EDIT_CATEGORY')
				"
				centered
			>
				<div class="row mt-2">
					<div class="col-md-12 col-sm-12 col-lg-12">
						<label for="">{{ $t('CATEGORY.FORM.CATEGORY_NAME') }}</label>
						<b-form-input type="text" v-model="newCategory.topic_name"></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('CATEGORY.FORM.START_DATE') }}</label>
						<b-form-input
							type="date"
							v-model="newCategory.start_collect_date"
						></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('CATEGORY.FORM.END_DATE') }}</label>
						<b-form-input
							type="date"
							:readonly="action === 'EDIT' ? true : false"
							v-model="newCategory.end_collect_date"
						></b-form-input>
					</div>
					<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
						<label for="">{{ $t('CATEGORY.FORM.DESCRIPTION') }}</label>
						<b-form-textarea
							id="textarea-rows"
							rows="4"
							v-model="newCategory.description"
						></b-form-textarea>
					</div>
				</div>
				<template #modal-footer>
					<div>
						<b-button
							class="btn btn-primary"
							v-if="action === 'CREATE'"
							@click="handleCreateCategory()"
						>
							{{ $t('CATEGORY.FORM.CREATE') }}
						</b-button>

						<b-button
							class="btn btn-primary"
							v-if="action === 'EDIT'"
							@click="handleEditCategory()"
						>
							{{ $t('CATEGORY.FORM.SAVE') }}
						</b-button>

						<b-button class="btn btn-danger" @click="showModal = false">
							{{ $t('CATEGORY.FORM.CLOSE') }}
						</b-button>
					</div>
				</template>
			</b-modal>
		</div>
	</div>
</template>

<script>
	import {
		getCategoryTable,
		postCategory,
		deleteCategory,
		getOneCategory,
		editCategory
	} from '@/api/modules/category';
	import { MakeToast } from '@/toast/toastMessage';
	import { isEmptyOrWhiteSpace } from '../../utils/validate';
	import LazyLoad from '../../layout/Lazyload.vue';
	const paramInit = {
		perPage: 5,
		currentPage: 1
	};
	export default {
		name: 'CategoryManagement',
		components: {
			LazyLoad
		},
		data() {
			return {
				params: { ...paramInit },
				perPage: 15,
				currentPage: 1,
				showModal: false,
				selected: null,
				isLoading: false,
				listCategory: [],
				newCategory: {
					id: '',
					topic_name: '',
					start_collect_date: '',
					end_collect_date: '',
					owner: '',
					description: ''
				},
				options: [],
				action: '',
				keyword: '',
				ids: 0
			};
		},
		computed: {
			rows() {
				return this.listCategory.length;
			},
			isChangePage() {
				return this.params.currentPage;
			},
			name() {
				return this.$store.getters.name;
			}
		},
		watch: {
			isChangePage() {
				this.handleGetListCategory();
			}
		},
		methods: {
			async handleModal(id) {
				console.log(id, 'EDIT');
				this.ids = id;
				if (this.ids) {
					this.action = 'EDIT';
					await getOneCategory(id)
						.then(res => {
							this.newCategory.topic_name = res.data.topic_name;
							this.newCategory.start_collect_date = res.data.start_collect_date;
							this.newCategory.end_collect_date = res.data.end_collect_date;
							this.newCategory.description = res.data.description;
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
			async handleGetListCategory() {
				const params = this.params;
				this.isLoading = true;
				await getCategoryTable(params)
					.then(res => {
						if (res.status === 200) {
							console.log(res);
							this.listCategory = res.data.data;
							this.isLoading = false;
						}
					})
					.catch(err => {
						console.log(err);
					});
			},
			async handleCreateCategory() {
				console.log(this.newCategory);
				const data = {
					topic_name: this.newCategory.topic_name,
					start_collect_date: this.newCategory.start_collect_date,
					end_collect_date: this.newCategory.end_collect_date,
					description: this.newCategory.description
				};
				console.log(data);
				if (
					isEmptyOrWhiteSpace(data.topic_name) ||
					isEmptyOrWhiteSpace(data.start_collect_date) ||
					isEmptyOrWhiteSpace(data.end_collect_date) ||
					isEmptyOrWhiteSpace(data.description)
				) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('CATEGORY.FORM.MESSAGE.SPACE')
					});
				} else {
					await postCategory(data)
						.then(res => {
							if (res.status === 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('CATEGORY.FORM.SUCCESS')
								});
								this.handleGetListCategory();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			async handleEditCategory() {
				this.action = 'EDIT';
				const data = {
					topic_name: this.newCategory.topic_name,
					start_collect_date: this.newCategory.start_collect_date,
					end_collect_date: this.newCategory.end_collect_date,
					description: this.newCategory.description
				};
				if (
					isEmptyOrWhiteSpace(data.topic_name) ||
					isEmptyOrWhiteSpace(data.start_collect_date) ||
					isEmptyOrWhiteSpace(data.end_collect_date) ||
					isEmptyOrWhiteSpace(data.description)
				) {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('CATEGORY.FORM.MESSAGE.SPACE')
					});
				} else {
					console.log(data);
					await editCategory(this.ids, data)
						.then(res => {
							if (res.status == 200) {
								MakeToast({
									variant: 'success',
									title: this.$t('TOAST.SUCCESS'),
									content: this.$t('CATEGORY.FORM.SUCCESS')
								});
								this.handleGetListCategory();
								this.showModal = false;
								this.isResetDataModal();
							}
						})
						.catch(err => {
							console.log(err);
						});
				}
			},
			handleDeleteCategory(id) {
				this.$bvModal
					.msgBoxConfirm('Do you want to delete this category?', {
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
							deleteCategory(id)
								.then(res => {
									if (res.status === 200) {
										MakeToast({
											variant: 'success',
											title: this.$t('TOAST.SUCCESS'),
											content: 'Successfully to delete this category'
										});
										this.handleGetListCategory();
									} else {
										MakeToast({
											variant: 'warning',
											title: this.$t('TOAST.WARNING'),
											content: 'You can not delete this category'
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
			handleSearchByKeyWords(keysearch) {
				this.listCategory = this.listCategory.filter(item => {
					if (item.topic_name.toLowerCase() === this.keyword.toLowerCase()) {
						return item;
					} else if (this.keyword === '') {
						this.handleGetListCategory();
					} else {
						console.log('No data');
					}
				});
			},
			isResetDataModal() {
				console.log('RESET DATA');
				this.newCategory = {
					id: '',
					topic_name: '',
					start_collect_date: '',
					end_collect_date: '',
					description: ''
				};
			}
		}
	};
</script>

<style>
	.category-management__header {
		display: flex;
		justify-content: space-between;
		align-content: center;
	}
	.category-management {
		padding: 20px;
	}
	.category-management__header-actions button {
		background: #242368;
	}
	.pagination {
		float: right;
	}
	.category-management__searching {
		display: flex;
		/* justify-content: flex-start;
    align-items: center; */
		margin-top: 20px;
	}
	.category-management__searching > div {
		width: 25%;
		margin-right: 40px;
	}
	.category-management__searching input {
		background: white;
	}
	.category-management__searching button {
		background: #242368;
	}
	.category-management table thead {
		background: #242368;
		color: white;
	}
	.category-management .page-item.active .page-link {
		background-color: #242368;
		border-color: #242368;
	}
</style>
