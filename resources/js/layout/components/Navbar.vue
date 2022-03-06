<template>
	<b-navbar toggleable="lg" type="dark" variant="info">
		<b-navbar-brand href="#">Collect Ideas System</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item v-for="(item, index) in routes" :key="`router-${index}`">
					<router-link :to="item['path']">
						{{ $t(item['meta']['title']) }}
					</router-link>
				</b-nav-item>
			</b-navbar-nav>

			<b-navbar-nav class="ml-auto">
				<b-nav-item-dropdown right>
					<template #button-content>
						{{ $t('NAVBAR.LANGUAGE') }}
					</template>
					<b-dropdown-item href="#" @click="setLanguage('en')">
						{{ $t('NAVBAR.ENGLISH') }}
					</b-dropdown-item>
					<b-dropdown-item href="#" @click="setLanguage('vn')">
						{{ $t('NAVBAR.VIETNAMESE') }}
					</b-dropdown-item>
				</b-nav-item-dropdown>

				<b-nav-item-dropdown right>
					<template #button-content>
						{{ name }}
					</template>
					<b-dropdown-item href="#" @click="doLogout()">{{
						$t('LOGOUT.TEXT_LOGOUT')
					}}</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>

<script>
	import { MakeToast } from '@/toast/toastMessage';
	export default {
		name: 'Navbar',
		computed: {
			routes() {
				return this.$store.getters.permissionRoutes.filter(item => item.hidden !== true);
			},
			name() {
				return this.$store.getters.name;
			}
		},
		methods: {
			setLanguage(lang) {
				this.$store
					.dispatch('app/setLanguage', lang)
					.then(() => {
						this.$i18n.locale = lang;

						MakeToast({
							variant: 'success',
							title: this.$t('TOAST.SUCCESS'),
							content: this.$t('I18N.CHANGE_LANGUAGE.SUCCESS')
						});
					})
					.catch(() => {
						MakeToast({
							variant: 'danger',
							title: this.$t('TOAST.DANGER'),
							content: this.$t('I18N.CHANGE_LANGUAGE.FAILED')
						});
					});
			},
			doLogout() {
				this.$store
					.dispatch('auth/doLogout')
					.then(() => {
						this.$router.push('/login');

						MakeToast({
							variant: 'success',
							title: this.$t('TOAST.SUCCESS'),
							content: this.$t('LOGOUT.LOGOUT_SUCCESS')
						});
					})
					.catch(() => {
						MakeToast({
							variant: 'danger',
							title: this.$t('TOAST.DANGER'),
							content: this.$t('LOGOUT.LOGOUT_ERROR')
						});
					});
			}
		}
	};
</script>

<style lang="scss" scoped>
	@import '@/scss/_variables';

	.navbar {
		box-shadow: 0px 4px 2px rgba(0, 0, 0, 0.25);

		a {
			color: $white !important;
			text-decoration: none;
		}

		a.nav-link {
			&:hover {
				color: $white !important;
				background-color: $astronaut !important;
			}
		}

		a.router-link-active {
			color: $robins-egg-blue !important;
		}
	}

	.bg-info {
		background-color: $astronaut !important;
	}
</style>
