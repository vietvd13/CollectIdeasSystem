<template>
	<b-navbar toggleable="lg" type="dark" variant="info">
		<b-navbar-brand href="#">Collect Ideas System</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item v-for="(item, index) in routes" :key="`router-${index}`">
					<router-link :to="item['path']">
						{{ item['meta']['title'] }}
					</router-link>
				</b-nav-item>
			</b-navbar-nav>

			<b-navbar-nav class="ml-auto">
				<b-nav-item-dropdown right>
					<template #button-content>
						{{ name }}
					</template>
					<b-dropdown-item href="#">Sign Out</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>

<script>
	export default {
		name: 'Navbar',
		computed: {
			routes() {
				return this.$store.getters.permissionRoutes.filter(item => item.hidden !== true);
			},
			name() {
				return this.$store.getters.name;
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
