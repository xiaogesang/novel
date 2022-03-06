<template>
	<view  :style="{pointerEvents:point}">
		<view class="tabbar" style="">
			<image @click="back" src="../../../static/icons/arrow_left_01.png" style="width: 30rpx;height: 50rpx;" ></image>
			<view style="color: #987277;margin-left: 20rpx;">({{name}})</view>
		</view>
		
		<view :style="{fontSize:fontsize+'px',lineHeight:lineheight+'px',backgroundColor:backcolor}" @touchstart="touchStart" @touchend="touchEnd"  class="parse" v-html="deatail"></view>
		<view @click="toTop" style="position: fixed;right: 20rpx;bottom: 120rpx;">
			<image  style="width: 80rpx;height: 80rpx;" src="../../../static/icons/top.png"></image>
		</view>
		<view @click="center" class="center-box"></view>
		<uni-popup  ref="popup" type="bottom">
			<view class="buttom-meun">
				<view class="buttom-meun-item">
					<view class="font">
						<view>字体</view>
						<view @click="setFontsize('16')" class="fonts">16</view>
						<view  @click="setFontsize('24')" class="fonts">24</view>
						<view  @click="setFontsize('32')" class="fonts">32</view>
					</view>
					
					<view class="space">
						<view>间距</view>
						<view @click="setsapce('24')" class="fonts">24</view>
						<view @click="setsapce('48')" class="fonts">48</view>
						<view @click="setsapce('60')" class="fonts">60</view>
					</view>
				</view>
				<view class="back">
					<view class="space" style="margin-left: 25rpx;">
						<view>背景色</view>
						<view @click="setback('#eec5cb')" style="background-color: #eec5cb;margin-left: 20rpx;" class="color-box"></view>
						<view @click="setback('#f8e6c0')" style="background-color: #f8e6c0;margin-left: 20rpx;" class="color-box"></view>
						<view @click="setback('#f7f7f7')" style="background-color: #f7f7f7;margin-left: 20rpx;" class="color-box"></view>
					</view>
				</view>
				<view class="mean">
					<view @click="showDrawer" style="text-align: center;">
						<image class="mean-img" src="../../../static/icons/list.png"></image>
						<view>目录</view>
					</view>
					<view @click="toNight" style="text-align: center;">
						<image class="mean-img" src="../../../static/icons/night.png"></image>
						<view>夜间</view>
					</view>
					<view @click="toDay" style="text-align: center;">
						<image class="mean-img" src="../../../static/icons/day.png"></image>
						<view>日间</view>
					</view>
					
				</view>
			</view>
		</uni-popup>
		<uni-drawer maskClick ref="showRight" mode="right" :mask-click="false">
		    <scroll-view style="height: 100%;background-color: #fffdf3;padding-left: 20rpx;" scroll-y="true">
		        <view @click="choose(item)" class="charts-items" v-for="item in allcharList" :key="item.index"> {{ item.name }}</view>
		    </scroll-view>
		</uni-drawer>
		<view>
				<u-toast ref="uToast" />
			</view>
	</view>
</template>

<script>
	import {getChaptersDetail,getChapters} from '../../../api/index.js'
	import mpHtml from '../../../components/mp-html/components/mp-html/mp-html.vue'
	
	export default {
		components: {
		 mpHtml
		},
		data() {
			return {
				allcharList:[],
				lineheight:'40',
				fontsize:'16',
				backcolor:'#eec5cb',
				fonst:'',
				point:'',
				font:'',
				id:'',
				index:'',
				deatail:'',
				name:'',
				 touchStartX: 0,  // 触屏起始点x  
				touchStartY: 0,  // 触屏起始点y  
			}
		},
		onLoad(option) {
			console.log(option);
			this.id = option.id
			this.index = option.chaperIdx
		},
		onShow() {
			this.getChaptersDetail()
			this.getChapters()
			
		},
		onReady() {
			this.$refs.uToast.show({
				title: '点击屏幕中间可呼出底部菜单，点击遮罩层可关闭，左/右滑动可进入上/下一章，滑到底部可进入下一章',
				// 如果不传此type参数，默认为default，也可以手动写上 type: 'default'
				type: 'warning ', 
				// 如果不需要图标，请设置为false
				// icon: false
				duration:7000
			})
		},
		onReachBottom() {
			this.point = 'none'
			uni.showLoading({
				title:'正在加载下一页'
			})
			this.index++
			console.log('触底了');
			this.getChaptersDetail()
			uni.pageScrollTo({
			    scrollTop: 0,
			    duration: 0
			});
		},
		methods: {
			toNight(){
				this.backcolor = '#343434'
			},
			toDay(){
				this.backcolor = '#eec5cb'
			},
			choose(item){
				this.index = item.chaperIdx
				this.getChaptersDetail()
				 this.$refs.showRight.close();
				 this.$refs.popup.close('top')
			},
			showDrawer() {
			                this.$refs.showRight.open();
			            },
			getChapters(){
				getChapters({bookId:this.id}).then(res=>{
					this.allcharList = res.result
				})
			},
			setback(color){
				this.backcolor = color
			},
			setsapce(space){
				this.lineheight = space
				},
			setFontsize(size){
				this.fontsize = size
			},
			// 页面中心点击区域
			center(){
				this.$refs.popup.open('top') //调起底部菜单栏
			},
			toTop(){
				uni.pageScrollTo({
				    scrollTop: 0,
				    duration: 0
				});
			},
			back(){
				console.log('wwwwww');
				uni.navigateBack({
					delta:1
				})
			},
			// 获取章节内容  bookid小说ID  chapterId  章节ID
			getChaptersDetail(){
				getChaptersDetail({bookId:this.id,chapterId:this.index}).then(res=>{
					this.deatail = res.result[1].content
					this.name = res.result[1].name
					uni.hideLoading()
					this.point = ''
				})
			},
			 touchEnd(e) {  
			                console.log("触摸结束")  
			                let deltaX = e.changedTouches[0].clientX - this.touchStartX;  
			                let deltaY = e.changedTouches[0].clientY - this.touchStartY;  
			                if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > Math.abs(deltaY)) {  
			                    if (deltaX >= 0) {  
			                        this.index--
									this.getChaptersDetail()
									this.toTop()
			                    } else {  
			                        this.index++
			                        this.getChaptersDetail()
			                        this.toTop()
			                    }  
			                } else if(Math.abs(deltaY) > 50&& Math.abs(deltaX) < Math.abs(deltaY)) {  
			                    if (deltaY < 0) {  
			                        console.log("上滑")  
			                    } else {  
			                        console.log("下滑")  
			                    }  
			                } else {  
			                    console.log("点击而已！")  
			                }  
			            },    
			 touchStart(e) {  
			                console.log("触摸开始")  
			                this.touchStartX = e.touches[0].clientX;  
			                this.touchStartY = e.touches[0].clientY;  
			            },  
		}
	}
</script>

<style>
	.mean-img{
		width: 60rpx;
		height: 60rpx;
	}
	.mean{
		display: flex;
		justify-content: space-around;
		align-items: center;
		margin-top: 60rpx;
	}
	.color-box{
		width: 100rpx;
		height: 60rpx;
		border-radius: 10rpx;
		background-color: #1296DB;
		text-align: center;
		line-height: 60rpx;
		
	}
	.buttom-meun-item{
		margin-top: 20rpx;
		display: flex;
		align-items: center;
		justify-content: space-around;
	}
	
	.space{
		display: flex;
		align-items: center;
		margin-left: 20rpx;
	}
	.fonts{
		width: 60rpx;
		height: 60rpx;
		border-radius: 30rpx;
		background-color: #eec5cb;
		color: white;
		text-align: center;
		line-height: 60rpx;
		margin-left: 25rpx;
	}
	.font{
		display: flex;
		align-items: center;
	}
	.meun-item{
		display: flex;
		margin-top: 60rpx;
	}
	.tabbar{
		display: flex;align-items: center;background-color: #f6dcdf;height: 40px;padding-left: 20rpx;
		position: sticky;
		top: 0rpx;
		width: 100%;
	}
.parse{
	white-space: pre-line;
	background-color: #eed2db;
	font-size: 32rpx;
	line-height: 80rpx;
	padding: 20rpx;
	color: #835e63;
	pointer-events: ;
}
.center-box{
	background-color: unset;
	width: 600rpx;
	height: 800rpx;
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
}
.buttom-meun{
	height: 400rpx;
	background-color: #f6dcdf;
	padding-top: 10rpx;
}
.back{
	margin-top: 40rpx;
}
.charts-items{
	border-bottom: 2rpx solid  #f1f1f1;
	padding-bottom: 20rpx;
	padding-top: 20rpx;
}
</style>
