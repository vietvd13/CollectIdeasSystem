<template>
	<div class="manage-ideas">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="manage-ideas__content row align-items-center justify-content-center">
			<div class="manage-ideas__content-post col-12 col-sm-12 col-md-10 col-lg-10 col-xl-6">
				<div class="card">
					<div class="card-body area-post">
						<b-avatar
							variant="info"
							src="https://placekitten.com/300/300"
							class="mr-3"
						></b-avatar>
						<b-input
							readonly
							:placeholder="$t('IDEA.PLACEHOLDER_INPUT_IDEAD', { name: fullname })"
							v-b-modal.modal-ideas
						></b-input>
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
								<div class="q-box" :key="rerender">
									<span>
										<small>
											{{
												moment(idea['created_at']).startOf('hour').fromNow()
											}}
										</small>
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
								<b-col cols="6" sm="6" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div class="btn-react" @click="handleLike(idea.id)">
											<i class="far fa-thumbs-up" />
											<span>{{ $t('IDEA.BUTTON_LIKE') }}</span>
										</div>
									</div>
								</b-col>
								<b-col cols="6" sm="6" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div class="btn-react" @click="handleUnlike(idea.id)">
											<i class="far fa-thumbs-down" />
											<span>{{ $t('IDEA.BUTTON_UNLIKE') }}</span>
										</div>
									</div>
								</b-col>
								<b-col cols="12" sm="12" md="4" lg="4" xl="4">
									<div class="d-flex flex-column justify-content-center">
										<div @click="showModal(true, idea.id)" class="btn-react">
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

		<b-modal v-model="isShowModalPost" id="modal-ideas" title="Your Ideas">
			<div class="row mt-2">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<label for="">Content</label>
					<b-form-textarea v-model="data.contents"></b-form-textarea>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
					<label for="">Upload your Ideas</label>

					<b-form-file
						multiple="multiple"
						ref="file"
						accept=".pdf,image/*"
						id="upload-ideas"
					></b-form-file>
				</div>
			</div>

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

		<b-modal v-model="isShowModal" id="detail-ideas" size="xl" scrollable hide-header centered>
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
							></b-avatar>
						</div>
						<div class="user-infor">
							<b>{{ modalData['user']['name'] }}</b>
						</div>
					</header>
					<div class="list-comment">
						<div class="list">
							<div
								class="section-comment"
								v-for="(item, index) in modalData['comments']"
								:key="`comment-no-${index + 1}`"
							>
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>{{ item['owner'] }}</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											{{ item['comment'] }}
										</span></div
									>
								</div>
							</div>
						</div>
					</div>
					<div class="write-comment">
						<b-input-group>
							<b-form-input
								type="text"
								placeholder="Add your comment....."
							></b-form-input>
							<b-input-group-append is-text>
								<i class="fal fa-paper-plane"></i>
							</b-input-group-append>
						</b-input-group>
					</div>
				</div>
			</div>
		</b-modal>
	</div>
</template>

<script>
	import LazyLoad from '../../layout/Lazyload.vue';
	import { postIdeas, getListIdeas, reactIdea } from '@/api/modules/idea';
	import { MakeToast } from '@/toast/toastMessage';
	import moment from 'moment';

	export default {
		name: 'Ideas',
		components: {
			LazyLoad
		},
		data() {
			return {
				moment,
				rerender: 1,
				isShowModal: false,
				isShowModalPost: false,
				selected: null,
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
				}
			};
		},
		computed: {
			language() {
				return this.$store.getters.language;
			},
			fullname() {
				return this.$store.getters.name;
			}
		},
		watch: {
			language() {
				this.setLocalMoment();
			}
		},
		created() {
			this.setLocalMoment();
			this.connect();
			this.handleGetListIdeas();
		},
		methods: {
			setLocalMoment() {
				const LANGUAGE = this.$store.getters.language;

				if (LANGUAGE === 'en') {
					moment.locale('en');
				}
				if (LANGUAGE === 'vn') {
					moment.locale('vi');
				}

				this.rerender += 1;
			},
			connect() {
				window.Echo.channel('collect_idea').listen('.idea-post', data => {
					console.log(data);
					MakeToast({
						variant: 'success',
						title: this.$t('IDEA.TITLE_NEW_IDEA'),
						content: this.$t('IDEA.MESSAGE_NEW_IDEA')
					});
				});
			},
			showModal(e, id) {
				this.modalData = this.findIdeadById(this.listPost, id);
				this.isShowModal = e;
			},
			showModalCreate(e) {
				this.resetData();
				this.isShowModalPost = e;
			},
			handleLike(id) {
				console.log(id);
				this.handleActionReact(id, 1);
			},
			handleUnlike(id) {
				console.log(id);
				this.handleActionReact(id, 0);
			},
			findIdeadById(array, id) {
				return array.find(x => x.id === id);
			},
			async handleActionReact(id, status) {
				const DATA = {
					idea_id: id,
					type: status
				};

				try {
					const res = await reactIdea(DATA);
					console.log(res);
				} catch (error) {
					console.log(error);
				}
			},
			async handleGetListIdeas() {
				this.isLoading = true;
				const params = {
					category_id: this.id
				};
				try {
					const res = await getListIdeas(params);

					this.isLoading = false;
					this.listPost = res.data;
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
					const res = await postIdeas(formData);
					if (res.status == 200) {
						this.handleGetListIdeas();
						this.isShowModalPost = false;
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
</style>
