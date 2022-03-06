<template>
	<view>
		<view v-for="item in list" :key="item.Id"  class="content">
			<view @click="toDetail(item)">
				<view>
					<image style="width: 160rpx;height: 200rpx;position: relative;" :src="item.image"></image>
					<view style="position: absolute;bottom: 20rpx;color: #D17846;">小说来源:{{item.typename}}</view>
				</view>
				
			</view>
			<view class="item">
				<view>{{item.title}}</view>
				<view class="time">阅读时间:{{item.add_time}}</view>
			</view>
			<view class="toread" @click="toread(item)">继续阅读</view>
			
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				userId:'',
				list:[],
			}
		},
		onShow() {
			var that = this
			uni.getStorage({
				key:'user',
				success: (res) => {
					that.userId = res.data.user_id
				}
			})
			this.history()
		},
		methods: {
			toDetail(item){
				uni.navigateTo({
					url:'../novel/onBookDetail?id=' + item.bookId
				})
			},
			history(){
				let formdate = {
					userId:this.userId,
				}
				this.$axios.get('/index/gethistroylist',formdate).then((res)=>{
					this.list = res.info
				});
			},
			toread(item){
				console.log(item);
				uni.navigateTo({
					url:'../novel/onLineRead/onLineRead?id='+item.bookId+'&chaperIdx='+item.chartId,
				})
			}
		}
	}
</script>

<style>
.toread{
	position: absolute;
	right: 20rpx;
	bottom: 30rpx;
	border: 2rpx solid #d17846;
	padding: 10rpx 40rpx;
	border-radius: 20rpx;
}
.content{
	position: relative;
	padding: 32rpx;
	display: flex;
	border-bottom: 2rpx solid #E5E5E5;
	padding-bottom: 80rpx;
}
.time{
	margin-top: 30rpx;
}
.item{
	padding: 32rpx;
}
page{
	 background-color: #FFFFFF;
	
	/* background-color: #000000; */
}
</style>
