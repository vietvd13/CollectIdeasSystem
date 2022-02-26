<template>
	<div id="app">
		<router-view />
	</div>
</template>

<script>
	export default {
		name: 'App',
		created() {
			console.log(
				'%cStudy App',
				'font-size: 20px; padding: 5px 10px 5px 10px; border-radius: .25rem; color: #55AEEE; background-color: #0F0049; text-align: center;'
			);
		}
	};
</script>
