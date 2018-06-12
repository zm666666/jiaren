<template>
	<div id="member">
		<div class="index-body1">
			<div class="index-body2">
				<el-dialog :visible.sync="dialogFormVisible" width="40%">
					<div slot="title">
						<span class="dialog-title"><i class="el-icon-circle-plus-outline"
													  style="margin-right: 10px;"></i>评价课程</span>
						<hr style="margin-top: 5px;"/>
					</div>
					<el-input v-model="evaluation" type="textarea">

					</el-input>
					<div slot="footer" class="dialog-footer">
						<hr style="margin-bottom: 5px;"/>
						<el-button @click="dialogFormVisible = false">取 消</el-button>
						<el-button type="primary" @click="evaluationCourse">保 存</el-button>
					</div>
				</el-dialog>
				<el-dialog :visible.sync="dialogCardVisible" width="40%">
					<div slot="title">
						<span class="dialog-title">
						<i class="el-icon-view" style="margin-right: 10px;"></i>
						课程评价
						</span>
						<hr style="margin-top: 5px;"/>
					</div>
					<el-card>
						<div v-for="item in evaluationMsg" :key="item.id">
							<div>
								<div>{{item.evaluation}}</div>
								<div style="text-align: right">{{item.name+' '+item.date}}</div>
							</div>
							<hr>
						</div>
					</el-card>
					<div slot="footer" class="dialog-footer">
						<hr style="margin-bottom: 5px;"/>
						<el-button type="primary" @click="dialogCardVisible=false">确 定</el-button>
					</div>
				</el-dialog>
				<el-row style="margin-bottom: 10px;" :gutter="5" align="middle" type="flex">
					<el-col v-for="item in tableMsg.tableKey" :key="item" style="max-width: 130px">
						<component :is="tableMsg.msg.type[item]" v-if="!fk.has(item)" size="small"
								   :placeholder="tableMsg.msg.value[item]" clearable v-model="searchMsg[item]"
								   value-format="yyyy-MM-dd" @clear="getMsg" style="width: 100%">

						</component>
						<el-select v-else size="small" :placeholder="tableMsg.msg.value[item]" v-model="searchMsg[item]"
								   value-key="id" clearable @clear="getMsg">
							<el-option
								v-for="val in interfaceReturnMsg[item]"
								:key="val.id"
								:label="val.val"
								:value="val.id">
							</el-option>
						</el-select>
					</el-col>
					<el-col :span="2">
						<el-button type="primary" @click="getMsg">
							<i class="el-icon-search"></i>
							搜索
						</el-button>
					</el-col>
					<el-col :span="1" style="position: absolute;right: 0;">
						<el-button type="success" @click="checkCourse(0)" style="float: right;" v-if="$route.params.otherCondition=='checkCourse'">
							<i class="el-icon-star-off"></i>
							批量选课
						</el-button>
						<el-button type="danger" @click="returnCourse(0)" style="float: right;" v-if="$route.params.otherCondition=='returnCourse'">
							<i class="el-icon-delete"></i>
							批量退课
						</el-button>
					</el-col>
				</el-row>
				<el-row>
					<el-table :height="tableHeight" style="width: 100%;" border stripe :data="tableMsg.tableData"
							  highlight-current-row
							  @selection-change="handleSelectionChange">
						<el-table-column
							type="selection"
							width="55" align="center">
						</el-table-column>
						<el-table-column v-for="item in tableMsg.tableKey" :prop="item"
										 :label="tableMsg.msg.value[item]"
										 :width="tableMsg.msg.width[item]" sortable show-overflow-tooltip :key="item.id"
										 align="center">
						</el-table-column>
						<el-table-column width="200" align="center" label="操作">
							<template slot-scope="scope">
								<el-button type="success" @click="seeCourseEvaluation(scope.row.id)" v-if="$route.params.otherCondition=='checkCourse'">
									<i class="el-icon-view" style="margin-right: 5px;"></i>查看评价
								</el-button>
								<el-button type="success" @click="checkCourse([scope.row.id])" v-if="$route.params.otherCondition=='checkCourse'">
									<i class="el-icon-star-off" style="margin-right: 5px;"></i>选课
								</el-button>
								<el-button type="danger" @click="returnCourse([scope.row.id])" v-if="$route.params.otherCondition=='returnCourse'">
									<i class="el-icon-delete" style="margin-right: 5px;"></i>退课
								</el-button>
								<el-button type="primary" @click="openDialog(scope.row.id)" v-if="$route.params.otherCondition=='evaluationCourse'">
									<i class="el-icon-edit" style="margin-right: 5px;"></i>评价
								</el-button>
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
		name: "member",
		props:['mainHeight'],
		data: function () {
			return {
				tableMsg: {
					tableKey: [],
					msg: [],
					tableData: [],
				},
				searchMsg: {},
				interfaceMsg: {},
				interfaceReturnMsg: {},
				fk: {},
				dialogFormVisible: false,
				dialogCardVisible:false,
				selectVal: [],
				msgId: '',
				otherCondition:{
					checkCourse:' and course.id not in (SELECT elective.course from elective where elective.member='+localStorage.userId+')',
					returnCourse:' and course.id in (SELECT elective.course from elective where elective.member='+localStorage.userId+' and allow = 2)',
					evaluationCourse:' and course.id in (SELECT elective.course from elective where elective.member='+localStorage.userId+' and allow = 1)',
				},
				evaluation:'',
				courseId:'',
				evaluationMsg:{}
			}
		},
		methods: {
			init: function () {
				let _this = this;
				this.axios.post('/getMsg/getMsgFromSingleTable', {
					searchArr: this.searchMsg,
					table: 'course',
					otherCondition:this.otherCondition[this.$route.params.otherCondition]
				}).then(
					function (res) {
						let axiosArr = [], tempJson = {}, tempRule = {};
						_this.tableMsg.tableData = res.data.data;
						_this.tableMsg.msg = res.data.msg;
						_this.fk = new Set(res.data.fk);
						for (let key of res.data.key) {
							let tempArr = [];
							let tempTrigger = _this.fk.has(key) ? 'change' : 'blur';
							tempArr.push({
								required: true,
								message: '请输入' + _this.tableMsg.msg.value[key],
								trigger: tempTrigger
							});
							tempRule[key] = tempArr;
							tempJson[key] = '';
							if (_this.fk.has(key)) {
								_this.interfaceMsg[key] = res.data.interface[key];

								function tempFunction() {
									return _this.axios.post('/getMsg/getInterfaceMsg', res.data.interface[key]).then(function (response) {
										_this.interfaceReturnMsg[key] = response.data.data;
									})
								}

								axiosArr.push(tempFunction());
							}
						}
						if (axiosArr.length != 0) {
							_this.axios.all(axiosArr).then(function () {
								_this.formRule = JSON.parse(JSON.stringify(tempRule));
								_this.tableMsg.tableKey = JSON.parse(JSON.stringify(res.data.key));
							});
						}
						else {
							_this.formRule = JSON.parse(JSON.stringify(tempRule));
							_this.tableMsg.tableKey = JSON.parse(JSON.stringify(res.data.key));
						}
						_this.searchMsg = JSON.parse(JSON.stringify(tempJson));
						_this.saveJson = JSON.parse(JSON.stringify(tempJson));
					});
			},
			getMsg: function () {
				let _this = this;
				this.axios.post('/getMsg/getMsgFromSingleTable', {
					searchArr: this.searchMsg,
					table: 'course',
					otherCondition:this.otherCondition[this.$route.params.otherCondition]
				}).then(function (res) {
					_this.tableMsg.tableData = res.data.data;
				});
			},
			checkCourse: function (id) {
				if(id==0){
					id=[];
					for (let value of this.selectVal)
						id.push(value.id)
				}
				let _this = this;
				_this.axios.post('/saveMsg/checkCourse', {
					courseId: id,
					memberId:localStorage.userId,
				}).then(function () {
					_this.$message.success('选课成功，等待请等待管理员通过');
					_this.getMsg();
				})
			},
			returnCourse:function(id){
				if(id==0){
					id=[];
					for (let value of this.selectVal)
						id.push(value.id)
				}
				let _this = this;
				this.$confirm('确认退选这些课程？').then(function () {
					_this.axios.post('/delMsg/returnCourse', {
						courseId: id,
						memberId:localStorage.userId,
					}).then(function () {
						_this.$message.success('退选成功,若想重新选课请前往可选课程模块');
						_this.getMsg();
					})
				})
			},
			evaluationCourse:function(){
				let _this = this,date = new Date();
				let myDate=date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
				_this.axios.post('/saveMsg/evaluationCourse', {
					courseId: this.courseId,
					memberId:localStorage.userId,
					date:myDate,
					evaluation:this.evaluation
				}).then(function () {
					_this.dialogFormVisible=false;
					_this.$message.success('评价成功');
					_this.getMsg();
				})
			},
			openDialog:function(id){
				this.dialogFormVisible=true;
				this.courseId=id;
			},
			handleSelectionChange: function (val) {
				this.selectVal = val;
			},
			seeCourseEvaluation:function (id) {
				let _this = this;
				_this.axios.post('/getMsg/getCourseEvaluation', {
					courseId: id,
				}).then(function (res) {
					_this.evaluationMsg=res.data.data;
					_this.dialogCardVisible=true;
				})
			}
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
