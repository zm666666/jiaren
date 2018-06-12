<template>
	<div id="tip-box">
		<transition name="tip-box">
			<div class="tip-box" v-show="tipBoxShow">
				<div class="tip-box-title">
					<img src="../../assets/img/logo.png" alt="" class="y-mid"><span class="message">通知</span>
				</div>
				<div class="tip-box-text" v-html="tipBoxText"></div>
			</div>
		</transition>
	</div>
</template>

<script>
	export default {
		name: "tip-box",
		props: ['show', 'text'],
		data:function () {
			return {

			}
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
		position: relative;
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

	.tip-box-enter-active{
		animation:  tip-box-in 0.3s ease forwards;
	}
	@keyframes tip-box-in {
		0% {
			margin-top: 0;
			opacity: 0;
			transform: scale(0.1,0.1);
		}
		100% {
			margin-top: 7%;
			opacity: 1;
			transform: scale(1,1);
		}
	}
	.tip-box-leave-active{
		animation:  tip-box-out 0.3s ease forwards;
	}
	@keyframes tip-box-out {
		0% {
			margin-top: 7%;
			opacity: 1;
			transform: scale(1,1);
		}
		100% {
			margin-top: 0;
			opacity: 0;
			transform: scale(0.1,0.1);
		}
	}
</style>
