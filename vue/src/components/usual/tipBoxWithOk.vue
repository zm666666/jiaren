<template>
	<transition name="tip-box">
		<div class="tip-box" v-show="tipBoxShow">
			<div class="tip-box-title">
				<img src="../../assets/img/logo.png" alt="" class="y-mid"><span class="message">通知</span>
			</div>
			<div class="tip-box-text" v-html="tipBoxText"></div>
			<div class="tip-box-btns-3">
				<button class="tip-box-btn-1" @click="tipBoxOk">确定</button>
			</div>
		</div>
	</transition>
</template>

<script>
    export default {
        name: "tip-box-with-ok",
		props: ['show', 'text'],
		data:function () {
			return {

			}
		},
		methods:{
			tipBoxOk:function () {
				this.$emit('tipBoxOk')
			},
		},
		mounted:function () {
		},
		computed:{
			tipBoxShow:function () {
				return this.show;
			},
			tipBoxText:function () {
				return this.text;
			}
		},
		watch:{

		}
    }
</script>

<style scoped>
	@import "../../assets/css/reset.css";

	img{
		width: 20px;
		height: 20px;
	}

	.message{
		margin-left: 30px;
	}

	.tip-box {
		margin-top: 7%;
		width: 320px;
		background: #fff;
		position: absolute;
		top: 0;
		left: 50%;
		z-index: 999999;
		margin-left: -160px;
		border-radius: 6px;
		box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
	}

	.tip-box-title {
		background-color: #19AA8D;
		border-radius: 5px 5px 0 0;
		line-height: 35px;
		color: #fff;
		padding-left: 10px;
	}

	.tip-box-text {
		max-height: 200px;
		overflow-y: auto;
		padding: 10px;
		width: 300px;
		background: #fff;
		color: #252525;
		line-height: 25px;
		text-align: center;
	}

	.tip-box-btn-1 {
		height: 35px;
		border: none;
		font-size: 14px;
		width: 100%;
		padding: 1px 6px;
		border-bottom-left-radius: 5px;
		color: #fff;
		background-color: #19AA8D;
	}
	.tip-box-btns-3 {
		float: left;
		height: 35px;
		width: 100%;
		border-right: 1px solid #CCC;
		border-bottom-left-radius: 5px;
		outline-color: #13826B;
	}
</style>
