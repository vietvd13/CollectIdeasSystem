<template>
	<div class="manage-ideas">
		<div class="manage-ideas__header row justify-content-lg-around">
			<div class="col-md-6 col-sm-6 col-lg-6"><h4> Discussion About The Ideas </h4></div>
			<div class="col-md-6 col-sm-6 col-lg-6">
				<button v-b-modal.modal-ideas class="btn btn-primary float-right"
					>Post Ideas</button
				>
			</div>
		</div>
		<div class="manage-ideas__searching">
			<div class="manage-ideas__searching-filter">
				<label for="filer">Category</label>
				<b-form-select v-model="selected">
					<b-form-select-option :value="null"> Select the category </b-form-select-option>
					<b-form-select-option> </b-form-select-option>
				</b-form-select>
			</div>

			<div class="manage-ideas__searching-keyword">
				<label for="keyword">User</label>
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
		<div class="manage-ideas__content row">
			<div class="col-md-12 col-lg-12 manage-ideas__content-post">
				<div class="area-post">
					<b-avatar variant="primary" text="BV"></b-avatar>
					<b-input placeholder="What is your ideas ?"></b-input>
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
					<label for="">Department</label>
					<b-select> </b-select>
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
					<b-button class="btn btn-danger" @click="modal = false">
						{{ $t('USER.FORM.CLOSE') }}
					</b-button>
					<b-button type="submit" class="btn btn-primary" @click="handlePostIdea()">
						Post
					</b-button>
				</div>
			</template>
		</b-modal>
		<LazyLoad @lazyload="getListCategory()" />
	</div>
</template>

<script>
	import Pusher from 'pusher-js'; // import Pusher
	import LazyLoad from '../../layout/Lazyload.vue';
	import { getCategoryTable } from '@/api/modules/category';
	import { postIdeas } from '@/api/modules/idea';
	export default {
		name: 'Ideas',
		components: {
			LazyLoad
		},
		data() {
			return {
				modal: false,
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

		methods: {
			async getListCategory() {
				try {
					const res = await getCategoryTable();
					this.listCategory = res.data.data;
					console.log(this.listCategory);
				} catch (error) {
					console.log(error);
				}
			},
			async handlePostIdea() {
				let files = document.getElementById('upload-ideas').files;
				let formData = new FormData();
				formData.append('catgory_id', this.data.catgory_id);
				formData.append('contents', this.data.contents);
				for (var i = 0; i < files.length; i++) {
					formData.append(`files[${i + 1}]`, files[i]);
				}
				try {
					const res = await postIdeas(formData);
					console.log(res);
					let pusher = new Pusher('50ef73b1d72e2466e314', {
						cluster: 'ap1'
					});

					let channel = pusher.subscribe('collect_idea');
					channel.bind('idea-post', data => {
						console.log(data);
					});
				} catch (error) {
					console.log(error);
				}
			}
		}
	};
</script>

<style></style>
