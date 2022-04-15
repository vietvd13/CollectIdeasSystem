<template>
	<div class="wapper">
		<div class="user-idea-count">
			<div class="row">
				<div class="col-lg-4">
					<b-form-select v-model="selected" class="mb-3">
						<b-form-select-option :value="null">{{
							$t('DASHBOARD.OPTIONS')
						}}</b-form-select-option>
						<b-form-select-option
							v-for="(category, index) in categories"
							:key="index"
							:value="category.id"
							>{{ category.topic_name }}</b-form-select-option
						>
					</b-form-select>
				</div>
				<!-- <div class="col-lg-4">
					<b-form-input
						v-model="limit"
						placeholder="Display limit category"
						style="border: 1px solid #ddd"
						type="number"
					>
					</b-form-input>
				</div> -->
			</div>
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
									<span class="detail-title">{{ totals.total_idea }}</span>
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
									<span class="detail-title">{{ totals.total_comment }}</span>
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
									<span class="detail-title">{{ totals.total_likes }}</span>
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
									<span class="detail-title">{{ totals.total_dislike }}</span>
								</div>
							</b-col>
						</b-row>
					</b-card>
				</b-col>
			</b-row>
		</div>

		<div class="chart">
			<b-row>
				<b-col cols="12" sm="12" md="12" lg="6" xl="6">
					<b-card class="chart-total-category mb-3">
						<canvas id="chart-total-category"></canvas>
					</b-card>
				</b-col>

				<b-col cols="12" sm="12" md="12" lg="6" xl="6">
					<b-card class="chart-total-month mb-3">
						<canvas id="chart-total-month"></canvas>
					</b-card>
				</b-col>
			</b-row>
		</div>

		<div class="chart">
			<b-row>
				<b-col cols="12" sm="12" md="12" lg="12" xl="12">
					<b-card class="chart-list-categories">
						<canvas id="chart-list-categories"></canvas>
					</b-card>
				</b-col>
			</b-row>
		</div>
	</div>
</template>

<script>
	import Chart from 'chart.js';
	import { getCategoryDashboard, getTotal, getChartDonut } from '@/api/modules/dashboard';
	export default {
		name: 'Dashboard',
		mounted() {
			this.initChartTotalMonth();
			this.initChartTotalCategory();
			this.initChartCategories();
		},
		data() {
			return {
				selected: null,
				categories: [],
				totals: [],
				limit: 5,
				chart: []
			};
		},
		computed: {
			isChangeValue() {
				return this.selected;
			}
		},
		watch: {
			isChangeValue() {
				this.getValueChart();
			}
		},
		created() {
			this.getListCategoryDashboard();
			this.getTotalIdeas();
		},
		methods: {
			getTotalIdeas() {
				getTotal()
					.then(res => {
						this.totals = res;
					})
					.catch(err => {
						console.log(err);
					});
			},
			getListCategoryDashboard() {
				getCategoryDashboard()
					.then(res => {
						this.categories = res;
					})
					.catch(err => {
						console.log(err);
					});
			},
			async getValueChart() {
				try {
					const params = {
						category_id: this.selected,
						limit: this.limit
					};
					const res = await getChartDonut(params);
					return res;
				} catch (error) {
					console.log(error);
				}
			},
			async initChartCategories() {
				var ctx = document.getElementById('chart-list-categories').getContext('2d');
				try {
					const res = await this.getValueChart();
					const label = res.map(item => {
						return item.topic_name;
					});
					const data = res.map(item => {
						return item.idea_count;
					});
					new Chart(ctx, {
						type: 'bar',
						data: {
							labels: label,
							datasets: [
								{
									label: 'Idea',
									data: data,
									backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(255, 99, 132, 1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									borderWidth: 1
								}
							]
						},
						options: {
							title: {
								display: true,
								text: 'Total ideas by Category'
							},
							scales: {
								yAxes: [
									{
										ticks: {
											beginAtZero: true
										}
									}
								]
							},
							responsive: true
						}
					});
				} catch (error) {
					console.log(error);
				}
			},
			initChartTotalMonth() {
				var ctx = document.getElementById('chart-total-month').getContext('2d');

				var data = {
					datasets: [
						{
							data: [1, 10, 8, 2, 4, 9],
							backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)']
						}
					],

					labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sunday']
				};

				new Chart(ctx, {
					type: 'line',
					data: data,
					options: {
						scales: {
							yAxes: [
								{
									stacked: true
								}
							]
						}
					}
				});
			},
			async initChartTotalCategory() {
				var ctx = document.getElementById('chart-total-category').getContext('2d');
				try {
					const res = await this.getValueChart();
					const label = res.map(item => {
						return item.topic_name;
					});
					const data = res.map(item => {
						return item.idea_count;
					});

					new Chart(ctx, {
						type: 'doughnut',
						data: {
							datasets: [
								{
									fill: true,
									data: data,
									fill: true,
									backgroundColor: [
										'rgba(54, 162, 235, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 99, 132, 0.2)'
									],
									borderColor: 'rgb(54, 162, 235)',
									pointBackgroundColor: [
										'rgb(255, 112, 67)',
										'rgb(102, 187, 106)',
										'rgb(149, 117, 205)'
									],
									pointBorderColor: '#fff',
									pointHoverBackgroundColor: '#fff',
									pointHoverBorderColor: 'rgb(54, 162, 235)'
								}
							],
							labels: label
						}
					});
				} catch (error) {
					console.log(error);
				}
			}
		}
	};
</script>

<style lang="scss" scoped>
	@import '@/scss/_variables';

	.wapper {
		padding: 20px;

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

		.chart {
			.chart-list-categories {
				margin-bottom: 10px;
			}

			.chart-total-month {
				margin-bottom: 10px;
			}
		}
	}
</style>
