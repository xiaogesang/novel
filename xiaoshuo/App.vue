<style lang="scss">
	/* 注意要写在第一行，同时给style标签加入lang="scss"属性 */
	@import "uview-ui/index.scss";
</style>
<script>
	import uniIcons from "@/components/uni-icons/uni-icons.vue"
	import uniDrawer from "@/components/uni-drawer/uni-drawer.vue"
export default {
	components: {
		uniIcons,
		uniDrawer,
	},
	globalData: {  
	            details: {}  
	        },
	onLaunch: function() {
		// console.log('App Launch');
	},
	onShow: function() {
		// console.log('App Show');
	},
	onHide: function() {
		// console.log('App Hide');
	}
};
</script>

<style>
@import url("/static/css/public.css");
/* 解决头条小程序组件内引入字体不生效的问题 */
/* #ifdef MP-TOUTIAO */
@font-face {
	font-family: uniicons;
	src: url('/static/uni.ttf');
}
/* #endif */

</style>
