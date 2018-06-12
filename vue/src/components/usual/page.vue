<template>
	<ul>
		<li>
			<button class="btn btn-default" :disabled="page==1" @click="changePage(1);">&lt&lt
			</button>
		</li>
		<li>
			<button class="btn btn-default" :disabled="page==1" @click="changePage(page-1)">&lt
			</button>
		</li>
		<li v-if="page>4&&page==pageNum">
			<button class="btn btn-default " v-html="page-4" @click="changePage(page-4)">
			</button>
		</li>
		<li v-if="page>3&&page>=pageNum-1">
			<button class="btn btn-default " v-html="page-3" @click="changePage(page-3)">1
			</button>
		</li>
		<li v-if="page>2">
			<button class="btn btn-default " v-html="page-2" @click="changePage(page-2)">1
			</button>
		</li>
		<li v-if="page>1">
			<button class="btn btn-default" v-html="page-1" @click="changePage(page-1)">1
			</button>
		</li>
		<li>
			<button class="btn btn-default active" v-html="page">
			</button>
		</li>
		<li v-if="pageNum-page>0&&page>0">
			<button class="btn btn-default" v-html="parseInt(page)+1"
					@click="changePage(parseInt(page)+1)">1
			</button>
		</li>
		<li v-if="pageNum-page>1&&page>0">
			<button class="btn btn-default" v-html="parseInt(page)+2"
					@click="changePage(parseInt(page)+2)">1
			</button>
		</li>
		<li v-if="pageNum-page>2&&page<=2&&page>0">
			<button class="btn btn-default " v-html="parseInt(page)+3"
					@click="changePage(parseInt(page)+3)">1
			</button>
		</li>
		<li v-if="pageNum-page>3&&page==1">
			<button class="btn btn-default" v-html="parseInt(page)+4"
					@click="changePage(parseInt(page)+4)">1
			</button>
		</li>
		<li>
			<button class="btn btn-default" :disabled="page==pageNum"
					@click="changePage(parseInt(page)+1)">&gt
			</button>
		</li>
		<li>
			<button class="btn btn-default" :disabled="page==pageNum"
					@click="changePage(pageNum)">&gt&gt
			</button>
		</li>
		<input type="number" style="width: 80px;display: inline-block" class="form-control"
			   v-model="showPage" @keydown.enter="getMsg">
		<span>&nbsp;/{{pageNum}}页&nbsp;</span>
		<button class="btn btn-default" @click="getMsg">跳转</button>
		<span>&nbsp;共{{total}}条,每页&nbsp;</span>
		<select name="" v-model="pageSize">
			<option value="10">10条</option>
			<option value="20">20条</option>
			<option value="50">50条</option>
			<option value="100">100条</option>
		</select>
	</ul>
</template>

<script>
    export default {
    	props:['pageTotal','tablePageSize'],
        name: "page",
		data:function () {
			return {
				page:1,
				showPage:1,
				pageSize:this.tablePageSize
			}
		},
		methods:{
			changePage:function (index) {
				this.showPage=index;
				this.page=index;
				this.getMsg();
			},
			getMsg:function () {
				let reg = /^[0-9]+.?[0-9]*$/;
				if (!reg.test(this.showPage)|| this.showPage < 1||this.showPage > this.pageNum ) {
					this.showPage = 1;
					this.page=1;
				}
				this.$emit('getMsg',{pageSize:this.pageSize,page:this.page});
			}
		},
		computed:{
        	pageNum: function () {
				if (this.total == 0)
					return 1;
				else
					return Math.ceil(this.total / this.pageSize);
			},
			total:function () {
				return this.pageTotal;
			}
		},
		watch:{
        	pageSize:function () {
				this.showPage=1;
				this.page=1;
				this.$emit('getMsg',{pageSize:this.pageSize,page:this.page});
			}
		}
    }
</script>

<style scoped>
	@import "../../assets/css/reset.css";
	*{
		font-size: 12px;
		color: #666;
	}
	ul{
		height: 24px;
		line-height: 24px;
		float: right;
	}
	select{
		height: 20px;
		position: relative;
		top: 1px;
	}
	li {
		display: inline-block;
	}
</style>
