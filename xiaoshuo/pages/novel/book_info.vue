<template>
	<view class="body">
		<view class="book_info">
			<view class="book_image">
				<image :src="novel_info.cover" mode=""></image>
				<view class="infomation">
					<text class="book_name">{{novel_info.title}}</text>
					<text class="editor">{{novel_info.editor}}</text>
					<text class="editor">发布时间{{novel_info.add_time}}</text>
					<!-- <text class="tags">{{novel_info.intro}}</text> -->
					<text class="size" v-if="novel_info.status==1">完结</text>
					<text class="size" v-else>连载中</text>
				</view>
				<navigator v-if="novel_info.start_novel_list" :url="'./book_cont?id='+novel_info.start_novel_list.id"
					class="read_now">立即阅读</navigator>
				<navigator v-if="novel_info.start_novel_list" url="#" class="comment" @click="toCover">加入书架</navigator>
				<navigator url="#" class="comment" @click="toComment">我要评价</navigator>
			</view>
		</view>
		<view class="book_intro">
			<text>{{novel_info.intro}}</text>
		</view>
		<view class="book_menuList" v-if="novel_info.end_novel_list">
			<navigator class="a" :url="'./book_title?id='+novel_info.id">
				<text>目录</text>
				<text>连载至{{novel_info.end_novel_list.title}}</text>
			</navigator>
		</view>
		<view class="reader_recom" v-if="comment_list.length>0">
			<view class="reader_title">
				<text>读者点评</text>
			</view>
			<view class="recom_item" v-for="(v,k) in comment_list" :key="k">
				<view class="reader">
					<image src="../../static/icons/user.png" mode="widthFix"></image>
					<text>{{v.user}}</text>
				</view>
				<view class="recom_content">
					<text>{{v.content}}</text>
					<view class="time">
						<text>{{v.add_time}}</text>
					</view>
				</view>
			</view>
			<!-- <view class="read_more">
				<navigator url="./history_comment">更多评价 >></navigator>
			</view> -->
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				id: '',
				novel_info: '',
				novel_page: 0,
				login: false,
				comment_list: {},
				user_id: 0,
			}
		},
		methods: {
			findData() {
				var _this = this;
				_this.$axios.get('/index/novel_info/id/' + _this.id).then((res) => {
					if (res.status == 'n') {
						uni.showModal({
							title: '提示',
							content: '提示11111'
						})
					} else {
						_this.novel_info = res.info;
						uni.setNavigationBarTitle({
							title: _this.novel_info.title
						});
					}
				})
			},
			check_login() {
				var _this = this;
				uni.getStorage({
					key: 'user',
					fail: () => {
						_this.login = false;
					},
					success: (res) => {
						_this.login = true;
						_this.user_id = res.data.user_id;
					}
				})
			},
			toComment() {
				if (this.login == true) {
					uni.navigateTo({
						url: '../index/user_comment?id='+this.id
					})
				} else {
					uni.showModal({
						title: '提示',
						content: '请先登录！',
						success: (res) => {
							if (res.confirm == true) {
								uni.switchTab({
									url: '../login/login'
								})
							} else {
								return false;
							}
						}
					})
				}
			},
			findComment() {
				var _this = this;
				this.$axios.get('/index/getComment/id/' + this.id).then((res) => {
					if (res.status == 'y') {
						_this.comment_list = res.info;
					} 
					// else {
					// 	uni.showModal({
					// 		title: '提示',
					// 		content: '提示提示提示提示2222',
					// 		showCancel: false,
					// 		complete: () => {
					// 			uni.navigateBack(-1)
					// 		}
					// 	})
					// }
				})
			},
			toCover(){
				if (this.login == true) {
					var _this = this;
					this.$axios.get('/index/cover_novel/user_id/'+this.user_id+'/novel_id/'+this.id).then((res)=>{
						uni.showModal({
							title:'提示',
							content:res.info,
							showCancel:false
						})
					});
				} else {
					uni.showModal({
						title: '提示',
						content: '请先登录！',
						success: (res) => {
							if (res.confirm == true) {
								uni.switchTab({
									url: '../login/login'
								})
							} else {
								return false;
							}
						}
					})
				}
			}
		},
		mounted() {
			this.findData();
			this.check_login();
			this.findComment();
		},
		onLoad(i) {
			if (i.id) {
				this.id = i.id;
			}
		}
	}
</script>

<style scoped>
	@import url("../../static/css/book_info.css");
</style>
