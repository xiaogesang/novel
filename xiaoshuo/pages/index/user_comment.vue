<template>
	<view class="body">
		<view class="novel_info">
			<image :src="novel.cover" mode=""></image>
			<view class="book_info">
				<text class="title">{{novel.title}}</text>
				<text class="intro">{{novel.intro}}</text>
			</view>
		</view>
		<view class="form">
			<textarea placeholder="在此留下您宝贵的评价吧~" class="textarea" v-model="form" maxlength="150"></textarea>
			<button @click="submit">提交</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				id: 0,
				user_id: 0,
				novel: {},
				form: '',
			}
		},
		methods: {
			check_login() {
				var _this = this;
				uni.getStorage({
					key: 'user',
					fail: () => {
						uni.showModal({
							title:'提示',
							content:'请先登录！',
							success: (res) => {
								if(res.confirm == true){
									uni.switchTab({
										url:'../login/login'
									})
								}
								else{
									uni.navigateBack(-1);
								}
							}
						})
					},
					success: (res) => {
						_this.user_id = res.data.user_id;
					}
				})
			},
			findData(){
				var _this = this;
				_this.$axios.get('/index/novel_info/id/' + _this.id).then((res) => {
					if (res.status == 'n') {
						uni.showModal({
							title: '提示',
							content: res.info
						})
					} else {
						_this.novel = res.info;
					}
				})
			},
			submit(){
				if(!this.form||this.form.length<6){
					uni.showModal({
						title:'提示',
						content:'请填写最少6个字符的评价哦~',
						showCancel:false,
					})
					return false;
				}
				else{
					var formData = {};
					formData['user_id'] = this.user_id;
					formData['novel_id'] = this.id;
					formData['comment'] = this.form;
					var _this = this;
					this.$axios.post('/index/user_comment',formData).then((res)=>{
						if(res.status!='y'){
							uni.showModal({
								title:'提示',
								content:res.info,
								showCancel:false,
							})
							return false;
						}
						else{
							uni.showModal({
								title:'提示',
								content:res.info,
								showCancel:false,
								complete: () => {
									uni.navigateBack(-1);
								}
							})
						}
					})
				}
			}
		},
		mounted(){
			this.findData();
		},
		onLoad(i) {
			if(i.id>0){
				this.id = i.id;
				this.check_login();
			}
			else{
				uni.showModal({
					title:'提示',
					content:'网络异常，请重试！',
					showCancel:false,
					complete: () => {
						uni.navigateBack(-1);
					}
				})
				return false;
			}
		}
	}
</script>

<style scoped>
@import url("../../static/css/user_comment.css");
</style>
