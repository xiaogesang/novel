<template>
	<view class="body">
		<view class="left_type">
			<view class="type_item" :class="{on:on_type==0}" @click="check_type(0)">全部</view>
			<view class="type_item" v-for="(v,k) in types" :key="k" @click="check_type(v.id)" :class="{on:on_type==v.id}">{{v.name}}</view>
		</view>
		<scroll-view class="scroll_view" :scroll-y="true" :lower-threshold="0" @scrolltolower="findMore">
			<view class="right_list">
				<navigator :url="'./book_info?id='+v.id" class="top_book" v-for="(v,k) in novel_list" :key="k">
					<image :src="v.cover" mode=""></image>
					<view class="book_info">
						<text class="book_title">{{v.title}}</text>
						<text class="book_intro">{{v.intro}}</text>
					</view>
				</navigator>
			</view>
		</scroll-view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				types: {},
				novel_list: {},
				page: 0,
				on_type: 0,
				more: false,
			}
		},
		methods: {
			findType(){
				var _this = this;
				this.$axios.get('/index/novel_types').then((res)=>{
					_this.types = res.info;
				});
			},
			findData(){
				var _this = this;
				this.$axios.get('/index/novel_list_byType/types/'+this.on_type+'/page/'+this.page).then((res)=>{
					_this.novel_list = res.info;
					if(res.info.length<10){
						_this.more = false;
					}
					else{
						_this.more = true;
					}
				})
			},
			findMore(){
				if(this.more == true){
					this.page++;
					this.findData();
				}
			},
			check_type(i){
				this.on_type = i;
				this.page = 0;
				this.findData();
			}
		},
		mounted() {
			this.findType();
			this.findData();
		}
	}
</script>

<style scoped>
	@import url("../../static/css/novel_list.css");
</style>
