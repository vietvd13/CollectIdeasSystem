<template>
	<div class="manage-ideas">
		<div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
		<div class="manage-ideas__content row align-items-center justify-content-center">
			<div class="manage-ideas__content-post col-md-6">
				<div class="card">
					<div class="card-body area-post">
						<b-avatar
							variant="info"
							src="https://placekitten.com/300/300"
							class="mr-3"
						></b-avatar>
						<b-input
							readonly
							placeholder="What is your ideas ?"
							v-b-modal.modal-ideas
						></b-input>
					</div>
				</div>
				<div v-for="(idea, index) in listPost" :key="index" class="area-content card">
					<div class="card-body">
						<div class="area-content__header">
							<div class="area-content__header-avatar">
								<b-avatar
									variant="info"
									src="https://placekitten.com/300/300"
									class="mr-3"
								></b-avatar>
							</div>
							<div class="area-content__header-text">
								<div class="q-box">
									<span class="q-box"><b>Hồng Nhung</b></span>
								</div>
								<div class="q-box">
									<span><small>1mins</small></span>
								</div>
							</div>
						</div>
						<div class="area-content__post">
							<div class="post-category">
								<h4></h4>
							</div>
							<div class="post-content">
								<p>{{ idea.contents }}</p>
								<div class="attachment">
									<b>Attachment</b>
									<a href=""> <i class="fas fa-download"></i> File Name</a>
									<a href=""> <i class="fas fa-download"></i> File Name</a>
								</div>
							</div>
						</div>
						<div class="area-content__footer mt-2">
							<div class="footer-actions mt-2">
								<button class="btn" @click="handleLike(idea.id)"
									><i :id="'like-' + idea.id" class="fas fa-thumbs-up"></i
									>{{ count }} Thích</button
								>
								<button class="btn" @click="handleUnlike()"
									><i id="unlike" class="fas fa-thumbs-down"></i> Không
									Thích</button
								>
								<button @click="showModal(true)" class="btn"
									><i class="far fa-comment"></i> Comment</button
								>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<b-modal v-model="isShowModalPost" id="modal-ideas" title=" Your Ideas">
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
		<b-modal v-model="isShowModal" id="detail-ideas" size="xl" scrollable>
			<div class="row detail-ideas">
				<div class="col-md-6 col-lg-6 col-sm-12 detail-ideas__content">
					<p class="text-justify">
						Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad unde
						accusantium consectetur ipsum, et aliquid eveniet labore fugiat velit
						veritatis facilis atque error harum? Eaque, est accusamus! Eius, autem
						consectetur. Lorem ipsum dolor sit, amet consectetur adipisicing elit.
						Nesciunt, quam magni consectetur earum consequuntur similique aperiam
						aliquam eveniet explicabo nam natus nemo a nisi aut? Vero tenetur eaque
						suscipit quia. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad
						unde accusantium consectetur ipsum, et aliquid eveniet labore fugiat velit
						veritatis facilis atque error harum? Eaque, est accusamus! Eius, autem
						consectetur. Lorem ipsum dolor sit, amet consectetur adipisicing elit.
						Nesciunt, quam magni consectetur earum consequuntur similique aperiam
						aliquam eveniet explicabo nam natus nemo a nisi aut? Vero tenetur eaque
						suscipit quia. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad
						unde accusantium consectetur ipsum, et aliquid eveniet labore fugiat velit
						veritatis facilis atque error harum? Eaque, est accusamus! Eius, autem
						consectetur. Lorem ipsum dolor sit, amet consectetur adipisicing elit.
						Nesciunt, quam magni consectetur earum consequuntur similique aperiam
						aliquam eveniet explicabo nam natus nemo a nisi aut? Vero tenetur eaque
						suscipit quia.
					</p>
					<div class="attachment">
						<a href="">Link 1</a>
						<a href="">Link 2</a>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-sm-12 detail-ideas__comment">
					<header class="d-flex align-items-center">
						<div class="user-avatar">
							<b-avatar
								variant="info"
								src="https://placekitten.com/300/300"
								class="mr-3"
							></b-avatar>
						</div>
						<div class="user-infor">
							<b>dailywbdesign</b>
						</div>
					</header>
					<div class="list-comment">
						<div class="list">
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
										</span></div
									>
								</div>
							</div>
							<div class="section-comment">
								<div
									class="user-avatar d-flex w-100 align-items-center justify-content-between"
								>
									<div class="d-flex align-items-center">
										<b-avatar
											variant="info"
											src="https://placekitten.com/300/300"
											class="mr-3"
										>
										</b-avatar>
										<b>Le Win</b>
									</div>
									<i class="fas fa-ellipsis-h float-right"></i>
								</div>
								<div class="user-comment">
									<div
										><span>
											Lorem ipsum dolor sit amet consectetur adipisicing elit.
											Omnis totam ipsam odit, dolor neque dolorum repellat
											non, distinctio dicta assumenda blanditiis nesciunt enim
											sunt, excepturi necessitatibus ipsum doloribus molestias
											ab.
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
			<template #modal-header>
				<h3>Whose behavior shocked you today?</h3>
			</template>
		</b-modal>
	</div>
</template>

<script>
	import LazyLoad from '../../layout/Lazyload.vue';
	import { getOneUser } from '@/api/modules/user';
	import { postIdeas, getListIdeas } from '@/api/modules/idea';
	import { MakeToast } from '@/toast/toastMessage';

	export default {
		name: 'Ideas',
		components: {
			LazyLoad
		},
		data() {
			return {
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
				user: ''
			};
		},
		created() {
			this.connect();
			this.handleGetListIdeas();
		},
		methods: {
			connect() {
				window.Echo.channel('collect_idea').listen('idea-post', data => {
					console.log(data);
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				});
			},
			showModal(e) {
				this.isShowModal = e;
			},
			showModalCreate(e) {
				this.resetData();
				this.isShowModalPost = e;
			},
			handleLike(id) {
				if (this.isLike) {
					this.isLike = false;
					this.count -= 1;
					document.getElementById(`like-${id}`).style.color = '#333';
				} else {
					this.isLike = true;
					document.getElementById(`like-${id}`).style.color = 'green';
					this.count += 1;
				}
			},
			handleUnlike() {},

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
						MakeToast({
							variant: 'success',
							title: 'Success',
							content: this.$t('USER.FORM.MESSAGE.SPACE')
						});
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

<style scoped>
	#detail-ideas footer#modal-footer {
		display: none !important;
	}
</style>
