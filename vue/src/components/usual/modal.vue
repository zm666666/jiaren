<template>
	<div id="mask" v-show="shadowShow">
		<transition name="tip-box">
			<div id="modal" class="x-mid" v-show="modalShow">
				<div class="header" :style="{'width':modalWidth-30+'px'}">
					<span class="fa fa-file"></span>
					{{modalTitle}}
					<span class="modal-close" @click="cancel"></span>
				</div>
				<div class="body" :style="{'width':modalWidth-30+'px'}">
					<slot></slot>
				</div>
				<div class="footer" :style="{'width':modalWidth-20+'px'}">
					<div class="right">
						<button class="btn btn-default" @click="cancel">
							<span class="fa fa-close"></span>
							关闭
						</button>
						<button class="btn btn-primary" @click="save">
							<span class="fa fa-save"></span>
							保存
						</button>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
    export default {
        name: "modal",
		props: ['show','width', 'title'],
		data:function () {
			return {
				shadowShow:false,
				modalShow:false,
			}
		},
		methods:{
        	save:function(){
				this.$emit('modalSave');
			},
        	cancel:function () {
				this.$emit('modalCancel');
			}
		},
		mounted:function () {
		},
		computed:{
			tempShow:function(){
				return this.show;
			},
			modalWidth:function () {
				return this.width;
			},
			modalTitle:function () {
				return this.title;
			}
		},
		watch:{
			show:function(){
				let _this=this;
				if(this.tempShow){
					this.shadowShow=true;
					setTimeout(function () {
						_this.modalShow=true;
					},100)
				}
				else{
					this.modalShow=false;
					setTimeout(function () {
						_this.shadowShow=false;
					},200)
				}
			},
		}
    }
</script>

<style scoped>
	@import "../../assets/css/reset.css";
	.tip-box-enter-active{
		animation:  tip-box-in 0.3s ease forwards;
	}
	@keyframes tip-box-in {
		0% {
			margin-top: 0;
			opacity: 0;
		}
		100% {
			margin-top: 7%;
			opacity: 1;
		}
	}
	.tip-box-leave-active{
		animation:  tip-box-out 0.3s ease forwards;
	}
	@keyframes tip-box-out {
		0% {
			margin-top: 7%;
			opacity: 1;
		}
		100% {
			margin-top: 0;
			opacity: 0;
		}
	}
	#mask{
		top: 0;
		left: 0;
		position: fixed;
		height: 100%;
		width: 100%;
		z-index: 100;
		background-color: rgba(0,0,0,0.7);
	}

	#modal{
		margin-top: 7%;
	}

	.header{
		text-align: left;
		background-color: #fff;
		border-radius: 5px 5px 0 0;
		height: 20px;
		line-height: 20px;
		padding: 6px 15px;
		color: #aaa;
		font-size: 14px;
		font-weight: 700;
	}

	.body{
		padding: 8px 15px;
		border-top:1px #eee solid ;
		border-bottom:1px #eee solid ;
		background-color: #fff;
	}

	.footer{
		padding: 5px 10px;
		height: 22px;
		background-color: #fff;
		border-radius: 0 0 5px 5px;
	}
</style>
