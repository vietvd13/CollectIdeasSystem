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
			<div class="col-md-2 col-lg-2 col-sm-12">
				<b-list-group>
					<b-list-group-item>Cras justo odio</b-list-group-item>
					<b-list-group-item active>Dapibus ac facilisis in</b-list-group-item>
					<b-list-group-item>Morbi leo risus</b-list-group-item>
					<b-list-group-item>Porta ac consectetur ac</b-list-group-item>
					<b-list-group-item>Vestibulum at eros</b-list-group-item>
				</b-list-group>
			</div>
			<div class="col-md-8 col-sm-12 col-lg-8 h-100 manage-ideas__content-list">
				<div class="card" v-for="(card, index) in listPost" :key="index">
					<div class="card-header d-flex align-items-center justify-content-between">
						<div class="user">
							<b-avatar href="#bar" src="https://placekitten.com/300/300"></b-avatar>
							<b>{{ card.user }}</b>
						</div>
						<div class="time">
							<span class="text-muted">2 hours ago</span>
						</div>
					</div>
					<div class="card-body">
						<p class="card-text">{{ card.ideas }}</p>
					</div>

					<div
						class="card-footer d-flex justify-content-between border-0 pb-0 bg-transparent"
					>
						<ul class="list-inline mb-0 mr-2">
							<li class="list-inline-item">
								<a href="#" class="text-pink">
									<i class="far fa-thumbs-up"></i>
									Thích
								</a>
							</li>
							<li class="list-inline-item">
								<a href="#" class="text-body">
									<i class="far fa-thumbs-down"></i>
									Không thích
								</a>
							</li>
						</ul>
					</div>

					<div class="card-footer">
						<div class="input-group">
							<span class="input-group-append">
								<b-avatar
									href="#bar"
									src="https://placekitten.com/300/300"
								></b-avatar>
							</span>
							<input
								type="text"
								class="form-control border-right-0"
								placeholder="Add comment..."
							/>

							<span class="input-group-append">
								<button class="btn btn-primary" type="button"
									><i class="fas fa-paper-plane"></i
								></button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-12 col-lg-2 mt-sm-2">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<div class="user">
							<b-avatar href="#bar" src="https://placekitten.com/300/300"></b-avatar>
							Le Dinh Thang
						</div>
						<div class="time">
							<span class="text-muted">1mins</span>
						</div>
					</div>
					<div class="card-body">
						<p class="card-text">
							Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint, ipsa
							beatae a dicta magnam dolore, consectetur sequi ipsum obcaecati
							adipisci, quos asperiores id culpa quibusdam nostrum delectus
							necessitatibus reprehenderit accusamus?
						</p>

						><p class="card-text">
							<a href="#" class="mr-1">#limitless</a>
							<a href="#" class="mr-1">#template</a>
							<a href="#" class="mr-1">#is</a>
							<a href="#" class="mr-1">#awesome</a>
						</p>
					</div>

					<div
						class="card-footer d-flex justify-content-between border-0 pb-0 bg-transparent"
					>
						<ul class="list-inline mb-0">
							<li class="list-inline-item">
								<a href="#" class="text-pink">
									<i class="far fa-thumbs-up"></i>
									Lượt Thích
								</a>
							</li>
							<li class="list-inline-item">
								<a href="#" class="text-body">
									<i class="far fa-thumbs-down"></i>
									Lượt Không thích
								</a>
							</li>
						</ul>
					</div>

					<div class="card-footer">
						<div class="input-group">
							<span class="input-group-append">
								<b-avatar
									href="#bar"
									src="https://placekitten.com/300/300"
								></b-avatar>
							</span>
							<input
								type="text"
								class="form-control border-right-0"
								placeholder="Add comment..."
							/>

							<span class="input-group-append">
								<button class="btn btn-primary" type="button"
									><i class="fas fa-paper-plane"></i
								></button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<b-modal id="modal-ideas" title=" Your Ideas">
			<div class="row mt-2">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<label for="">Content</label>
					<b-form-textarea></b-form-textarea>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
					<label for="">Category</label>
					<b-select>
						<b-select-option>CRUD SYSTEM</b-select-option>
						<b-select-option>CRUD SYSTEM</b-select-option>
						<b-select-option>CRUD SYSTEM</b-select-option>
						<b-select-option>CRUD SYSTEM</b-select-option>
					</b-select>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-12 mt-2">
					<label for="">Upload your Ideas</label>
					<b-form-file></b-form-file>
				</div>
			</div>
			<template #modal-footer>
				<div>
					<b-button class="btn btn-danger" @click="showModal = false">
						{{ $t('USER.FORM.CLOSE') }}
					</b-button>
					<b-button
						v-b-modal.modal-liences
						class="btn btn-primary"
					>
						Post
					</b-button>
				</div>
			</template>
		</b-modal>
		<b-modal id="modal-liences" title="Read the Liences">
			<p class="my-4">
				Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque veritatis, aliquam
				exercitationem quibusdam quidem quae maxime ipsa alias, ullam inventore tempore
				obcaecati odit quaerat voluptatem ut culpa officiis iusto quisquam.
			</p>
			<b-form-checkbox
				id="checkbox-1"
				v-model="status"
				name="checkbox-1"
				value="accepted"
				unchecked-value="not_accepted"
			>
				I accept the terms and use
			</b-form-checkbox>
			<template #modal-footer>
				<div>
					<b-button class="btn btn-danger" @click="showModal = false">
						{{ $t('USER.FORM.CLOSE') }}
					</b-button>
					<b-button bv class="btn btn-primary"> Đồng ý </b-button>
				</div>
			</template>
		</b-modal>
	</div>
</template>

<script>
	export default {
		name: 'Ideas',
		data() {
			return {
				modal: false,
				selected: null,
				listPost: [
					{
						user: 'HieuNH',
						ideas: `While satire and parody play on humorous attacks, this first level of “fake news” does not require immediate attention due to its widely acknowledged entertainment value. However, this next level of fake news, fabrication, requires a different response due to its lack of facticity and intent to deceive.

This type of information has no factual basis; however, the stories are presented or “published in the style of news articles to create legitimacy,” and often are believed to be a trustworthy source because partisan organizations often present information with some neutrality (Tandoc, Lim & Ling, 2018, p. 143).

According to the scholars, Tandoc, Lim and Ling (2018) research acknowledges that this type of information is often spread for the purpose of financial gain or now, more frequently, by artificial intelligence online sources.`,
						url_image: ''
					},
					{
						user: 'Le Win ',
						ideas: `While satire and parody play on humorous attacks, this first level of “fake news” does not require immediate attention due to its widely acknowledged entertainment value. However, this next level of fake news, fabrication, requires a different response due to its lack of facticity and intent to deceive.

This type of information has no factual basis; however, the stories are presented or “published in the style of news articles to create legitimacy,” and often are believed to be a trustworthy source because partisan organizations often present information with some neutrality (Tandoc, Lim & Ling, 2018, p. 143).

According to the scholars, Tandoc, Lim and Ling (2018) research acknowledges that this type of information is often spread for the purpose of financial gain or now, more frequently, by artificial intelligence online sources.`,
						url_image: ''
					},
					{
						user: 'Vu Duck',
						ideas: `While satire and parody play on humorous attacks, this first level of “fake news” does not require immediate attention due to its widely acknowledged entertainment value. However, this next level of fake news, fabrication, requires a different response due to its lack of facticity and intent to deceive.

This type of information has no factual basis; however, the stories are presented or “published in the style of news articles to create legitimacy,” and often are believed to be a trustworthy source because partisan organizations often present information with some neutrality (Tandoc, Lim & Ling, 2018, p. 143).

According to the scholars, Tandoc, Lim and Ling (2018) research acknowledges that this type of information is often spread for the purpose of financial gain or now, more frequently, by artificial intelligence online sources.`,
						url_image: ''
					},
					{
						user: 'NamNT',
						ideas: `While satire and parody play on humorous attacks, this first level of “fake news” does not require immediate attention due to its widely acknowledged entertainment value. However, this next level of fake news, fabrication, requires a different response due to its lack of facticity and intent to deceive.

This type of information has no factual basis; however, the stories are presented or “published in the style of news articles to create legitimacy,” and often are believed to be a trustworthy source because partisan organizations often present information with some neutrality (Tandoc, Lim & Ling, 2018, p. 143).

According to the scholars, Tandoc, Lim and Ling (2018) research acknowledges that this type of information is often spread for the purpose of financial gain or now, more frequently, by artificial intelligence online sources.`,
						url_image: ''
					},
					{
						user: 'AbuBarkar',
						ideas: `While satire and parody play on humorous attacks, this first level of “fake news” does not require immediate attention due to its widely acknowledged entertainment value. However, this next level of fake news, fabrication, requires a different response due to its lack of facticity and intent to deceive.

This type of information has no factual basis; however, the stories are presented or “published in the style of news articles to create legitimacy,” and often are believed to be a trustworthy source because partisan organizations often present information with some neutrality (Tandoc, Lim & Ling, 2018, p. 143).

According to the scholars, Tandoc, Lim and Ling (2018) research acknowledges that this type of information is often spread for the purpose of financial gain or now, more frequently, by artificial intelligence online sources.`,
						url_image: ''
					}
				]
			};
		}
	};
</script>

<style></style>
