/**
 * API接口配置文件
 */
module.exports = {
	home : {
		banner:"index/banner", // 首页banner 
		navlist:"index/navlist", // 首页导航
		juhusuan:"index/juhuasuanlist", // 首页聚划算推荐
	},
	common:{
		couponlist:"index/couponlist", // 公共加载商品
		config:"config/getinfo", // 获取服务端配置
		update:"config/update", // 检测更新 
	},
	goods:{
		iteminfo:"items/goodsinfo", // 商品详情 加载 
	}
}