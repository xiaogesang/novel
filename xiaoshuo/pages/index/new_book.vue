<template>
	<view class="vue_body">
		<view class="book_list">
			<navigator :url="'../novel/book_info?id='+v.id" class="top_book" v-for="(v,k) in novel" :key="k">
				<image :src="v.cover" mode=""></image>
				<view class="book_info">
					<text class="book_title">{{v.title}}</text>
					<text class="book_intro">{{v.intro}}</text>
					<text class="book_intro">作者：{{v.editor}}</text>
					<text class="book_intro">{{v.add_time}}</text>
				</view>
			</navigator>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				novel: {},
			}
		},
		methods: {
			findData(){
				this.$axios.get('/index/new_book').then((res)=>{
					this.novel = res.info;
				})
			}
		},
		mounted() {
			this.findData();
		}
	}
</script>

<style scoped>
@import url("../../static/css/index.css");
.top_book{
	padding: 10px;
	margin-bottom: 0 !important;
}
.book_list navigator{
	border-bottom: #fff 5px solid;
}
</style>
