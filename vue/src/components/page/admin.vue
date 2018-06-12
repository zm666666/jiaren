<template>
	<div id="checkCourse" ref="admin">
		<div class="index-body1">
			<div class="index-body2">
				<el-dialog :visible.sync="dialogFormVisible" width="40%">
					<div slot="title">
						<span class="dialog-title"><i class="el-icon-circle-plus-outline"
													  style="margin-right: 10px;"></i>添加或修改信息</span>
						<hr style="margin-top: 5px;"/>
					</div>
					<el-form label-width="80px" label-position="right" :model="saveJson" :rules="formRule" size="small"
							 :inline="true" ref="saveJson">
						<el-form-item v-for="item in tableMsg.tableKey" :label="tableMsg.msg.value[item]" :key="item"
									  :prop="item">
							<component v-if="!fk.has(item)" value-format="yyyy-MM-dd" :is="tableMsg.msg.type[item]" v-model="saveJson[item]" clearable style="max-width: 200px">

							</component>
							<el-select v-else v-model="saveJson[item]" value-key="id" clearable
									   style="max-width: 200px">
								<el-option
									v-for="val in interfaceReturnMsg[item]"
									:key="val.id"
									:label="val.val"
									:value="val.id">
								</el-option>
							</el-select>
						</el-form-item>
					</el-form>
					<div slot="footer" class="dialog-footer">
						<hr style="margin-bottom: 5px;"/>
						<el-button @click="dialogFormVisible = false">取 消</el-button>
						<el-button type="primary" @click="saveMsg">保 存</el-button>
					</div>
				</el-dialog>
				<el-row style="margin-bottom: 10px" :gutter="5" align="middle" type="flex">
					<el-col style="width: 60px;">
						<el-button @click="insertMsg" type="success" plain>
							<span class="fa fa-file"></span>新增
						</el-button>
					</el-col>
					<el-col v-for="item in tableMsg.tableKey" :key="item" style="max-width: 130px">
						<component :is="tableMsg.msg.type[item]" v-if="!fk.has(item)" size="small"
								   :placeholder="tableMsg.msg.value[item]" clearable v-model="searchMsg[item]"
								   value-format="yyyy-MM-dd"
								   @clear="getMsg" style="width: 100%">

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
					<el-col :span="1">
						<el-button type="primary" @click="getMsg">
							<i class="el-icon-search"></i>
						</el-button>
					</el-col>
					<el-col :span="1" style="position: absolute;right: 0;">
						<el-button type="danger" @click="delMsg(0)" style="float: right;">
							<i class="el-icon-delete"></i>
							批量删除
						</el-button>
					</el-col>
				</el-row>
				<el-row>
					<el-table :height="tableHeight" border stripe :data="tableMsg.tableData"
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
								<el-button @click="updateMsg(scope.row)">
									<i class="el-icon-edit" style="margin-right: 5px;"></i>编辑
								</el-button>
								<el-button type="danger" @click="delMsg([scope.row.id])">
									<i class="el-icon-delete" style="margin-right: 5px;"></i>删除
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
		name: "checkCourse",
		props:['mainHeight'],
		data: function () {
			return {
				tableName: '',
				tableMsg: {
					tableKey: [],
					msg: [],
					tableData: [],
				},
				searchMsg: {},
				interfaceMsg: {},
				interfaceReturnMsg: {},
				saveJson: {},
				formRule: {},
				fk: {},
				dialogFormVisible: false,
				selectVal: [],
				msgId: '',
			}
		},
		methods: {
			init: function () {
				let _this = this;
				this.tableName = this.$route.params.tableName;
				this.axios.post('/getMsg/getMsgFromSingleTable', {
					searchArr: this.searchMsg,
					table: this.tableName
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
			insertMsg: function () {
				let _this = this;
				for (let key in this.saveJson) {
					this.saveJson[key] = '';
				}
				this.msgId='';
				this.dialogFormVisible = true;
				setTimeout(function () {
					_this.$refs.saveJson.clearValidate();
				}, 1)
			},
			saveMsg: function () {
				let _this = this;
				this.$refs.saveJson.validate(function (bool) {
					if (bool) {
						_this.axios.post('/saveMsg/saveMsgFromSingleTable', {
							id: _this.msgId,
							data: _this.saveJson,
							table: _this.tableName
						}).then(function (res) {
							_this.$message.success('保存成功');
							_this.getMsg();
							_this.dialogFormVisible = false;
						});
					}
				});
			},
			getMsg: function () {
				let _this = this;
				this.axios.post('/getMsg/getMsgFromSingleTable', {
					searchArr: this.searchMsg,
					table: this.tableName
				}).then(function (res) {
					_this.tableMsg.tableData = res.data.data;
				});
			},
			updateMsg: function (obj) {
				let _this = this;
				this.dialogFormVisible = true;
				setTimeout(function () {
					_this.$refs.saveJson.clearValidate();
				}, 1);
				this.msgId = obj.id;
				for (let key in this.saveJson) {
					if (this.fk.has(key)) {
						this.saveJson[key] = this.interfaceReturnMsg[key].filter(function (val) {
							return val.val == obj[key];
						})[0].id;
					}
					else
						this.saveJson[key] = obj[key]
				}
			},
			delMsg: function (id) {
				if(id==0){
					id=[];
					for (let value of this.selectVal)
						id.push(value.id)
				}
				let _this = this;
				this.$confirm('确认删除？').then(function () {
					_this.axios.post('/delMsg/delMsgFromSingleTable', {
						id: id,
						table: _this.tableName
					}).then(function () {
						_this.$message.success('删除成功');
						_this.getMsg();
					})
				})
			},
			handleSelectionChange: function (val) {
				this.selectVal = val;
			},
		},
		mounted: function () {
			this.init();
		},
		computed: {
			tableHeight:function () {
				return this.mainHeight-112;
			}
			// tableName: function () {
			// 	return this.$store.state.tableName;
			// }
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
