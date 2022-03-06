<template>
	<view class="body">
		<view class="novel_list">
			<view class="list_item" v-for="(v,k) in novel_list" :key="k">
				<navigator :url="'./book_cont?id='+v.id">{{v.title}}</navigator>
			</view>
			<view class="page_btn">
				<text @click="toPrev">上一页</text>
				<text class="page_nums">第 {{page+1}} 页</text>
				<text @click="toNext">下一页</text>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				id: '',
				novel_list: {},
				page: 0,
				nextPage: true,
			}
		},
		methods: {
			findData() {
				var _this = this;
				this.$axios.get('/index/novel_title/id/' + this.id + '/page/' + this.page).then((res) => {
					_this.novel_list = res.info;
					if (res.info.length < 15) {
						_this.nextPage = false;
					} else {
						_this.nextPage = true;
					}
				})
			},
			toNext() {
				if (this.nextPage == true) {
					this.page++;
					this.novel_list = {};
					this.findData();
				}
			},
			toPrev(){
				if(this.page<1){
					return false;
				}
				else{
					this.page--;
					this.novel_list = {};
					this.findData();
				}
			}
		},
		onLoad(i) {
			if (i.id) {
				this.id = i.id;
			} else {
				uni.showModal({
					title: '提示',
					content: '网络错误，请重试！',
					complete: () => {
						uni.navigateBack(-1);
					}
				})
				return false;
			}
		},
		mounted() {
			this.findData();
		}
	}
</script>

<style scoped>
	@import url("../../static/css/book_title.css");
</style>
