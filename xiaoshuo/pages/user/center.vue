<template>
	<view class="body">
		<view class="header">
			<text class="nick_name">用户：{{phone}}</text>
		</view>
		<view class="navs">
			<navigator class="navs_item" url="./user_cover">
				<text>我的书架</text>
				<uni-icons type="arrowright" size="16"></uni-icons>
			</navigator>
			<navigator class="navs_item" url="./feedback">
				<text>我要反馈</text>
				<uni-icons type="arrowright" size="16"></uni-icons>
			</navigator>
			<navigator class="navs_item" url="./history">
				<text>阅读记录</text>
				<uni-icons type="arrowright" size="16"></uni-icons>
			</navigator>
			<navigator class="navs_item" url="./update">
				<text >修改密码</text>
				<uni-icons type="arrowright" size="16"></uni-icons>
			</navigator>
			<navigator class="navs_item logout" url="#" @click="logout">
				<text>退出登录</text>
				<uni-icons type="arrowright" size="16"></uni-icons>
			</navigator>
			
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				phone:'',
			}
		},
		onLoad(res) {
			this.phone = res.phone
		},
		
		methods: {
			change(){
				console.log('7777');
				uni.setTabBarItem({
					index: 2,
					text: '我的',
					pagePath: '/pages/user/center'
				})
			},
			logout() {
				uni.showModal({
					title: '提示',
					content: '确认退出？',
					success: (res) => {
						if (res.confirm == true) {
							uni.removeStorage({
								key: 'user',
								success: () => {
									uni.setTabBarItem({
										index: 2,
										text: '登录',
										pagePath: '/pages/login/login'
									})
									uni.switchTab({
										url:'../login/login'
									})
								}
							})
						} else {
							return false;
						}
					}
				})
			},
			check_login() {
				var _this = this;
				uni.getStorage({
					key: 'user',
					success: (res) => {
						console.log(res);
						_this.user_login = true;
						uni.setTabBarItem({
							index: 2,
							text: '我的',
							pagePath: '/pages/user/center'
						})
					},
					fail: () => {
						console.log('没获取到了参数');
						_this.user_login = false;
						uni.setTabBarItem({
							index: 2,
							text: '登录',
							pagePath: '/pages/login/login'
						})
					},
					complete: () => {
						uni.showTabBar()
					}
				})
			},
		},
		onShow() {
			var that = this
			this.check_login();
			uni.getStorage({
				key:'user',
				success: (res) => {
					that.phone = res.data.phone
				}
			})
		},
		
	}
</script>

<style scoped>
	@import url("../../static/css/center.css");
</style>
