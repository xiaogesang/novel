<template>
	<view class="body">
		<view class="form">
			<view class="title">
				<text>修改密码</text>
			</view>
			<view class="form_item">
				<input type="password" placeholder="在此输入旧密码" v-model="posts.old_password">
			</view>
			<view class="form_item">
				<input type="password" placeholder="输入新密码" v-model="posts.new_password">
			</view>
			<view class="form_item">
				<input type="password" placeholder="再次输入新密码" v-model="posts.new_password2">
			</view>
			<view class="form_item no_border">
				<button @click="submit">保存</button>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				posts:{
					old_password: '',
					new_password: '',
					new_password2: '',
					user_id: 0,
				}
			}
		},
		methods: {
			submit(){
				uni.showLoading();
				if(!this.posts.old_password||this.posts.old_password.length<6||this.posts.new_password.length<6||!this.posts.new_password||this.posts.new_password2.length<6||!this.posts.new_password2){
					uni.showModal({
						title:'提示',
						content: '密码格式有误',
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
					this.$axios.post('/user/update',formData).then((res)=>{
						if(res.status=='y'){
							uni.showModal({
								title:'提示',
								content:'修改成功！',
								showCancel:false,
								complete: () => {
									uni.switchTab({
										url:'./center'
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
		},
		onShow() {
			var _this = this;
			uni.getStorage({
				key:'user',
				success: (res) => {
					_this.posts.user_id = res.data.user_id;
				},
				fail: () => {
					uni.showModal({
						title:'提示',
						content:'请先登录！',
						showCancel:false,
						complete: () => {
							uni.switchTab({
								url:'../login/login'
							})
						}
					})
				}
			})
		}
	}
</script>

<style scoped>
@import url("../../static/css/login.css");
</style>
