<template>
	<div class="ideas">
		<div class="ideas__header">
			<div class="ideas__header-title">
				<h4>{{ $t('IDEAS.TITLE') }}</h4>
			</div>
			<div class="ideas__header-actions">
				<button class="btn btn-primary" @click="handleModal()" v-b-modal.modal-1>{{
					$t('IDEAS.CREATE_IDEAS')
				}}</button>
			</div>
		</div>
	</div>
</template>

<script>
	export default {};
</script>

<style></style>
