<template>
	<div id="my-table" @click="hidePop($event)">
		<div v-for="item in keyArr" :id="item" class="popover"
			 :style="{left:leftWidth[item]+'px',width:searchArrPopWidth[item]+'px',display:searchArrShow[item]?'block':'none'}">
			<div class="arrow x-mid"></div>
			<div class='input-group'>
				<input  type='text'
						class='form-control' v-model="searchArrVal[item]"
						:style="{width:searchArrInputWidth[item]+'px'}"
						:placeholder='thMsg.value[item]'>
				<button class='btn btn-default search-btn'
						@click="getMsg">
					<span class='fa fa-search'></span>
				</button>
				<button class='btn btn-danger cancel-btn'
						@click="searchArrVal[item]='';getMsg()">
					<span class='fa fa-remove'></span>
				</button>
			</div>
		</div>
		<div class="header-div">
			<table>
				<thead>
				<tr>
					<th style="min-width: 40px;max-width: 40px;position: relative;">
						<input
							type="checkbox"
							style="margin: 0;position: relative;top: 2px;"
							v-model="allSelected">
					</th>
					<th v-for="item in keyArr"
						:style="{minWidth:thMsg.width[item]+'px',maxWidth:thMsg.width[item]+'px'}">
						<span
							class="fa left-icon"
							@mouseover="spanArr.all[item]=true"
							@mouseout="spanArr.all[item]=false"
							@click="sort(item)"
							:class="[{'green':spanArr.left[item]||spanArr.all[item]},spanArr.icon[item]]"
						></span>
						<p>{{thMsg.value[item]}}</p>
						<span class="fa fa-search right-icon"
							  @mouseover="spanArr.all[item]=true"
							  @mouseout="spanArr.all[item]=false"
							  @click="showPop(item)"
							  :class="{green:spanArr.right[item]||spanArr.all[item]}"
						></span>
					</th>
					<th style="min-width: 200px;max-width: 200px;">
						<p>操作</p>
					</th>
				</tr>
				</thead>
			</table>
		</div>
		<div class="body-div">
			<table>
				<tbody>
				<tr v-for="item in tableJson">
					<td style="min-width: 31px;max-width:31px;position: relative;border-left: none">
						<input type="checkbox" style="margin: 0;position: relative;top: 2px;"
							   :value="item.id" v-model="delId">
					</td>
					<td v-for="val in keyArr"
						:style="{minWidth:thMsg.width[val]-10+'px',maxWidth:thMsg.width[val]-10+'px'}">

						<img :src="'http://www.czj.com/upload/'+item[val]" v-if="val=='img'" style="height: 150px;width: 150px;margin-top: 10px;">
						<br v-if="val=='img'">
						{{item[val]}}
					</td>
					<td style="min-width: 190px;max-width: 190px;">
						<button @click="seeMsg(item)" style="margin-right: 10px;"
								class="btn btn-default"><span
							class="fa fa-file"></span>查看
						</button>
						<button class="btn btn-danger"
								@click="delSingle(item.id,'是否确认删除此条信息？？')"><span
							class="fa fa-minus"></span>删除
						</button>
					</td>
				</tr>
				</tbody>
			</table>
			<div v-if="!tableJson||tableJson.length==0"
				 style="color: rgb(170, 170, 170);position: relative;width: 100%;height: 100%;">
				<span class="mid">未查找到数据</span></div>
		</div>
	</div>


</template>

<script>
	export default {
		props:['tableData','tableKey','msg','tableSpanArr','popoverShow','popoverWidth','popoverInputWidth','popoverLeftWidth'],
		name: "my-table",
		data:function () {
			return {
				allSelected:false,
				delId:'',
				keyArr:[],
				searchArrVal: {},
				searchArrShow: {},
				searchArrPopWidth: {},
				searchArrInputWidth: {},
				leftWidth:{},
				//2个span显示变色以及图标
				spanArr:{
					left:{},
					right:{},
					all:{},
					icon:{}
				},
				//当前搜索的键
				searchString: '',
				sortName:'',
				sortAsc:'',
			}
		},
		methods:{
			getMsg:function(){
				this.$emit('getTableMsg',{searchArr:this.searchArrVal,sortName:this.sortName,sortAsc:this.sortAsc})
			},
			seeMsg:function (item) {
				this.$emit('seeMsg',item)
			},
			delSingle:function (id) {
				this.$emit('delMsg',id)
			},
			sort: function (str) {
				this.allSelected = false;
				let temp = this.spanArr.icon[str];
				if (temp == 'fa-unsorted') {
					this.spanArr.icon[str] = 'fa-sort-numeric-asc';
					this.sortName = str;
					this.sortAsc = 'asc';
					this.spanArr.left[str] = true;
				}
				else {
					if (temp == 'fa-sort-numeric-asc') {
						this.spanArr.icon[str] = 'fa-sort-numeric-desc';
						this.sortName = str;
						this.sortAsc = 'desc';
						this.spanArr.left[str] = true;
					}
					else {
						this.spanArr.icon[str] = 'fa-unsorted';
						this.sortName = '';
						this.sortAsc = '';
						this.spanArr.left[str] = false;
					}
				}
				this.getMsg();
			},
			showPop:function (str) {
				for (let key in this.searchArrVal) {
					this.searchArrShow[key] = false;
					if (this.searchArrVal[key] == '')
						this.spanArr.right[key] = false;
					else
						this.spanArr.right[key] = true;
				}
				this.searchArrShow[str] = true;
				this.searchString = str;
				event.stopPropagation();
			},
			hidePop:function (e) {
				if(this.searchString){
					let popover=document.querySelector('#'+this.searchString);
					let flag=popover.contains(e.target);
					let flag1=(popover!=e.target);
					if(!flag&&flag1){
						for (let key of this.keyArr) {
							if (!this.searchArrVal[key])
								this.spanArr.right[key] = false;
							else{
								this.spanArr.right[key] = true;
							}
							this.searchArrShow[key]=false;
						}
					}
				}
			}
		},
		mounted:function () {
		},
		computed:{
			tableJson:function () {
				return this.tableData;
			},
			thMsg:function () {
				return this.msg;
			},
		},
		watch:{
			tableKey:function () {
				let _this=this;
				let colorTemp={},iconTemp={},temp={},sum=0;
				for (let key of _this.tableKey){
					temp[key]='';
					colorTemp[key]=false;
					iconTemp[key]='fa-unsorted';
					_this.searchArrPopWidth[key] = Number.parseInt(_this.msg.width[key]) + 46;
					_this.searchArrInputWidth[key] = Number.parseInt(_this.msg.width[key]) - 24;
					_this.leftWidth[key] = sum;
					sum += Number.parseInt(_this.msg.width[key]);
				}
				_this.spanArr.left=JSON.parse(JSON.stringify(colorTemp));
				_this.spanArr.right=JSON.parse(JSON.stringify(colorTemp));
				_this.spanArr.all=JSON.parse(JSON.stringify(colorTemp));
				_this.spanArr.icon=JSON.parse(JSON.stringify(iconTemp));
				_this.searchArrShow=JSON.parse(JSON.stringify(colorTemp));
				_this.searchArrVal=temp;
				_this.keyArr=_this.tableKey;
			}
		},
		components:{

		},
		directives:{
			focus: {
				update: function (el) {
					el.focus()
				}
			}
		}

	}
</script>

<style scoped>
	@import "../../assets/css/reset.css";
	#my-table{
		position: relative;
		height: 90%;
		margin-bottom: 10px;
		border: 1px solid rgb(228, 231, 236);
		width: auto;
		min-width: 1430px;
	}
	.popover{
		padding: 9px 14px;
		border:1px solid rgba(0,0,0,0.2);
		border-radius: 5px;
		position: absolute;
		top: 47px;
		z-index: 5;
		display: block;
		background-color: white;
	}
	.popover .arrow{
		transform: rotate(45deg);
		width: 15px;
		height: 15px;
		background: white;
		border-left:1px solid rgba(0,0,0,0.2);
		border-top:1px solid rgba(0,0,0,0.2);
		top: -9px;

	}
	.popover input{
		border-radius: 2px 0 0 2px;
	}
	.popover .search-btn{
		width: 30px;
		height: 24px;
		border-radius: 0;
		border-left: none;
		border-right: none;
		margin-left: -5px;
	}
	.popover .cancel-btn{
		width: 30px;
		height: 24px;
		border-radius: 0 2px 2px 0;
		margin-left: -5px;
	}
	.right-icon{
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		padding: 0;
		margin: 0;
		right: 10px;
		color: #DEDEDE;
	}
	.left-icon{
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		padding: 0;
		margin: 0;
		left: 10px;
		color: #DEDEDE;
	}
	.header-div{
		position: absolute;
		top: 0;
	}
	.body-div{
		width: auto;
		min-width: 1410px;
		margin-top: 36px;
		overflow-y: auto;
		height: 90%;
	}
	.body-div td{
		padding-left: 5px;
		padding-right: 5px;
	}
	th{
		position: relative;
	}
	td{
		color: #666;
		font-size: 12px;
		height: 28px;
		line-height: 28px;
	}
	td button{
		margin-bottom: 3px;
	}
	th p{
		margin: 0;
		color: #19AA8D;
	}
	td,th{
		border: 1px solid rgb(228, 231, 236);
		text-align: center;
		overflow: hidden;/*内容超出后隐藏*/
		text-overflow: ellipsis;/* 超出内容显示为省略号*/
		white-space: nowrap;/*文本不进行换行*/
	}
	.header-div th{
		background: #f2f2f2;
		height: 34px;
		line-height: 34px;
		font-size: 12px;
		font-weight: 700;
	}
	.green{
		color: #19AA8D;
	}
</style>
