<template>
	<view class="body">
		<view class="form">
			<textarea placeholder="在此留下您宝贵的意见吧~" class="textarea" v-model="form" maxlength="200"></textarea>
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
			submit(){
				if(!this.form||this.form.length<6){
					uni.showModal({
						title:'提示',
						content:'请填写最少6个字符的内容哦~',
						showCancel:false,
					})
					return false;
				}
				else{
					var formData = {};
					formData['user_id'] = this.user_id;
					formData['content'] = this.form;
					var _this = this;
					this.$axios.post('/index/feedback',formData).then((res)=>{
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
		onShow() {
			this.check_login();
		}
	}
</script>

<style scoped>
@import url("../../static/css/user_comment.css");
.form{
	margin-top: 40px;
}
</style>
