<template>
	<div id="login">
		<el-dialog :visible.sync="dialogFormVisible" width="40%">
			<div slot="title">
						<span class="dialog-title"><i class="el-icon-circle-plus-outline"
													  style="margin-right: 10px;"></i>注册</span>
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
		<img src="../../assets/img/loginBackground.jpg" alt="" :style="{height:imgHeight+'px'}">
		<div id="content" class="x-mid">
			<div id="header">
				“佳人”瑜伽会所
			</div>
			<div id="body">
				<input type="text" placeholder="用户名" v-model="name">
				<input type="password" placeholder="密码" v-model="psd">
				<el-radio v-model="tableName" label="admin">管理员</el-radio>
				<el-radio v-model="tableName" label="member">会员</el-radio>
				<el-button @click="insertMsg" type="success" style="margin-left: 90px;">
					注 册
				</el-button>
				<span id="loginButton" @click="login">登陆</span>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "login",
		props:['mainHeight'],
		data:function () {
			return {
				name:'',
				psd:'',
				tableName:'member',
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
			}
		},
		methods:{init: function () {
				let _this = this;
				this.axios.post('/getMsg/getMsgFromSingleTable', {
					table: 'member'
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
						_this.saveJson = JSON.parse(JSON.stringify(tempJson));
					});
			},
			login:function () {
				let _this = this;
				this.axios.post('/getMsg/login',{username:this.name,password:this.psd,tableName:this.tableName}).then(function (response) {
					let res=response.data;
					if(res.code==200){
						_this.$message.success(res.msg);
						localStorage.userName=res.userName;
						localStorage.userId=res.id;
						localStorage.userType=(res.type==1?'admin':'member');
						localStorage.login='true';
						setTimeout(function () {
							location.reload();
						},2000)
					}
					else
						_this.$message.error(res.msg);
				}).catch(function () {
					_this.$message.error('用户名或密码错误，请重试');
				})
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
							data: _this.saveJson,
							table: 'member'
						}).then(function (res) {
							_this.$message.success('注册成功，请登陆');
							_this.dialogFormVisible = false;
						});
					}
				});
			},
		},
		mounted:function () {
			this.init();
			if(localStorage.login){
				this.$router.replace({path:'/'});
			}
			let oLogin=document.querySelector('#login');
			oLogin.height=window.innerHeight;
		},
		computed:{
			imgHeight:function () {
				return this.mainHeight-4;
			}
		},
		components:{
		}
	}
</script>

<style scoped>
	@import "../../assets/css/reset.css";
	#login{
		overflow: hidden;
	}
	img{
		width: 100%;
	}
	#content{
		top: 20%;
	}
	#header{
		padding: 15px 20px;
		width: 300px;
		height: 20px;
		background-color: #19AA8D;
		color: white;
		text-align: center;
		border-radius: 5px 5px 0 0;
		font-size: 21px;
	}
	#body{
		width: 300px;
		background-color: white;
		padding: 15px 20px;
		border-radius: 0 0 5px 5px;
	}
	.input-div{
		margin-bottom: 5px;
	}
	input{
		width: 280px;
		height: 20px;
		border-radius: 5px;
		border: 1px solid #eaeaea;
		padding: 10px;
		margin: 0px auto 15px;
	}
	#loginButton{
		background-color: #F67A6E;
		color: white;
		width: 290px;
		height: 45px;
		border-radius: 5px;
		display: block;
		text-align: center;
		line-height: 45px;
		font-size: 21px;
		margin:20px auto 10px;
		cursor: pointer;
	}
</style>
