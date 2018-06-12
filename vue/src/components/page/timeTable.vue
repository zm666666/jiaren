<template>
	<div id="timeTable">
		<div class="index-body1">
			<div class="index-body2">
				<el-row style="margin-bottom: 10px;" :gutter="5" align="middle" type="flex">
					<el-col style="max-width: 130px;">
						<el-date-picker value-format="yyyy-MM-dd" v-model="startDate" placeholder="开课日期" size="small" style="width: 100%;">

						</el-date-picker>
					</el-col>
					<el-col style="max-width: 130px;">
						<el-date-picker value-format="yyyy-MM-dd" v-model="finishDate" placeholder="结课日期" size="small" style="width: 100%;">

						</el-date-picker>
					</el-col>
					<el-col :span="2">
						<el-button type="primary" @click="init">
							<i class="el-icon-search"></i>
							搜索
						</el-button>
					</el-col>
				</el-row>
				<el-row>
					<el-table :height="tableHeight" style="width: 100%;" border stripe :data="tableData"
							  highlight-current-row empty-text="暂无数据">
						<el-table-column width="140" align="center" prop="courseIndex">

						</el-table-column>
						<el-table-column label="周一" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day1name}}</span><br>
								<span>{{scope.row.day1address}}</span><br>
								<span>{{scope.row.day1teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周二" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day2name}}</span><br>
								<span>{{scope.row.day2address}}</span><br>
								<span>{{scope.row.day2teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周三" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day3name}}</span><br>
								<span>{{scope.row.day3address}}</span><br>
								<span>{{scope.row.day3teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周四" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day4name}}</span><br>
								<span>{{scope.row.day4address}}</span><br>
								<span>{{scope.row.day4teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周五" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day5name}}</span><br>
								<span>{{scope.row.day5address}}</span><br>
								<span>{{scope.row.day5teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周六" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day6name}}</span><br>
								<span>{{scope.row.day6address}}</span><br>
								<span>{{scope.row.day6teacher}}</span>
							</template>
						</el-table-column>
						<el-table-column label="周日" width="140" align="center">
							<template slot-scope="scope">
								<span>{{scope.row.day7name}}</span><br>
								<span>{{scope.row.day7address}}</span><br>
								<span>{{scope.row.day7teacher}}</span>
							</template>
						</el-table-column>
					</el-table>
				</el-row>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "timeTable",
		props:['mainHeight'],
		data: function () {
			return {
				tableData:[],
				startDate:'',
				finishDate:''
			}
		},
		methods: {
			init: function () {
				let _this = this;
				this.axios.post('/getMsg/checkCourseMsg', {
					userId:localStorage.userId,
					startDate:this.startDate,
					finishDate:this.finishDate
				}).then(
					function (res) {
						_this.tableData=res.data;
					})
			},

		},
		mounted: function () {
			this.init();
		},
		computed: {
			tableHeight:function () {
				return this.mainHeight-112;
			}
		},
		watch: {
			$route:function () {
				this.init();
			}
		},
		components: {}
	}
</script>

<style scoped>
	@import "../../assets/css/reset.css";

	#admin {
		height: 100%;
	}

	.index-body1 {
		background-color: #f3f3f3;
		padding: 15px;
		height: 100%;
		position: relative;
		box-sizing: border-box;
	}

	.index-body2 {
		background-color: #fff;
		padding: 20px;
		height: 100%;
		position: relative;
		box-sizing: border-box;
		overflow: auto;
	}

	.el-button {
		padding: 5px;
	}

	.dialog-title {
		opacity: 0.8;
	}
</style>
