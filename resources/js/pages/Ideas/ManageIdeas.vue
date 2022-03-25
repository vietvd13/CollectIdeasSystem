<template>
	<div class="manage-ideas">
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
							@click="
								getListCategory();
								showModal(true);
							"
						></b-input>
					</div>
				</div>
				<div class="area-content card">
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
								<h3>Whose behavior shocked you today?</h3>
							</div>
							<div class="post-content">
								<p
									>A nurse was filmed helping a homeless woman deliver her baby on
									a street in Makati, Philippines.</p
								>
								<div class="attachment">
									<b>Attachment</b>
									<a href="">Link 1</a>
									<a href="">Link 2</a>
								</div>
							</div>
						</div>
						<div class="area-content__footer mt-2">
							<div class="footer-overview">
								<small>100.1K Comment</small>
							</div>
							<div class="footer-actions mt-2">
								<button class="btn"><i class="fas fa-thumbs-up"></i> Thích</button>
								<button class="btn"
									><i class="fas fa-thumbs-down"></i> Không Thích</button
								>
							</div>
						</div>
					</div>
					<div class="card-footer comment">
						<b-avatar
							variant="info"
							src="https://placekitten.com/300/300"
							class="mr-3"
						></b-avatar>
						<b-input v-b-modal.detail-ideas placeholder="Add a comment....."></b-input>
						<button class="btn btn-primary ml-3 w-25">Add Comment</button>
					</div>
				</div>
			</div>
		</div>

		<b-modal id="modal-ideas" title=" Your Ideas">
			<div class="row mt-2">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<label for="">Content</label>
					<b-form-textarea v-model="data.contents"></b-form-textarea>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
					<label for="">Category</label>
					<b-select v-model="data.category_id">
						<b-form-select-option :value="null">
							Select the category
						</b-form-select-option>
						<b-select-option
							v-for="(category, index) in listCategory"
							:key="index"
							:value="category.id"
						>
							{{ category.topic_name }}
						</b-select-option>
					</b-select>
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
					<b-button class="btn btn-danger" @click="showModal(false)">
						{{ $t('USER.FORM.CLOSE') }}
					</b-button>
					<b-button type="submit" class="btn btn-primary" @click="handlePostIdea()">
						Post
					</b-button>
				</div>
			</template>
		</b-modal>
		<b-modal id="detail-ideas" size="xl" scrollable>
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
										Omnis totam ipsam odit, dolor neque dolorum repellat non,
										distinctio dicta assumenda blanditiis nesciunt enim sunt,
										excepturi necessitatibus ipsum doloribus molestias ab.
									</span></div
								>
							</div>
						</div>
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
	import Pusher from 'pusher-js'; // import Pusher
	import LazyLoad from '../../layout/Lazyload.vue';
	import { getCategoryTable } from '@/api/modules/category';
	import { postIdeas } from '@/api/modules/idea';
	import { MakeToast } from '@/toast/toastMessage';

	export default {
		name: 'Ideas',
		components: {
			LazyLoad
		},
		data() {
			return {
				showModal: false,
				selected: null,
				listCategory: [],
				data: {
					category_id: null,
					contents: '',
					files: []
				},
				listPost: []
			};
		},
		created() {
			this.connect();
		},
		methods: {
			connect() {
				window.Echo.channel('collect_idea').listen('idea-post', data => {
					MakeToast({
						variant: 'warning',
						title: 'Warning',
						content: this.$t('USER.FORM.MESSAGE.SPACE')
					});
				});
			},
			showModal(modal) {
				this.showModal = modal ? true : false;
			},
			async getListCategory() {
				try {
					const res = await getCategoryTable();
					this.listCategory = res.data.data;
				} catch (error) {
					console.log(error);
				}
			},
			async handlePostIdea() {
				let files = document.getElementById('upload-ideas').files;
				let formData = new FormData();
				formData.append('category_id', this.data.category_id);
				formData.append('contents', this.data.contents);
				console.log(this.data.category_id);
				for (var i = 0; i < files.length; i++) {
					formData.append(`files[${i + 1}]`, files[i]);
				}
				try {
					const res = await postIdeas(formData);
					console.log(res);
				} catch (error) {
					console.log(error);
				}
			}
		}
	};
</script>

<style scoped>
	#detail-ideas footer#modal-footer {
		display: none !important;
	}
</style>
