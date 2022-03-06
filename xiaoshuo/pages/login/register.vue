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
				<input type="password" placeholder="在此输入六位以上密码" v-model="posts.password">
			</view>
			<view class="form_item">
				<input type="password" placeholder="再次输入密码" v-model="posts.password2">
			</view>
			<view class="form_item no_border">
				<button @click="submit">立即注册</button>
			</view>
			<view class="navicate">
				<navigator url="#" @click="toLogin">返回登录</navigator>
				<!-- <navigator url="">忘记密码</navigator> -->
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
					password: '',
					password2: ''
				}
			}
		},
		methods: {
			submit(){
				uni.showLoading();
				if(!this.posts.phone||!this.posts.password||!this.posts.password2||this.posts.password.length<6||this.posts.password2.length<6||this.posts.phone.length<11){
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
					this.$axios.post('/login/register',formData).then((res)=>{
						if(res.status=='y'){
							uni.showModal({
								title:'提示',
								content:'注册成功！',
								showCancel:false,
								complete: () => {
									uni.setStorage({
										key:'user',
										data:{
											user_id: res.info
										},
										success: () => {
											uni.hideLoading();
											uni.navigateTo({
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
			toLogin(){
				uni.switchTab({
					url:'../login/login'
				})
			}
		}
	}
</script>

<style scoped>
@import url("../../static/css/login.css");
</style>
