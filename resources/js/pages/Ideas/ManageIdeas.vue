<template>
	<div class="manage-ideas">
		<div v-if="isLoading" class="loading">
			<i class="spinner-border" />
		</div>
		<div class="manage-ideas__content row align-items-center justify-content-center">
			<div class="manage-ideas__content-post col-12 col-sm-12 col-md-10 col-lg-10 col-xl-6">
				<div class="card">
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
								<b-col style="border: 1px solid #">
									<b>
										{{ idea.likes_count }}
										<i class="fas fa-thumbs-up" style="color: #0571ed"></i>
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

		<b-row>
			<b-col>
				<div style="margin-top: 30px; text-align: center">
					<b-pagination
						v-model="pagination.page"
						:total-rows="pagination.total"
						:per-page="pagination.per_page"
						align="center"
					/>
				</div>
			</b-col>
		</b-row>

		<b-modal v-model="isShowModalPost" id="modal-ideas" title="Your Ideas" size="lg">
			<div class="row mt-2">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<label for="">Content</label>
					<b-form-textarea v-model="data.contents" rows="8" />
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-3">
					<label for="">Upload your Ideas</label>

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
						I accept the terms and use. <b-link v-b-modal.modal-liences>Liencse</b-link>
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
								v-for="(item, index) in modalData['comments']"
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
						This Software Development Agreement (the “Agreement” or “Software
						Development Agreement”) states the terms and conditions that govern the
						contractual agreement between having his principal place of business at 200
						Clock Tower Pl Carmel, California(CA), 93923, (the “Developer”), and having
						its principal place of business at 200 Gainsborough Cir Folsom,
						California(CA), 95630 (the “Client”) who agrees to be bound by this
						Agreement. WHEREAS, the Client has conceptualized [QUICK DESCRIPTION OF
						SOFTWARE] (the “Software”), which is described in further detail on Exhibit
						A, and the Developer is a contractor with whom the Client has come to an
						agreement to develop the Software. NOW, THEREFORE, In consideration of the
						mutual covenants and promises made by the parties to this Software
						Development Agreement, the Developer and the Client (individually, each a
						“Party” and collectively, the “Parties”) covenant and agree as follows:
					</p>
				</b-col>

				<b-col cols="12">
					<h5>1. Developer's duties</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Client hereby engages the Developer and the Developer hereby agrees to
						be engaged by the Client to develop the Software in accordance with the
						specifications attached hereto as Exhibit A (the “Specifications”).
					</p>

					<ol>
						<li>
							<p>
								The Developer shall complete the development of the Software
								according to the milestones described on the form attached hereto as
								Exhibit B. In accordance with such milestones, the final product
								shall be delivered to the Client by May 12 (the “Delivery Date”)..
							</p>
						</li>

						<li>
							<p>
								For a period of 20 days after delivery of the final product, the
								Developer shall provide the Client attention to answer any questions
								or assist solving any problems with regard to the operation of the
								Software up to 90 of hours free of charge and billed to the Client
								at a rate of $40 per hour for any assistance thereafter. The
								Developer agrees to respond to any reasonable request for assistance
								made by the Client regarding the Software within 30 days of the
								request.
							</p>
						</li>

						<li>
							<p>
								Except as expressly provided in this Software Development Agreement,
								the Client shall not be obligated under this Agreement to provide
								any other support or assistance to the Developer.
							</p>
						</li>

						<li>
							<p>
								The Client may terminate this Software Development Agreement at any
								time upon material breach of the terms herein and failure to cure
								such a breach within 20 days of notification of such a breach.
							</p>
						</li>

						<li>
							<p>
								The Developer shall provide to the Client after the Delivery Date, a
								cumulative 2 days of training with respect to the operation of the
								Soft
							</p>
						</li>
					</ol>
				</b-col>

				<b-col cols="12">
					<h5>2. Delivery</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Software shall function in accordance with the Specifications on or
						before the Delivery Date.
					</p>

					<ol>
						<li>
							<p>
								If the Software as delivered does not conform with the
								Specifications, the Client shall within 30 days of the Delivery Date
								notify the Developer in writing of the ways in which it does not
								conform with the Specifications. The Developer agrees that upon
								receiving such notice, it shall make reasonable efforts to correct
								any non-conformity.
							</p>
						</li>

						<li>
							<p>
								The Client shall provide to the Developer written notice of its
								finding that the Software conforms to the Specifications within 20
								days of the Delivery Date (the “Acceptance Date”) unless it finds
								that the Software does not conform to the Specifications as
								described in Section 2(A) herein.
							</p>
						</li>
					</ol>
				</b-col>

				<b-col cols="12">
					<h5>3. Compensation</h5>
				</b-col>

				<b-col cols="12">
					<p>
						Compensation. In consideration for the Service, the Client shall pay the
						Company at the rate of $20 per hour (the “Hourly Rate”), with a maximum
						total fee for all work under this Software Development Agreement of $50.000.
						Fees billed under the Hourly Rate shall be due and payable upon the
						Developer providing the Client with an invoice. Invoices will be provided
						for work completed by the developer once every 30 days.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>4. Intellectual property rights in the software</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Parties acknowledge and agree that the Client will hold all intellectual
						property rights in the Software including, but not limited to, copyright and
						trademark rights. The Developer agrees not to claim any such ownership in
						the Software’s intellectual property at any time prior to or after the
						completion and delivery of the Software to the Client.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>5. Change in specifications</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Client may request that reasonable changes be made to the Specifications
						and tasks associated with the implementation of the Specifications. If the
						Client requests such a change, the Developer will use its best efforts to
						implement the requested change at no additional expense to the Client and
						without delaying delivery of the Software. In the event that the proposed
						change will, in the sole discretion of the Developer, require a delay in the
						delivery of the Software or would result in additional expense to the
						Client, then the Client and the Developer shall confer and the Client may
						either withdraw the proposed change or require the Developer to deliver the
						Software with the proposed change and subject to the delay and/or additional
						expense. The Client agrees and acknowledges that the judgment as to if there
						will be any delay or additional expense shall be made solely by the
						Developer.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>6. Confidentiality</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Developer shall not disclose to any third party the business of the
						Client, details regarding the Software, including, without limitation any
						information regarding the Software's code, the Specifications, or the
						Client's business (the “Confidential Information”), (ii) make copies of any
						Confidential Information or any content based on the concepts contained
						within the Confidential Information for personal use or for distribution
						unless requested to do so by the Client, or (iii) use Confidential
						Information other than solely for the benefit of the Client.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>7. Developer warranties</h5>
				</b-col>

				<b-col cols="12">
					<p> The Developer represents and warrants to the Client the following: </p>

					<ol>
						<li>
							<p>
								violation of any other agreement that the Developer has with another
								party.
							</p>
						</li>

						<li>
							<p>
								The Software will not violate the intellectual property rights of
								any other party.
							</p>
						</li>

						<li>
							<p>
								For a period of 10 days after the Delivery Date, the Software shall
								operate according to the Specifications. If the Software
								malfunctions or in any way does not operate according to the
								Specifications within that time, then the Developer shall take any
								reasonably necessary steps to fix the issue and ensure the Software
								operates according to the Specifications.
							</p>
						</li>
					</ol>
				</b-col>

				<b-col cols="12">
					<h5>8. Indemnification</h5>
				</b-col>

				<b-col cols="12">
					<p>
						The Developer agrees to indemnify, defend, and protect the Client from and
						against all lawsuits and costs of every kind pertaining to the software
						including reasonable legal fees due to the Developer’s infringement of the
						intellectual rights of any third party.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>9. No modification unless in writing</h5>
				</b-col>

				<b-col cols="12">
					<p>
						No modification of this Agreement shall be valid unless in writing and
						agreed upon by both Parties.
					</p>
				</b-col>

				<b-col cols="12">
					<h5>10. Applicable law</h5>
				</b-col>

				<b-col cols="12">
					<p>
						This Software Development Agreement and the interpretation of its terms
						shall be governed by and construed in accordance with the laws of the State
						of California and subject to the exclusive jurisdiction of the federal and
						state courts located in Alpine, California.
					</p>
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
				isPostComment: false
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
			}
		},
		watch: {
			language() {
				this.setLocalMoment();
			},
			pageChange() {
				this.handleGetListIdeas();
			}
		},
		created() {
			this.setLocalMoment();
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

					// console.log(res);
				} catch (error) {
					console.log(error);
				}

				this.comment = '';
			},
			handleStatusReact(likes) {
				if (likes.length > 0) {
					if (likes[0].status === 0) return 0;
					if (likes[0].status === 1) return 1;
				}

				return -1;
			},
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
					MakeToast({
						variant: 'success',
						title: this.$t('IDEA.TITLE_NEW_IDEA'),
						content: this.$t('IDEA.MESSAGE_NEW_IDEA')
					});
					this.listPost.push(data.payload);
					this.handleGetListIdeas();
					console.log(this.listPost, 'POST');
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
				this.connectComment(id);
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

					console.log(newComment);

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
				this.handleGetListIdeas();
			},
			handleUnlike(id, index) {
				this.handleActionReact(id, 0, index);
				this.handleGetListIdeas();
			},
			handleUpdateListPost(status, index) {
				const item = this.listPost[index].likes;

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
					this.handleUpdateListPost(res['message'], index);
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
