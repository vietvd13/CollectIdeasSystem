<template>
	<div class="page-login">
		<b-container>
			<div class="login-form col-xl-6 col-lg-6 mx-auto">
				<div class="login-form-content">
					<b-row>
						<b-col>
							<div class="login-form-content__logo">
								<b-img center :src="Logo" alt="Logo"></b-img>
							</div>

							<!-- Title -->
							<div class="login-form-content__header">
								<h1>{{ $t('LOGIN.TITLE') }}</h1>
							</div>

							<!-- Account -->
							<div class="login-form-content__body">
								<div class="item-input">
									<b-form-input
										v-model="User.account"
										type="text"
										:placeholder="$t('LOGIN.PLACEHOLDER_ACCOUNT')"
										spellcheck="false"
										autofocus
										@keyup.enter="doLogin()"
										:disabled="isProcess"
									/>
								</div>

								<div class="item-input">
									<b-input-group>
										<b-form-input
											v-model="User.password"
											:type="showPassword ? 'text' : 'password'"
											:placeholder="$t('LOGIN.PLACEHOLDER_PASSWORD')"
											spellcheck="false"
											name="password"
											autocomplete="off"
											@keyup.enter="doLogin()"
											:disabled="isProcess"
										/>
										<b-input-group-append is-text v-if="User.password">
											<i
												:disabled="isProcess"
												@click="showPassword = !showPassword"
												:class="handleShowPassword()"
											></i>
										</b-input-group-append>
									</b-input-group>
								</div>
							</div>

							<div class="login-form-content__footer">
								<b-row>
									<b-col>
										<b-button @click="doLogin()" :disabled="isProcess">
											<i
												v-if="isProcess"
												class="fad fa-spinner-third fa-spin"
											></i>
											{{ $t('LOGIN.BUTTON_LOGIN') }}
										</b-button>
									</b-col>
								</b-row>
							</div>
						</b-col>
					</b-row>
				</div>
			</div>
		</b-container>
	</div>
</template>

<script>
	import Logo from '@/assets/images/student.png';

	export default {
		name: 'Login',
		data() {
			return {
				Logo,
				User: {
					account: '',
					password: ''
				},
				showPassword: false,
				isProcess: false
			};
		},
		methods: {
			doLogin() {
				this.isProcess = true;

				const Account = {
					account: this.User.account || '',
					password: this.User.password || ''
				};

				console.log(Account);
			},

			handleShowPassword() {
				if (this.isProcess) {
					this.showPassword = false;
				}

				if (this.showPassword) {
					return 'fas fa-eye-slash';
				}

				return 'fas fa-eye';
			}
		}
	};
</script>

<style lang="scss" scoped>
	@import '@/scss/_variables';
	@import '@/scss/modules/_login';
</style>
