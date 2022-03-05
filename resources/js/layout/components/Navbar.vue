<template>
	<b-navbar toggleable="lg" type="dark" variant="info">
		<b-navbar-brand href="#">Collect Ideas System</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav> </b-navbar-nav>

			<b-navbar-nav class="ml-auto">
				<b-nav-item-dropdown right>
					<template #button-content>
						<em>User</em>
					</template>
					<b-dropdown-item href="#">Sign Out</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>

<script>
	export default {
		name: 'Navbar'
	};
</script>
