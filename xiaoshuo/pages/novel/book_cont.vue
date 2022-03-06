<template>
	<view class="body">
		<view class="book_body">
			<text class="title">{{data.title}}</text>
			<rich-text :nodes="data.content"></rich-text>
		</view>
		<view class="controller">
			<navigator v-if="prev_id>0" url="#" @click="toPrev">上一页</navigator>
			<navigator v-else url="#">上一页</navigator>
			<text>第{{page+1}}页</text>
			<navigator v-if="next_id>0" url="#" @click="toNext">下一页</navigator>
			<navigator v-else url="#">下一页</navigator>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				id: '',
				data: {
					title: '',
					content: ''
				},
				page: 0,
				prev_id: 0,
				next_id: 0
			}
		},
		methods: {
			findData() {
				var _this = this;
				this.$axios.get('/index/novel_detail/id/' + this.id).then((res) => {
					if (res.status == 'n') {
						uni.showModal({
							title: '提示',
							content: res.info,
							showCancel: false,
							complete: () => {
								uni.navigateBack(-1);
							}
						})
						return false;
					} else {
						_this.data = res.info;
						_this.findPrev();
						_this.findNext();
						uni.setNavigationBarTitle({
							title: _this.data.title
						});
					}
				});
			},
			findPrev() {
				var _this = this;
				this.$axios.get('/index/get_prev/id/' + this.id).then((res) => {
					if (res.status == 'y') {
						_this.prev_id = res.info;
					} else {
						_this.prev_id = 0;
					}
				})
			},
			findNext() {
				var _this = this;
				this.$axios.get('/index/get_next/id/' + this.id).then((res) => {
					if (res.status == 'y') {
						_this.next_id = res.info;
					} else {
						_this.next_id = 0;
					}
				})
			},
			toPrev() {
				this.id = this.prev_id;
				this.data = {};
				this.findData();
				if (this.page < 1) {
					return false;
				} else {
					this.page--;
				}
			},
			toNext() {
				if (this.id != this.next_id) {
					this.id = this.next_id;
					this.data = {};
					this.findData();
					this.page++
				} else {
					return false;
				}
			},
		},
		onLoad(i) {
			if (i.id) {
				this.id = i.id;
				this.findData();
			} else {
				uni.showModal({
					title: '提示',
					content: '数据异常，请重试！',
					showCancel: false,
					complete: () => {
						uni.navigateBack(-1);
					}
				})
			}
			if (i.page) {
				this.page = i.page;
			}
		}
	}
</script>

<style scoped>
	@import url("../../static/css/book_cont.css");
</style>
