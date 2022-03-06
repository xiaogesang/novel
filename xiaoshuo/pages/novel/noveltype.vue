<template>
	<view>
		<view class="choose-type">
			<view @click="searchType(item,index)" :class="{check:index== chooseIndex}" v-for="(item,index) in typeList" :key="item.index" class="item">{{item.title}}</view>
		</view>
		<u-waterfall ref="uWaterfall" v-model="flowList">
			<template v-slot:left="{leftList}">
				<view v-for="(item, index) in leftList" :key="index">
					<view  @click="toDetail(item)">
						<view class="item-box">
							<u-lazy-load threshold="-450" height="320" border-radius="20" :image="item.image" :index="index"></u-lazy-load>
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
							<u-lazy-load threshold="-450" height="320" border-radius="20" :image="item.image" :index="index"></u-lazy-load>
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
	import {getBookList} from '../../api/index.js'
	export default {
		data() {
			return {
				page:1,
				category:'1',
				chooseIndex:'0',
				typeList:[
					{title:'玄幻小说',value:'1'},
					{title:'修仙小说',value:'2'},
					{title:'都市小说',value:'3'},
					{title:'穿越小说',value:'4'},
					{title:'网游小说',value:'5'},
					{title:'穿越小说',value:'6'},
					{title:'其他小说',value:'8'},
				],
				flowList:[],
			}
		},
		onShow() {
			this.getBookLists()
		},
		onReachBottom() {
			this.page++
			this.getBookLists()
		},
		methods: {
			searchType(item,index){
				this.$refs.uWaterfall.clear();
				this.chooseIndex = index
				this.category = item.value
				this.page = 1
				this.getBookLists()
			},
			getBookLists(){
				getBookList({page:this.page,category:this.category}).then(res=>{
					this.flowList = this.flowList.concat(res.result) 
				})
			},
			toDetail(item){
				getApp().globalData.details = item
				uni.navigateTo({
					url:'../novel/onBookDetail'
				})
				
			},
		}
	}
</script>

<style>
	.item-box{
		padding: 32rpx;
	}
	.cover-img{
		width: 280rpx;
		height: 320rpx;
	}
	.choose-type{
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-start;
	}
.item{
	width: ;
	font-size: 36rpx;
	background-color: #F5F5F5;
	padding: 10rpx 40rpx;
	border-radius: 40rpx;
	margin-top: 20rpx;
	margin-left: 20rpx;
	border: 2rpx solid #E5E5E5;
}
.check{
	border: 2rpx solid #d7b92f!important;
	color:#d7b92f ;
}
</style>
