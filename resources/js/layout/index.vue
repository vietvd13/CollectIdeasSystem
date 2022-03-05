<template>
	<div>
		<Navbar />
		<AppMain />
	</div>
</template>

<script>
	import Navbar from './components/Navbar';
	import AppMain from './components/AppMain';

	export default {
		name: 'Layout',
		components: {
			Navbar,
			AppMain
		}
	};
</script>
