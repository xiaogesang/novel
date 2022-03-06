<template>
	<view class="body">
		<view class="cover_list">
			<view class="cover_item" v-for="(v,k) in cover_list" :key="k">
				<navigator :url="'../novel/book_info?id='+v.id" class="book_title">
					<image :src="v.cover" mode=""></image>
					<view class="book_info">
						<text class="title">{{v.title}}</text>
						<text class="intro">{{v.intro}}</text>
					</view>
				</navigator>
				<view class="item_btn">
					<text @click="remove_cover(v.cover_id,v.status)">移出书架</text>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				user_id: 0,
				cover_list: {},
			}
		},
		methods: {
			findData() {
				var _this = this;
				this.$axios.get('/index/findUserCover/user_id/' + this.user_id).then((res) => {
					if (res.status != 'y') {
						uni.showModal({
							title: '提示',
							content: res.info,
							showCancel: false,
							complete: () => {
								uni.switchTab({
									url: '../index/index'
								})
							}
						})
					} else {
						_this.cover_list = res.info;
						console.log('6666666');
					}
				});
			},
			remove_cover(i,status){
				if(this.user_id<1){
					uni.showModal({
						title: '提示',
						content: '请先登录！',
						showCancel: false,
						complete: () => {
							uni.switchTab({
								url: '../login/login'
							})
						}
					})
				}
				else{
					var _this = this;
					this.$axios.get('/index/remove_cover/user_id/'+this.user_id+'/cover_id/'+i+'/status/'+status).then((res)=>{
						if(res.status!='y'){
							uni.showModal({
								title:'提示',
								content: res.info,
								showCancel:false
							})
							return false;
						}
						else{
							uni.showModal({
								title:'提示',
								content: res.info,
								showCancel:false,
								complete: () => {
									_this.findData();
								}
							})
						}
					});
				}
			}
		},
		mounted() {
			var _this = this;
			uni.getStorage({
				key: 'user',
				success: (res) => {
					_this.user_id = res.data.user_id;
					_this.findData();
				},
				fail: () => {
					uni.showModal({
						title: '提示',
						content: '请先登录！',
						showCancel: false,
						complete: () => {
							uni.switchTab({
								url: '../login/login'
							})
						}
					})
				}
			})
		}
	}
</script>

<style scoped>
	@import url("../../static/css/user_cover.css");
</style>
