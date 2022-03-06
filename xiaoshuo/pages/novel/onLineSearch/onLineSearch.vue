<template>
	<view>
		<view>
				<u-toast ref="uToast" />
			</view>
		<view class="search-xob">
			<input @input="clear"  placeholder="请输入要搜索的小说" v-model="keyword" class="input-search" />
			<view @click="search()" class="search-buttom">搜索</view>
		</view>
		<u-waterfall ref="uWaterfall" v-model="flowList">
			<template v-slot:left="{leftList}">
				<view v-for="(item, index) in leftList" :key="index">
					<view  @click="toDetail(item)">
						<view class="item-box">
							<u-lazy-load threshold="-450" height="400" border-radius="10" :image="item.image" :index="index"></u-lazy-load>
							<view>{{item.name}}</view>
							<view><text>作者：{{item.author}}</text></view>
						</view>
					</view>
				</view>
			</template>
			<template v-slot:right="{rightList}">
				<view v-for="(item, index) in rightList" :key="index">
					<view class="item-box">
						<view  @click="toDetail(item)">
							<u-lazy-load threshold="-450" height="400" border-radius="10" :image="item.image" :index="index"></u-lazy-load>
							<view>{{item.name}}</view>
							<view>
							<text>作者：{{item.author}}</text>
							</view>
						</view>
					</view>
				</view>
			</template>
		</u-waterfall>
	</view>
</template>

<script>
	import {search} from '../../../api/index.js'
	export default {
		data() {
			return {
				keyword:'',
				flowList:[]
			}
		},
		onShow() {
			
		},
		onReady() {
			this.search()
		},
		methods: {
			clear(){
				if(!this.keyword){
					this.search()
				}
			},
			search(){
				this.$refs.uWaterfall.clear();
				if(!this.keyword){
					
					this.$refs.uToast.show({
						title: '书名为空则搜索全小说',
						type: 'warning ', 
					})
				}
				search({keywords:this.keyword,size:'100'}).then(res=>{
					this.flowList = res.result
				})
			},
			toDetail(item){
				getApp().globalData.details = item
				uni.navigateTo({
					url:'../onBookDetail'
				})
				
			},
		}
	}
</script>

<style>
.item-box{
		padding: 32rpx;
	}
.search-buttom{
	position: absolute;
	text-align: center;
	height:88rpx ;
	padding: 0rpx 20rpx;
	line-height: 80rpx;
	text-align: center;
	background-color: #989db8;
	right: 32rpx;
	z-index: 999;
	
}	
.search-xob{
	padding: 32rpx;
	display: flex;
	height: 160rpx;
	
}
.input-search{
	position: relative;
	flex: 1;
	border: 1px solid #5e5e5e;
	padding: 20rpx 0rpx 20rpx 20rpx;
	height: 40rpx;
	border-radius: 10rpx;
	background-color: #F7F7F7;
}
</style>
