<template>
	<view>
		<view class="time">当前排行更新时间：{{time}}</view>
		<u-waterfall ref="uWaterfall" v-model="flowList">
			<template v-slot:left="{leftList}">
				<view v-for="(item, index) in leftList" :key="index">
					<view  >
						<view class="item-box">
							<u-lazy-load threshold="-450" height="400" border-radius="10" :image="newimg(item.cover)" :index="index"></u-lazy-load>
							<view>{{item.title}}</view>
							<view><text>作者：{{item.author}}</text></view>
						</view>
					</view>
				</view>
			</template>
			<template v-slot:right="{rightList}">
				<view v-for="(item, index) in rightList" :key="index">
					<view class="item-box">
						<view  >
							<u-lazy-load threshold="-450" height="400" border-radius="10" :image="newimg(item.cover)" :index="index"></u-lazy-load>
							<view>{{item.title}}</view>
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
	import {hotList} from '../../api/index.js'
	export default {
		data() {
			return {
				time:'',
				list:[],
				flowList:[],
			}
		},
		onShow() {
			this.gettime()
		},
		methods: {
			newimg(s){
				
				let a =  decodeURIComponent(s.replace("/agent/",""));
				// return decodeURIComponent(a)
				return a
			},
			gettime(){
				hotList({page:'1',size:'10'}).then(res=>{
					console.log(res);
					this.flowList = res.ranking.books
					this.time =res.ranking.updated
				})
			}
		}
	}
</script>

<style>
.time{
	padding: 32rpx;
}
.item-box{
		padding: 32rpx;
	}
</style>
