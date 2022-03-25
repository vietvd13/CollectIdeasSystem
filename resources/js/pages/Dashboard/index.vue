<template>
	<div class="wapper">
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

		<div class="chart">
			<b-row>
				<b-col cols="12" sm="12" md="12" lg="6" xl="6">
					<b-card class="chart-total-category">
						<canvas id="chart-total-category"></canvas>
					</b-card>
				</b-col>

				<b-col cols="12" sm="12" md="12" lg="6" xl="6">
					<b-card class="chart-total-month">
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

	export default {
		name: 'Dashboard',
		mounted() {
			this.initChartTotalMonth();
			this.initChartTotalCategory();
			this.initChartCategories();
		},
		methods: {
			initChartCategories() {
				var ctx = document.getElementById('chart-list-categories').getContext('2d');
				new Chart(ctx, {
					type: 'bar',
					data: {
						labels: [
							'Category 1',
							'Category 2',
							'Category 3',
							'Category 4',
							'Category 5',
							'Category 6'
						],
						datasets: [
							{
								label: 'Idea',
								data: [12, 19, 3, 5, 2, 3],
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
			},
			initChartTotalMonth() {
				var ctx = document.getElementById('chart-total-month').getContext('2d');

				var data = {
					datasets: [
						{
							data: [20, 10],
							backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)']
						}
					],

					labels: ['Like', 'Dislike']
				};

				new Chart(ctx, {
					type: 'pie',
					data: data,
					options: {
						title: {
							display: true,
							text: 'Total Likes and Dislikes in the month'
						}
					}
				});
			},
			initChartTotalCategory() {
				var ctx = document.getElementById('chart-total-category').getContext('2d');

				new Chart(ctx, {
					type: 'radar',
					data: {
						labels: [
							'Category 1',
							'Category 2',
							'Category 3',
							'Category 4',
							'Category 5',
							'Category 6'
						],
						datasets: [
							{
								label: 'Like',
								fill: true,
								data: [40, 50, 100, 55, 12, 88],
								fill: true,
								backgroundColor: 'rgba(54, 162, 235, 0.2)',
								borderColor: 'rgb(54, 162, 235)',
								pointBackgroundColor: 'rgb(54, 162, 235)',
								pointBorderColor: '#fff',
								pointHoverBackgroundColor: '#fff',
								pointHoverBorderColor: 'rgb(54, 162, 235)'
							},
							{
								label: 'Dislike',
								fill: true,
								data: [10, 4, 6, 2, 7, 20],
								backgroundColor: 'rgba(255, 99, 132, 0.2)',
								borderColor: 'rgb(255, 99, 132)',
								pointBackgroundColor: 'rgb(255, 99, 132)',
								pointBorderColor: '#fff',
								pointHoverBackgroundColor: '#fff',
								pointHoverBorderColor: 'rgb(255, 99, 132)'
							}
						]
					},
					options: {
						title: {
							display: true,
							text: 'Total likes and dislikes by category'
						},
						scale: {
							angleLines: {
								display: false
							}
						}
					}
				});
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
