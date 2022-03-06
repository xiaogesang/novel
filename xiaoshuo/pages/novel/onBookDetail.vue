<template>
	<view>
		<!-- 顶部介绍盒子 -->
		<view class="book-back">
			<view>
				<!-- 作品名 -->
				<view class="name">{{detail.name}}</view>
				<view class="author">
				<!-- 作者 -->
				 <text>{{detail.author}}</text>
				 <image style="width: 18rpx;height: 18rpx;margin-left: 20rpx;" src="../../static/icons/arrow.png"></image>
				</view>
				<!-- 小说类型 -->
				<view class="type">{{detail.category}}·{{detail.status}}</view>
				<view class="type">最新章节：{{detail.latest_chapter_name}}</view>
				<view class="type" >更新时间：{{detail.update_time}}</view>
			</view>
			<!-- 小说图片 -->
			<view class="img-box">
				<image class="imgs" :src="detail.image"></image>
			</view>
		</view>
		<!-- 分割线 -->
		<view class="line"></view>
		<!-- 选项卡 -->
		<view style="width: 100%;">
			<!-- grow横向铺满  list是绑定的数组 change切换事件  listKey  lable字段-->
		  <mzy-tabs activeColor="#5a90e7" color="#333333" listKey="lable" :grow="true" :list="list" v-model="active" @change="handleChange"/>
		</view>
		<!-- 简介 -->
		<view class="info">
			<!-- 根据active的值划分面板 -->
			 <view v-if="active=='0'">
				 <view style="padding: 30rpx;" v-html="detail.des"></view>
				 <view class="charts">
					 <view>章节目录</view>
					 <view  @click="showDrawer" style="margin-left: 40rpx;font-size: 30rpx;color: #007AFF;">更多章节</view>
				 </view>
				 <!-- 简介章节目录 -->
				 <view class="charts-item">
					 <view  @click="toRead(item)" class="charts-items" v-for="(item,index) in charList" :key="index">
						 <view>{{item.name}}</view>
					 </view>
				 </view>
			 </view>
			 <view v-if="active=='1'">
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
			 </view>
		</view>
		<view class="buttom">
			<image @click="addCover" src="../../static/icons/shujia.png" style="width:50rpx;height: 50rpx;"></image>
			<view @click="setBookInfo" class="read">
				立即阅读
			</view>
			<view class="read">
				我要评论
			</view>
		</view>
		<!-- 右侧目录  -->
		<uni-drawer maskClick ref="showRight" mode="right" :mask-click="false">
		    <scroll-view style="height: 100%;background-color: #fffdf3;padding-left: 20rpx;" scroll-y="true">
		        <view @click="choose(item)" class="charts-items" v-for="item in allcharList" :key="item.index"> {{ item.name }}</view>
		    </scroll-view>
		</uni-drawer>
	</view>
</template>

<script>
	import {getChapters} from '../../api/index.js'
	export default {
		data() {
			return {
				active:'0',//切换选项卡下标
				detail:{},//小说详情数据对象
				list:[
					{lable:'详情',value:'0'},
					{lable:'评论',value:'1'},
				],
				charList:[],//简介章节目录的数组
				allcharList:[],//更多章节的数组
				userId:'',
				comment_list:{},
			}
		},
		onLoad(option) {
			
			var that = this
			uni.getStorage({
				key:'user',
				success: (res) => {
					that.userId = res.data.user_id
				}
			})
			uni.showLoading({
				title:'正在加载中...'
			})
			if(option.id){
				let formdate={
					id:option.id,
				}
				that.$axios.post('/index/getBookInfo',formdate).then((res)=>{
					that.detail = res.info
					console.log(that.detail,'我是接口请求的');
				});
				getChapters({bookId:option.id}).then(res=>{
					this.charList = res.result.slice(1,20)
					this.allcharList = res.result
					uni.hideLoading()
				})
				
			}else{
				//将全局变量赋值给details
				this.detail = getApp().globalData.details
				
				this.getChapters()
			}
			this.setBookInfo()
		},
		onShow() {
			uni.setNavigationBarTitle({
				title:this.detail.name
			})
			
		},
		methods: {
			getbookinfo(){
				
			},
			// 加入历史记录，然后跳转至小说阅读
			choose(item){
				let formdate={
					bookId:item.book,
					userId:this.userId,
					chartId:item.chaperIdx,
					image:this.detail.image,
					title:item.name,
					typename:'主线路',
					type:'0',//0主线路
				}
				this.$axios.get('/index/setHistory',formdate).then((res)=>{
					console.log(res);
				});
				uni.navigateTo({
					url:'onLineRead/onLineRead?id='+this.detail.id+'&chaperIdx='+item.chaperIdx
				})
			},
			// 显示右侧侧边栏（组件自带）
			showDrawer() {
			                this.$refs.showRight.open();
			            },
			// 关闭右侧侧边栏（组件自带）		
			closeDrawer() {
			                this.$refs.showRight.close();
			            },
			handleChange(index){
				console.log(index);
			},
			// 获取小说章节列表
			getChapters(){
				getChapters({bookId:this.detail.id}).then(res=>{
					this.charList = res.result.slice(1,20) //简介章节列表 slice函数截取数组第1位至20位
					this.allcharList = res.result //更多章节列表
					uni.hideLoading()
				})
			},
			toRead(item){
				let formdate={
					bookId:item.book,
					userId:this.userId,
					chartId:item.chaperIdx,
					image:this.detail.image,
					title:item.name,
					typename:'主线路',
					type:'0',//0主线路
				}
				this.$axios.get('/index/setHistory',formdate).then((res)=>{
					console.log(res);
				});
				uni.navigateTo({
					url:'onLineRead/onLineRead?id='+this.detail.id+'&chaperIdx='+item.chaperIdx
				})
			},
			setBookInfo(){
				this.$axios.post('/index/setBookInfo',this.detail).then((res)=>{
					console.log(res);
				});
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
			
			
			addCover(){
				console.log(this.userId,'5555');
							if(!this.userId){
								console.log('666666');
								uni.showModal({
									title: '提示',
									content: '请先登录！',
									success: (res) => {
										if (res.confirm == true) {
											uni.navigateTo({
												url:'../login/login'
											})
										} else {
											return false;
										}
									}
								})
								return false;
							}
							var data = {};
							data['bookid'] = this.detail.id;
							data['user_id'] = this.userId;
							data['name'] = this.detail.name;
							data['img'] = this.detail.image;
							data['author'] = this.detail.author;
							data['intro'] = this.detail.des;
							console.log(data);
							this.$axios.post('web_novel/add_cover',data).then((res)=>{
								// console.log(res);
								uni.showModal({
									title: '提示',
									content: res.info,
								})
							});
						},
						check_login() {
							uni.getStorage({
								key: 'user',
								success: (res) => {
									this.user_id = res.data.user_id;
									console.log('获取到了');
									console.log(this.user_id);
								},
								fail: (res) => {
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
							})
						}
		}
	}
</script>

<style>
@import url("onBookDetail.css");
.uni-page-head__title{
	color: #000000!important;
}
.reader_recom .reader_title{
	font-size: 16px;
	font-weight: 800;
	margin-bottom: 20px;
}
.recom_item{
	overflow: hidden;
	padding: 10px;
	border-bottom: #e0e0e0 1px solid;
}
.recom_item:last-child{
	border: none;
}
.recom_item .reader{
	width: 50px;
	float: left;
	overflow: hidden;
}
.reader image{
	width: 50px;
	height: 50px;
	display: block;
	margin: auto;
}
.reader text{
	font-size: 12px;
	text-align: center;
	display: block;
	width: 100%;
}
.recom_content{
	width: calc(100% - 80px);
	float: right;
}
.time{
	overflow: hidden;
}
.time text{
	float: right;
	font-size: 14px;
	color: #999;
	line-height: 1.6rem;
}
.editor,.size{
	margin-top: 1px;
}
</style>
