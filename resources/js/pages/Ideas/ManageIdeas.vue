<template>
	<div class="manage-ideas">
		<div v-if="isLoading" class="loading">
			<i class="spinner-border" />
		</div>
		<div class="manage-ideas__content row align-items-center justify-content-center">
			<div class="manage-ideas__content-post col-12 col-sm-12 col-md-10 col-lg-10 col-xl-6">
				<div class="card" v-if="getRole === 'STAFF'">
					<div class="card-body area-post">
						<b-avatar
							variant="info"
							src="https://placekitten.com/300/300"
							class="mr-3"
						/>
						<b-input
							readonly
							:placeholder="$t('IDEA.PLACEHOLDER_INPUT_IDEAD', { name: fullname })"
							v-b-modal.modal-ideas
						/>
					</div>
				</div>
				<div v-for="(idea, index) in listPost" :key="index" class="area-content card">
					<b-card>
						<div class="area-content__header">
							<div class="area-content__header-avatar">
								<b-avatar
									:src="`/storage/${idea['user']['avatar_path']}`"
									class="mr-3"
								></b-avatar>
							</div>
							<div class="area-content__header-text">
								<div class="q-box">
									<span class="q-box">
										<b>
											{{ idea['user']['name'] }}
										</b>
									</span>
								</div>
							</div>
						</div>

						<div class="area-content__post">
							<div class="post-category">
								<h4></h4>
							</div>
							<div class="post-content">
								<span>{{ idea.contents }}</span>
								<!-- <div class="attachment">
									<b>Attachment</b>
									<a href=""> <i class="fas fa-download"></i> File Name</a>
									<a href=""> <i class="fas fa-download"></i> File Name</a>
								</div> -->
							</div>
						</div>

						<template #footer>
							<b-row>
								<b-col style="border: 1px solid #">
									<b>
										{{ idea.likes_count }}
										<i class="fas fa-thumbs-up" style="color: #0571ed"></i>
									</b>

									<b>
										{{ idea.dislike_count }}
										<i class="fas fa-thumbs-down" style="color: #0571ed"></i>
									</b>
								</b-col>
							</b-row>
							<b-row class="mt-2">
								<b-col cols="6" sm="6" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div
											:class="{
												'btn-react': true,
												'btn-react-active':
													handleStatusReact(idea['likes']) === 1
											}"
											@click="handleLike(idea.id, index)"
										>
											<i class="far fa-thumbs-up" />
											<span>{{ $t('IDEA.BUTTON_LIKE') }}</span>
										</div>
									</div>
								</b-col>
								<b-col cols="6" sm="6" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div
											:class="{
												'btn-react': true,
												'btn-react-active':
													handleStatusReact(idea['likes']) === 0
											}"
											@click="handleUnlike(idea.id, index)"
										>
											<i class="far fa-thumbs-down" />
											<span>{{ $t('IDEA.BUTTON_UNLIKE') }}</span>
										</div>
									</div>
								</b-col>
								<b-col cols="12" sm="12" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div
											@click="showModal(true, idea.id)"
											:class="{ 'btn-react': true }"
										>
											<i class="far fa-comment" />
											<span>{{ $t('IDEA.BUTTON_COMMENT') }}</span>
										</div>
									</div>
								</b-col>
							</b-row>
						</template>
					</b-card>
				</div>
			</div>
		</div>

		<div
			style="display: flex; text-align: center; justify-content: center; margin-top: 30px"
			v-if="pagination.total > 5"
		>
			<b-pagination
				v-model="pagination.page"
				:total-rows="pagination.total"
				:per-page="pagination.per_page"
			/>
		</div>

		<b-modal v-model="isShowModalPost" id="modal-ideas" title="Your Ideas" size="lg">
			<div class="row mt-2">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<label for="">{{ $t('IDEA.UPLOAD.CONTENT') }}</label>
					<b-form-textarea v-model="data.contents" rows="8" />
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-3">
					<label for="">{{ $t('IDEA.UPLOAD.ACTIONS') }}</label>

					<b-form-file
						multiple="multiple"
						ref="file"
						accept=".pdf,image/*"
						id="upload-ideas"
					></b-form-file>
				</div>
			</div>
			<b-row class="mt-2">
				<b-col>
					<b-form-checkbox
						id="checkbox-liences"
						v-model="liences"
						name="checkbox-liences"
						:value="true"
						:unchecked-value="false"
					>
						{{ $t('IDEA.LICENSE.CONFIRM') }}.
						<b-link v-b-modal.modal-liences>{{ $t('IDEA.LICENSE.TEXT') }}</b-link>
					</b-form-checkbox>
				</b-col>
			</b-row>

			<template #modal-footer>
				<div>
					<b-button class="btn btn-danger" @click="showModalCreate(false)">
						{{ $t('USER.FORM.CLOSE') }}
					</b-button>
					<b-button type="submit" class="btn btn-primary" @click="handlePostIdea()">
						Post
					</b-button>
				</div>
			</template>
		</b-modal>

		<b-modal
			v-model="isShowModal"
			id="detail-ideas"
			@hidden="disconnectComment(modalData.id)"
			size="xl"
			scrollable
			hide-header
			centered
		>
			<div class="row detail-ideas">
				<div class="col-md-6 col-lg-6 col-sm-12 detail-ideas__content">
					<p class="text-justify">
						{{ modalData.contents }}
					</p>
					<!-- <div class="attachment">
						<a href="">Link 1</a>
						<a href="">Link 2</a>
					</div> -->
				</div>
				<div class="col-md-6 col-lg-6 col-sm-12 detail-ideas__comment">
					<header class="d-flex align-items-center">
						<div class="user-avatar">
							<b-avatar
								variant="info"
								:src="
									modalData['user']['avatar_path']
										? `/storage/${modalData['user']['avatar_path']}`
										: ''
								"
								class="mr-3"
							/>
						</div>
						<div class="user-infor">
							<b>{{ modalData['user']['name'] }}</b>
						</div>
					</header>
					<div class="list-comment">
						<div class="list">
							<div
								class="section-comment"
								v-for="(item, index) in handleListComment(modalData['comments'])"
								:key="`comment-no-${index + 1}`"
							>
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											:src="
												item['user']['avatar_path']
													? `/storage/${item['user']['avatar_path']}`
													: ''
											"
											class="mr-3"
										/>
										<b>{{ item.user['name'] }}</b>
									</div>
									<i class="fas fa-ellipsis-h float-right" />
								</div>
								<div class="user-comment">
									<div>
										<span>
											{{ item['comment'] }}
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="write-comment">
						<b-input-group>
							<b-form-input
								v-model="comment"
								type="text"
								placeholder="Add your comment....."
								@keyup.enter="onClickSendComment(modalData['id'])"
							/>
							<b-input-group-append
								is-text
								@click="onClickSendComment(modalData['id'])"
							>
								<i class="fal fa-paper-plane" />
							</b-input-group-append>
						</b-input-group>
					</div>
				</div>
			</div>
		</b-modal>
		<b-modal id="modal-liences" title="Liences" size="lg">
			<b-row>
				<b-col cols="12">
					<p class="text-justify">
						{{ $t('IDEA.LICENSE.CONTENT_CAT') }}
					</p>
				</b-col>

				<b-col cols="12">
					<h5>{{ $t('IDEA.LICENSE.DEVELOP_DUTIES') }}</h5>
				</b-col>

				<b-col cols="12">
					<p>
						{{ $t('IDEA.LICENSE.THE_CLIENT') }}
					</p>

					<ol>
						<li>
							<p>
								{{ $t('IDEA.LICENSE.THE_DEVELOPER_SHALL') }}
							</p>
						</li>

						<li>
							<p>
								{{ $t('IDEA.LICENSE.FOR_A_PERIODL') }}
							</p>
						</li>

						<li>
							<p>
								{{ $t('IDEA.LICENSE.EXPRESSLY_PROVIDER') }}
							</p>
						</li>

						<li>
							<p>
								{{ $t('IDEA.LICENSE.TERMINATE') }}
							</p>
						</li>

						<li>
							<p>
								{{ $t('IDEA.LICENSE.DELIVERY_DATE') }}
							</p>
						</li>
					</ol>
				</b-col>

				<b-col cols="12">
					<h5> {{ $t('IDEA.LICENSE.DELYVERY') }} </h5>
				</b-col>

				<b-col cols="12">
					<p>
						{{ $t('IDEA.LICENSE.DELIVERY_DATE') }}
					</p>

					<ol>
						<li>
							<p>
								{{ $t('IDEA.LICENSE.SOFTWARE_AS_DELIVERY') }}
							</p>
						</li>

						<li>
							<p>
								{{ $t('IDEA.LICENSE.ACCEPTANCE_DATE') }}
							</p>
						</li>
					</ol>
				</b-col>
			</b-row>
		</b-modal>
	</div>
</template>

<script>
	import LazyLoad from '../../layout/Lazyload.vue';
	import {
		postIdeas,
		getListIdeas,
		reactIdea,
		commentIdea,
		getListComments
	} from '@/api/modules/idea';
	import { MakeToast } from '@/toast/toastMessage';
	import { isEmptyOrWhiteSpace } from '../../utils/validate';

	export default {
		name: 'Ideas',
		components: {
			LazyLoad
		},
		data() {
			return {
				rerender: 1,
				isShowModal: false,
				isShowModalPost: false,
				selected: null,
				liences: false,
				data: {
					category_id: null,
					contents: '',
					files: []
				},
				isLoading: false,
				listPost: [],
				id: this.$route.params.category,
				count: 0,
				isLike: false,
				user: '',
				modalData: {
					id: '',
					contents: '',
					owner: '',
					category_id: '',
					deleted_at: null,
					created_at: '',
					updated_at: '',
					likes_count: 0,
					comments: [],
					likes: [],
					user: {
						id: '',
						department_id: '',
						name: '',
						email: '',
						birth: '',
						avatar_path: '',
						created_at: '',
						updated_at: ''
					}
				},
				comment: '',
				pagination: {
					page: 1,
					per_page: 5,
					total: 0
				},
				isPostComment: false,
				likes_count: 0
			};
		},
		computed: {
			language() {
				return this.$store.getters.language;
			},
			fullname() {
				return this.$store.getters.name;
			},
			pageChange() {
				return this.pagination.page;
			},
			totalLike() {
				return this.like_count;
			},
			getRole() {
				return this.$store.getters.roles[0];
			}
		},
		watch: {
			pageChange() {
				this.handleGetListIdeas();
			}
		},
		created() {
			this.connect();
			this.handleGetListIdeas();
		},
		destroyed() {
			window.Echo.channel('collect_idea').stopListening('.idea-post');
		},
		methods: {
			async onClickSendComment(id) {
				const DATA = {
					idea_id: id,
					comment: this.comment
				};

				try {
					const res = await commentIdea(DATA);
				} catch (error) {
					console.log(error);
				}

				this.comment = '';
			},
			handleStatusReact(likes) {
				const ID = this.$store.getters.id;

				const len = likes.length;
				let idx = 0;

				while (idx < len) {
					if (likes[idx]['owner'] === ID) {
						console.log('Passs');
						if (likes[idx].status === 0) return 0;
						if (likes[idx].status === 1) return 1;
					}

					idx++;
				}

				return -1;
			},
			connect() {
				window.Echo.channel('collect_idea').listen('.idea-post', data => {
					MakeToast({
						variant: 'success',
						title: this.$t('IDEA.TITLE_NEW_IDEA'),
						content: this.$t('IDEA.MESSAGE_NEW_IDEA')
					});
					this.listPost.push(data.payload);
					this.handleGetListIdeas();
				});
			},
			resetDataModal() {
				let data = {
					category_id: null,
					contents: '',
					files: []
				};

				this.data = data;
			},
			async showModal(e, id) {
				await this.connectComment(id);
				this.modalData = this.findIdeadById(this.listPost, id);
				await this.getListCommet(id);
				this.isShowModal = e;
			},
			async getListCommet(id) {
				const URL = `/comments/load?idea_id=${id}&limit=10000`;

				try {
					const res = await getListComments(URL);

					this.modalData.comments = res['data'];
				} catch (err) {
					console.log(err);
				}
			},
			handleListComment(list) {
				const len = list.length;
				let idx = 0;

				while (idx < len) {
					list[idx]['user']['avatar_path'] = list[idx]['user']['avatar_path']
						? list[idx]['user']['avatar_path']
						: '';
					const checkPrivate = this.isPrivate(list[idx]['comment']);
					list[idx]['comment'] = checkPrivate['private']
						? checkPrivate['comment']
						: list[idx]['comment'];
					list[idx]['user']['name'] = checkPrivate['private']
						? 'Anonymous'
						: list[idx]['user']['name'];
					list[idx]['user']['avatar_path'] = checkPrivate['private']
						? ''
						: list[idx]['user']['avatar_path'];

					idx++;
				}

				return list;
			},
			isPrivate(comment) {
				const re = /\/private (.*)/;

				const result = comment.match(re);

				if (result) {
					return {
						private: true,
						comment: result[1]
					};
				}

				return {
					private: false,
					comment: comment
				};
			},
			connectComment(id) {
				window.Echo.channel('collect_idea').listen(`.idea-comment-${id}`, data => {
					const newComment = {
						id: data['attributes']['comment']['id'],
						idea_id: data['attributes']['comment']['idea_id'],
						comment: data['attributes']['comment']['comment'],
						created_at: data['attributes']['comment']['created_at'],
						updated_at: data['attributes']['comment']['updated_at'],
						user: data['attributes']['owner']
					};

					this.modalData['comments'].push(newComment);
				});
			},
			disconnectComment(id) {
				window.Echo.channel('collect_idea').stopListening(`.idea-comment-${id}`);
			},
			showModalCreate(e) {
				this.resetData();
				this.isShowModalPost = e;
			},
			handleLike(id, index) {
				this.handleActionReact(id, 1, index);
			},
			handleUnlike(id, index) {
				this.handleActionReact(id, 0, index);
			},
			handleUpdateListPost(status, index, new_total_like, new_total_dislike) {
				const item = this.listPost[index].likes;

				this.listPost[index]['likes_count'] = new_total_like;
				this.listPost[index]['dislike_count'] = new_total_dislike;

				if (item.length > 0) {
					switch (status) {
						case 'like': {
							this.listPost[index].likes[0].status = 1;
							break;
						}

						case 'dislike': {
							this.listPost[index].likes[0].status = 0;

							break;
						}

						default: {
							this.listPost[index].likes[0].status = -1;
						}
					}
				} else {
					switch (status) {
						case 'like': {
							this.listPost[index].likes.push({ status: 1 });

							break;
						}

						case 'dislike': {
							this.listPost[index].likes.push({ status: 0 });

							break;
						}

						default: {
							this.listPost[index].likes.push({ status: -1 });
						}
					}
				}

				this.listPost = JSON.parse(JSON.stringify(this.listPost));
			},
			findIdeadById(array, id) {
				return array.find(x => x.id === id);
			},
			async handleActionReact(id, status, index) {
				const DATA = {
					idea_id: id,
					type: status
				};

				try {
					const res = await reactIdea(DATA);

					this.handleUpdateListPost(
						res['message'],
						index,
						res['total_like'],
						res['total_dislike']
					);
				} catch (error) {
					console.log(error);
				}
			},
			async handleGetListIdeas() {
				this.isLoading = true;
				const params = {
					category_id: this.id,
					page: this.pagination.page,
					per_page: this.pagination.per_page
				};
				try {
					const res = await getListIdeas(params);
					this.isLoading = false;
					this.listPost = res.data;
					this.pagination.page = res.current_page;
					this.pagination.total = res.total;
				} catch (error) {
					console.log(error);
				}
			},
			async handlePostIdea() {
				let files = document.getElementById('upload-ideas').files;
				let formData = new FormData();
				formData.append('category_id', this.id);
				formData.append('contents', this.data.contents);
				for (var i = 0; i < files.length; i++) {
					formData.append(`files[${i + 1}]`, files[i]);
				}
				try {
					if (isEmptyOrWhiteSpace(this.data.contents)) {
						MakeToast({
							variant: 'warning',
							title: 'Contents',
							content: 'You do not empty this fields'
						});
					} else {
						if (this.liences) {
							const res = await postIdeas(formData);
							if (res.status == 200) {
								this.handleGetListIdeas();
								this.isShowModalPost = false;
							}
						} else {
							MakeToast({
								variant: 'warning',
								title: 'Liences',
								content: 'You must be accept the liences'
							});
						}
					}
				} catch (error) {
					console.log(error);
				}
			},
			resetData() {
				this.data.contents = '';
			}
		}
	};
</script>

<style lang="scss" scoped>
	@import '@/scss/_variables';

	#detail-ideas footer#modal-footer {
		display: none !important;
	}

	.post-content {
		padding: 10px 0 10px 0;
	}

	.btn-react {
		text-align: center;
		vertical-align: middle;
		padding: 10px 0 10px 0;
		cursor: pointer;

		i {
			margin-right: 10px;
		}

		&:hover {
			background-color: $astronaut;
			color: $white;
			border-radius: 0.5rem;
		}
	}

	.btn-react-active {
		background-color: $astronaut;
		color: $white;
		border-radius: 0.5rem;
	}
</style>
