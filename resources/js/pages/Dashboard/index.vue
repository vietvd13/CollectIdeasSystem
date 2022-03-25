<template>
	<div class="wapper">
		<div class="user-info">
			<b-row>
				<b-col cols="12" sm="12" md="12" lg="12" xl="12">
					<div class="wellcome"
						>{{ $t('DASHBOARD.HELLO') }},
						<span class="fullname">{{ fullname }}</span> &bull;
						<span class="role">{{ role }}</span></div
					>
				</b-col>
			</b-row>
		</div>

		<div class="user-idea-count">
			<b-row>
				<b-col cols="12" sm="12" md="6" lg="3" xl="3">
					<b-card>
						<b-row>
							<b-col cols="4" sm="4" md="4" lg="4" xl="4">
								<div class="icon-card">
									<i class="fas fa-lightbulb"></i>
								</div>
							</b-col>
							<b-col cols="8" sm="8" md="8" lg="8" xl="8">
								<div class="detail-card">
									<span class="detail-title">100</span>
								</div>
							</b-col>
						</b-row>
					</b-card>
				</b-col>

				<b-col cols="12" sm="12" md="6" lg="3" xl="3">
					<b-card>
						<b-row>
							<b-col cols="4" sm="4" md="4" lg="4" xl="4">
								<div class="icon-card">
									<i class="far fa-comment-lines"></i>
								</div>
							</b-col>
							<b-col cols="8" sm="8" md="8" lg="8" xl="8">
								<div class="detail-card">
									<span class="detail-title">100</span>
								</div>
							</b-col>
						</b-row>
					</b-card>
				</b-col>

				<b-col cols="12" sm="12" md="6" lg="3" xl="3">
					<b-card>
						<b-row>
							<b-col cols="4" sm="4" md="4" lg="4" xl="4">
								<div class="icon-card">
									<i class="fas fa-thumbs-up"></i>
								</div>
							</b-col>
							<b-col cols="8" sm="8" md="8" lg="8" xl="8">
								<div class="detail-card">
									<span class="detail-title">100</span>
								</div>
							</b-col>
						</b-row>
					</b-card>
				</b-col>

				<b-col cols="12" sm="12" md="6" lg="3" xl="3">
					<b-card>
						<b-row>
							<b-col cols="4" sm="4" md="4" lg="4" xl="4">
								<div class="icon-card">
									<i class="fas fa-thumbs-down"></i>
								</div>
							</b-col>
							<b-col cols="8" sm="8" md="8" lg="8" xl="8">
								<div class="detail-card">
									<span class="detail-title">100</span>
								</div>
							</b-col>
						</b-row>
					</b-card>
				</b-col>
			</b-row>
		</div>

		<div class="chart-list-categories"> </div>
	</div>
</template>

<script>
	import { getNameRole } from '@/utils/helper';

	export default {
		name: 'Dashboard',
		computed: {
			fullname() {
				return this.$store.getters.name;
			},
			role() {
				return getNameRole(this.$store.getters.roles[0]);
			}
		}
	};
</script>

<style lang="scss" scoped>
	@import '@/scss/_variables';

	.wapper {
		padding: 20px;

		.user-info {
			margin-top: 10px;
			margin-bottom: 10px;

			.wellcome {
				font-size: 18px;

				.fullname {
					font-weight: 600;
					color: $robins-egg-blue;
				}

				.role {
					font-weight: 600;
					color: $robins-egg-blue;
				}
			}
		}

		.user-idea-count {
			margin-bottom: 10px;
			.card {
				margin-bottom: 10px;

				.icon-card {
					font-size: 20px;
				}

				.detail-card {
					text-align: right;
					font-size: 20px;
					font-weight: 600;
				}
			}
		}
	}
</style>
