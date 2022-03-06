<template>
	<view class="body">
		<view class="form">
			<view class="title">
				<text>七点中文网</text>
			</view>
			<view class="form_item">
				<input type="text" placeholder="在此输入您的手机号" v-model="posts.phone">
			</view>
			<view class="form_item">
				<input type="password" placeholder="在此输入密码" v-model="posts.password">
			</view>
			<!-- <view class="form_item">
				<input type="text" placeholder="再次输入密码">
			</view> -->
			<view class="form_item no_border">
				<button @click="submit">立即登录</button>
			</view>
			<view class="navicate">
				<navigator url="./register">注册</navigator>
				<navigator url="#" @click="toIndex">回到首页</navigator>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				posts:{
					phone: '',
					password: ''
				}
			}
		},
		methods: {
			submit(){
				uni.showLoading();
				if(!this.posts.phone||!this.posts.password||this.posts.password.length<6||this.posts.phone.length<11){
					uni.showModal({
						title:'提示',
						content: '手机号或密码格式有误',
						showCancel:false,
					})
					uni.hideLoading();
					return false;
				}
				else{
					var formData = {};
					for(var val in this.posts){
						formData[val] = this.posts[val];
					}
					var _this = this;
					this.$axios.post('/Login/login',formData).then((res)=>{
						if(res.status=='y'){
							uni.hideLoading();
							uni.showModal({
								title:'提示',
								content:'登录成功！',
								showCancel:false,
								complete: () => {
									uni.setStorage({
										key:'user',
										data:{
											phone:formData.phone,
											user_id: res.info
										},
										success: () => {
											uni.switchTab({
												url:'../user/center'
											})
										}
									})
								}
							})
						}
						else{
							uni.hideLoading();
							uni.showModal({
								title:'提示',
								content: res.info,
								showCancel:false
							})
							return false;
						}
					})
				}
			},
			toIndex(){
				uni.showTabBar();
				uni.switchTab({
					url:'../index/index'
				})
			}
		},
		onShow() {
			uni.hideTabBar();
		}
	}
</script>

<style scoped>
@import url("../../static/css/login.css");
</style>
