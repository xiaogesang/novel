<template>
	<view class="vue_body">
		<view class="header">
			
			<view class="logo">
				<navigator url="#">
					<text>七点中文网</text>
				</navigator>
				
			</view>
			<!-- <view @click="change">切换线路</view> -->
			
				
		
			<image @click="change" src="../../static/icons/change.png" style="width: 60rpx;height: 60rpx;padding-top: 10rpx;padding-left: 40rpx;"></image>
			<view class="login">
				<navigator url="#" @click="toLogin" v-if="user_login==false">
					<uni-icons type="contact" color="#1296DB" size="28"></uni-icons>
				</navigator>
				<navigator url="../user/center" v-else @click="toCenter">
					<uni-icons type="contact" color="#1296DB" size="28"></uni-icons>
				</navigator>
				<navigator url="#" @click="toCover">
					<uni-icons type="shop" color="#1296DB" size="28"></uni-icons>
				</navigator>
			</view>
		</view>
		<view class="banner">
			<swiper :indicator-dots="true" indicator-color="#FFFFFF" indicator-active-color="#ed424b" :autoplay="true" :interval="3000" :duration="1000">
				<swiper-item v-for="(v,k) in banner" :key="k">
					<view class="swiper-item">
						<navigator :url="'../novel/book_info?id='+v.nid">
							<image :src="v.imgs" mode=""></image>
						</navigator>
					</view>
				</swiper-item>
			</swiper>
		</view>
		
		<view class="search">
			<navigator url="./search">
				<uni-icons type="search" size="18" color="#999999"></uni-icons>
				<text>在此搜索您感兴趣的内容</text>
			</navigator>
		</view>
		<view class="local">本地小说</view>
		<view class="icons">
			<view class="icons_item">
				<navigator url="#" @click="toType">
					<uni-icons type="list" size="32" color="#1296Db"></uni-icons>
					<text>分类</text>
				</navigator>
			</view>
			<view class="icons_item">
				<navigator url="./rank">
					<uni-icons type="star" size="32" color="#ff4155"></uni-icons>
					<text>排行版</text>
				</navigator>
			</view>
			<view class="icons_item">
				<navigator url="./complete">
					<uni-icons type="map" size="32" color="#ffa500"></uni-icons>
					<text>完结</text>
				</navigator>
			</view>
			<view class="icons_item">
				<navigator url="./new_book">
					<uni-icons type="paperplane" size="32" color="#94ff19"></uni-icons>
					<text>新书</text>
				</navigator>
			</view>
		</view>
		<!-- <view class="book_list">
			<navigator :url="'../novel/book_info?id='+v.id" class="top_book" v-for="(v,k) in novel" :key="k" v-show="k<3">
				<image :src="v.cover" mode=""></image>
				<view class="book_info">
					<text class="book_title">{{v.title}}</text>
					<text class="book_intro">{{v.intro}}</text>
					<text class="book_intro">作者：{{v.editor}}</text>
				</view>
			</navigator>
			<navigator :url="'../novel/book_info?id='+v.id" class="books" v-for="(v,k) in novel" :key="k" v-if="k>=3&&novel.length>3">
				<text class="book_title">{{v.title}}</text>
				<text class="book_intro">{{v.intro}}</text>
				<text class="book_intro">作者：{{v.editor}}</text>
			</navigator>
		</view> -->
		<view @click="toType" class="online-text">在线小说</view>
		<view class="online">
			<view  class="online-icon">
				<view @click="toOnLineType">
					<image src="../../static/icons/分类.png" style="width: 70rpx;height: 70rpx;"></image>
				</view>
				<view>分类</view>
			</view>
			<navigator url="./onlineRank" class="online-icon">
				<view>
					<image src="../../static/icons/火.png" style="width: 70rpx;height: 70rpx;"></image>
				</view>
				<view>热搜榜</view>
			</navigator>
			<navigator url="onLineGood/onLineGood" class="online-icon">
				<view>
					<image src="../../static/icons/好评.png" style="width: 70rpx;height: 70rpx;"></image>
				</view>
				<view>好评榜</view>
			</navigator>
			<navigator url="../novel/onLineSearch/onLineSearch" class="online-icon">
				<view>
					<image src="../../static/icons/search.png" style="width: 70rpx;height: 70rpx;"></image>
				</view>
				<view>搜索</view>
			</navigator>
		</view>
		<view class="book_sendto">
			<view class="model_title">
				<text>为您推荐</text>
			</view>
			<!-- 启动正式版本 -->
			<view v-if="back==false">
				<view class="titles">玄幻小说</view>
				<view class="books-item" >
					<view @click="toDetail(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in xuanhuanList" :key="item.id">
						<image  class="cover-img" :src="item.image"></image>
						<view>{{item.name}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">修仙小说</view>
				<view class="books-item">
					<view @click="toDetail(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in xiuxianList" :key="item.id">
						<image class="cover-img" :src="item.image" ></image>
						<view>{{item.name}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">都市小说</view>
				<view class="books-item"  >
					<view @click="toDetail(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in cityList" :key="item.id">
						<image  class="cover-img" :src="item.image" ></image>
						<view>{{item.name}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">穿越小说</view>
				<view  class="books-item" >
					<view @click="toDetail(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in crossList" :key="item.id">
						<image  class="cover-img" :src="item.image" ></image>
						<view>{{item.name}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
			</view>
			<!-- 启动正式版本 -->
			<!-- 启动备用版本 -->
			<view v-if="back==true">
				<view class="titles">玄幻奇幻</view>
				<view class="books-item" >
					<view @click="toDetailB(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in bxuanhuanList" :key="item.id">
						<image  class="cover-img" :src="item.pic" ></image>
						<!-- <u-lazy-load threshold="-450" height="320" border-radius="20" :image="item.pic" :index="index"></u-lazy-load> -->
						<view>{{item.title}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">武侠仙侠</view>
				<view class="books-item">
					<view @click="toDetailB(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in bxiuxianList" :key="item.id">
						<image class="cover-img" :src="item.pic" ></image>
						<view>{{item.title}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">都市娱乐</view>
				<view class="books-item"  >
					<view @click="toDetailB(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in bcityList" :key="item.id">
						<image  class="cover-img" :src="item.pic" ></image>
						<view>{{item.title}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view  class="titles">游戏竞技</view>
				<view  class="books-item" >
					<view @click="toDetailB(item)" style="margin-top: 30rpx;margin-left: 20rpx;" v-for="(item,index) in bcrossList" :key="item.id">
						<image  class="cover-img" :src="item.pic" ></image>
						<view>{{item.title}}</view>
						<view>{{item.author}}</view>
					</view>
				</view>
				<view>
						<u-toast ref="uToast" />
					</view>
			</view>
		</view>
		<!-- 启动备用版本 -->
	</view>
</template>

<script>
	import {search,getBookList,getBackbook} from '../../api/index.js'
	export default {
		components:{
			
		},
		data() {
			return {
				back:false,
				loading:false,
				category:'',
				indexPage:1,
				flowList:[],
				leftList:[],
				rightList:[],
				refresher: false,
				page: 0,
				novel: [{}],
				user_login: false,
				banner:{},
				xuanhuanList:[],//玄幻小说
				xiuxianList:[],//修仙小说
				cityList:[], //都市小说
				crossList:[],//穿越小说
				bxuanhuanList:[],//奇幻
				bxiuxianList:[],//武侠小说
				bcityList:[], //历史小说
				bcrossList:[],//都市小说
				bookLists:['xuanhuanList','xiuxianList','cityList','crossList'],
				bbookLists:['bxuanhuanList','bxiuxianList','bcityList','bcrossList'],
			}
		},
		onShow() {
			uni.showTabBar()
			
		},
		onLoad() {
			this.findData();
			this.findBanner();
			this.check_login();
			this.getIndexBookList()
			this.getBackbook();
		},
		methods: {
			change(){
				var that = this
				uni.showLoading({
					title:'正在切换线路中',
					icon:'none'
				})
				setTimeout(function() {
					that.back = !that.back
					uni.hideLoading()
					uni.showToast({
					    title: '切换成功',
					    duration: 1000
					});
				}, 1500);
					
				
			},
			getBackbook(){
				var that = this
				for(let i = 0 ;i<2;i++){
					let formdata = {
						cid:18+i,
						page:'1',
						page_size:'10'
					}
					getBackbook(formdata).then(res=>{
						
						this[this.bbookLists[i]] = res.data.data
					})
				}
				getBackbook(
				{
					cid:21,
					page:'1',
					page_size:'10'
				}).then(res=>{
					
					this[this.bbookLists[2]] = res.data.data
				})
				getBackbook(
				{
					cid:34,
					page:'1',
					page_size:'10'
				}).then(res=>{
					console.log(res);
					this[this.bbookLists[3]] = res.data.data
				})
				
				
			},
			toOnLineType(){
				console.log('11111');
				uni.navigateTo({
					url:'../novel/noveltype'
				})
			},
			toDetail(item){
				getApp().globalData.details = item
				// 是一个全局变量，声明一个全局变量details
				uni.navigateTo({
					url:'../novel/onBookDetail'
				})
				
			},
			toDetailB(item){
				uni.navigateTo({
					url:'../novel/backOnlineDetail/backOnlineDetail?id='+item.id
				})
			},
			print(){
				// let a = Math.floor(Math.random()*10-1)
				console.log(a);
			},
			getIndexBookList(){
				var that = this
				for(let i = 0 ;i<4;i++){
					// 回调函数
					getBookList({page:1,category:i+1}).then( res =>{
						this[this.bookLists[i]] = res.result
					})
				}
				
			},
			getBook(){
				console.log('44444');
				search({keywords:'爱情',size:'100'}).then(res=>{
					console.log(res);
				})
				// this.$axios.get3('39.96.77.250/view/chapters?',{bookId:'2960'}).then((res)=>{
				// 	console.log(res);
				// })
				// uni.request({
				//     url: '/lmq/view/bookList',
				// 	method:'get',
				//     data: {
				//         'keywords': '网游',
				// 		'size':'100'
				//     },
				//     success: (res) => {
				//         console.log(res);
				//     }
				// });
				// this.$api.search('爱情').then(res=>{
				// 	console.log(res);
				// })
			},
			findData(){
				this.$axios.get('/index/index').then((res)=>{
					this.novel = res.info;
				})
			},
			findBanner(){
				this.$axios.get('/index/findBanner').then((res)=>{
					this.banner = res.info;
				});
			},
			check_login(){
				var _this = this;
				uni.getStorage({
					key:'user',
					success: (res) => {
						console.log('我登陆过了');
						_this.user_login = true;
						uni.setTabBarItem({
							index:2,
							text: '我的',
							pagePath:'/pages/user/center'
						})
					},
					fail: () => {
						console.log('我没登陆');
						_this.user_login = false;
						uni.setTabBarItem({
							index:2,
							text:'登录',
							pagePath:'/pages/login/login'
						})
					}
				})
			},
			toLogin(){
				uni.switchTab({
					url:'../login/login'
				})
			},
			toCenter(){
				uni.switchTab({
					url:'../user/center'
				})
			},
			toCover(){
				if(this.user_login==true){
					uni.navigateTo({
						url:'../user/user_cover'
					})
					return false;
				}
				else{
					uni.showModal({
						title:'提示',
						content:'请先登录！',
						success: (res) => {
							if(res.confirm==true){
								uni.switchTab({
									url:'../login/login'
								})
							}
							else{
								return false;
							}
						}
					})
				}
			},
			toType(){
				uni.switchTab({
					url:'../novel/novel_list'
				})
			}
		},
	}
</script>

<style scoped>
	@import url("../../static/css/index.css");
	.titles{
		padding: 16rpx;
	}
	.local{
		font-size: 36rpx;
		font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
		padding-left: 32rpx;
		padding-top: 20rpx;
	}
	.online{
		font-size: 36rpx;
		font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
		display: flex;
		justify-content: space-around;
		align-items: center;
		background-color: #FFFFFF;
		padding-top: 20rpx;
	}
	.online-text{
		font-size: 36rpx;
		font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
		padding-left: 32rpx;
		padding-top: 20rpx;
		padding-bottom: 20rpx;
	}
	.online-icon{
		text-align: center;
		padding-bottom: 20rpx;
	}
</style>
