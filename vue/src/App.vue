<template>
	<div id="app">
		<el-container>
			<el-header>
				<el-row>
					<el-col :span="19" style="margin-left: 20px;">
						<span class="title" @click="jumpIndex">“佳人”瑜伽会所会员信息服务系统</span>
						<span class="y-mid res">
					<span class="title-little">易于使用的信息管理系统</span>
					<br>
					<span class="title-little">Easy to use information management system</span>
				</span>
					</el-col>
					<el-col :span="4">
						<div style="float: right">
							<img src="./assets/img/people.png" class="user-img">
							<el-dropdown class="user-name" @command="jump">
						<span class="el-dropdown-link">
							{{userName}}<i class="el-icon-arrow-down el-icon--right"></i>
						</span>
								<el-dropdown-menu slot="dropdown">
									<el-dropdown-item command="/login">退出登录</el-dropdown-item>
								</el-dropdown-menu>
							</el-dropdown>
						</div>
					</el-col>
				</el-row>
			</el-header>
			<el-container>
				<el-aside width="180px" v-show="userName!=''">
					<el-menu
						default-active="course"
						background-color="#545c64"
						text-color="#fff"
						active-text-color="#ffd04b"
						style="height: 100%;"
						v-if="userName=='admin'"
						ref="adminMenu"
					>
						<router-link :to="{name:'admin',params:{tableName:'course'}}">
							<el-menu-item index="course">
								<template slot="title">
									<i class="el-icon-document"></i>
									<span>课程管理</span>
								</template>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'admin',params:{tableName:'member'}}">
							<el-menu-item index="member">
								<i class="el-icon-document"></i>
								<span slot="title">会员管理</span>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'admin',params:{tableName:'teacher'}}">
							<el-menu-item index="teacher">
								<i class="el-icon-document"></i>
								<span slot="title">教师管理</span>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'admin',params:{tableName:'elective'}}">
							<el-menu-item index="elective">
								<i class="el-icon-document"></i>
								<span slot="title">选课管理</span>
							</el-menu-item>
						</router-link>
					</el-menu>
					<el-menu
						default-active="checkCourse"
						background-color="#545c64"
						text-color="#fff"
						active-text-color="#ffd04b"
						style="height: 100%;"
						v-else
						ref="memberMenu"
					>
						<router-link :to="{name:'member',params:{otherCondition:'checkCourse'}}">
							<el-menu-item index="checkCourse">
								<template slot="title">
									<i class="el-icon-document"></i>
									<span>可选课程</span>
								</template>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'member',params:{otherCondition:'returnCourse'}}">
							<el-menu-item index="returnCourse">
								<template slot="title">
									<i class="el-icon-document"></i>
									<span>退选课程</span>
								</template>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'member',params:{otherCondition:'evaluationCourse'}}">
							<el-menu-item index="evaluationCourse">
								<template slot="title">
									<i class="el-icon-document"></i>
									<span>评价课程</span>
								</template>
							</el-menu-item>
						</router-link>
						<router-link :to="{name:'timeTable',params:{otherCondition:'timeTable'}}">
							<el-menu-item index="timeTable">
								<template slot="title">
									<i class="el-icon-document"></i>
									<span>我的课表</span>
								</template>
							</el-menu-item>
						</router-link>
					</el-menu>
				</el-aside>
				<el-main :style="{height:mainHeight+'px'}">
					<router-view :mainHeight="mainHeight"/>
				</el-main>
			</el-container>
		</el-container>
	</div>
</template>

<script>
	export default {
		name: 'App',
		data: function () {
			return {
				userName: localStorage.userName ? localStorage.userName : '',
				mainHeight: '',
			}
		},
		methods: {
			jumpIndex: function () {
				this.$router.replace({path: '/'});
			},
			jump: function () {
				localStorage.login = 'false';
				localStorage.userName='';
				this.userName = '';
				this.$router.replace({name:'login'});
			},
		},
		mounted: function () {
			let _this=this;
			if(localStorage.login==='true'){
				if(this.userName==='admin'){
					this.$refs.adminMenu.activeIndex=this.$route.params.tableName;
				}
				else{
					this.$refs.memberMenu.activeIndex=this.$route.params.otherCondition;
				}
			}
			this.mainHeight=window.innerHeight-60;
			window.addEventListener('resize',function () {
				_this.mainHeight=window.innerHeight-60;
			})
		},
		computed: {},
		watch:{
			$route:function () {
				let _this = this;
				if (location.hash == '#/login') {
					this.userName = '';
				}
				else {
					if (localStorage.login == 'false') {
						localStorage.userName='';
						this.userName = '';
						this.$router.replace({name: 'login'});
					}
				}
			}
		}
	}
</script>

<style scoped>
	@import "assets/css/reset.css";

	#app {
		overflow-x: hidden;
	}

	.el-header {
		border-bottom: 2px solid #e7eaec;
	}

	.el-header .el-col {
		position: relative;
	}

	.title {
		color: #18AA8E;
		font-size: 22px;
		line-height: 60px;
	}

	.title-little {
		color: #18AA8E;
		font-size: 14px;
	}

	.res {
		display: inline-block;
		margin-left: 10px;
	}

	.user-img {
		height: 34px;
		width: 34px;
		border-radius: 17px;
		margin-top: 15px;
		float: left;
	}

	.user-name {
		font-size: 14px;
		height: 49px;
		line-height: 75px;
		margin-left: 10px;
	}

	.el-dropdown-menu__item {
		padding: 2px 5px;
	}

	a{
		text-decoration: none;
	}
</style>
