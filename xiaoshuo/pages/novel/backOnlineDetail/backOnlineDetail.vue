<template>
	<view>
		<!-- 顶部介绍盒子 -->
		<view class="book-back">
			<view>
				<!-- 作品名 -->
				<view class="name">{{detail.title}}</view>
				<view class="author">
				<!-- 作者 -->
				 <text>{{detail.author}}</text>
				 <image style="width: 18rpx;height: 18rpx;margin-left: 20rpx;" src="../../../static/icons/arrow.png"></image>
				</view>
				<!-- 小说类型 -->
				<view class="type">{{detail.tag}}·{{detail.serialize_text}}</view>
				<view class="type">最新章节：{{detail.chapter_title}}</view>
			</view>
			<!-- 小说图片 -->
			<view class="img-box">
				<image class="imgs" :src="detail.pic"></image>
			</view>
		</view>
		<!-- 分割线 -->
		<view class="line"></view>
		<!-- 选项卡 -->
		<view style="width: 100%;">
		  <mzy-tabs activeColor="#5a90e7" color="#333333" listKey="lable" :grow="true" :list="list" v-model="active" @change="handleChange"/>
		</view>
		<!-- 简介 -->
		<view class="info">
			 <view v-if="active=='0'">
				 <view style="padding: 30rpx;" v-html="detail.content"></view>
				 <view class="charts">
					 <view>章节目录</view>
					 <view  @click="showDrawer" style="margin-left: 40rpx;font-size: 30rpx;color: #007AFF;">更多章节</view>
				 </view>
				 <view class="charts-item">
					 <view  @click="toRead(item)" class="charts-items" v-for="(item,index) in charList" :key="index">
						 <view>{{item.title}}</view>
					 </view>
				 </view>
			 </view>
			 <view v-if="active=='1'">
				 
			 </view>
		</view>
		<view class="buttom">
			<image src="../../../static/icons/shujia.png" style="width:50rpx;height: 50rpx;"></image>
			<view @click="setBookInfo" class="read">
				立即阅读
			</view>
		</view>
		<!-- 右侧目录 -->
		<uni-drawer maskClick ref="showRight" mode="right" :mask-click="false">
		    <scroll-view style="position: relative;height: 100%;background-color: #fffdf3;padding-left: 20rpx;" scroll-y="true">
		        <view @click="toRead(item)" class="charts-items" v-for="item in allcharList" :key="item.index"> {{ item.title }}</view>
				<view class="prebottom" style="display: flex;">
					<view @click="pre" class="pre">上一页</view>
					<view @click="next" class="pre">下一页</view>
				</view>
			</scroll-view>
		</uni-drawer>
	</view>
</template>

<script>
	import {getBackDetail,getBackCharts} from '../../../api/index.js'
	export default {
		data() {
			return {
				active:'0',
				page:'1',
				detail:{
					
				},
				list:[
					{lable:'详情',value:'0'},
					{lable:'评论',value:'1'}
				],
				charList:[],
				allcharList:[],
				id:'',
				userId:'',
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
			this.id = option.id
			
		},
		onShow() {
			this.getDetai()
			this.getBackCharts()
		},
		methods: {
			toRead(item){
				let formdate={
					bookId:this.id,
					userId:this.userId,
					chartId:item.id,
					image:this.detail.pic,
					title:item.title,
					typename:'备用线路',
					type:'1',//1备用
				}
				this.$axios.get('/index/setHistory',formdate).then((res)=>{
					console.log(res);
				});
				uni.navigateTo({
					url:'../onLineRead/onLineReadBack?id='+this.id+'&key='+item.id
				})
			},
			getDetai(){
				getBackDetail(
				{
					id:this.id,
					page:'1',
					page_size:'10'
				}
				).then(res=>{
					this.detail = res.data
					this.detail.title =res.data.title
				})
			},
			getBackCharts(){
				getBackCharts(
				{
					id:this.id,
					page:this.page,
					page_size:'20'
				}).then(res=>{
					this.charList = res.data.data
					this.allcharList = res.data.data
					console.log(res);
				})
			},
			next(){
				this.page++
				getBackCharts(
				
				{
					id:this.id,
					page:this.page,
					page_size:'20'
				}).then(res=>{
					this.allcharList = res.data.data
					
				})
			},
			pre(){
				if(this.page==1){
					return
				}
				this.page--
				getBackCharts(
				{
					id:this.id,
					page:this.page,
					page_size:'50'
				}).then(res=>{
					this.charList = res.data.data
					console.log(res);
				})
			},
			
			showDrawer() {
			                this.$refs.showRight.open();
			            },
			closeDrawer() {
			                this.$refs.showRight.close();
			            },
		}
	}
</script>

<style>
@import url("backOnlineDetail.css");
.prebottom{
	position: absolute;
	bottom: 0rpx;
	justify-content: space-around;
	width: 100%;
	background-color: #DCDFE6;
}
.pre{
	padding: 20rpx 10rpx;
	
}
.uni-page-head__title{
	color: #000000!important;
}
</style>
