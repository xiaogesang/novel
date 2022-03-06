import request from '@/utils/request'

// template
// 书本搜索
export function search(data) {
	return request({
		url: '/lmq/view/bookList',
		method: 'get',
		data
	})
}
// 首页书籍列表获取 参数 分页page 类型 category
export function getBookList(data) {
	return request({
		url: '/lmq/view/bookList',
		method: 'get',
		data
	})
}
// 获取小说章节
export function getChapters(data) {
	return request({
		url: '/lmq/view/chapters',
		method: 'get',
		data
	})
}
// 获取章节内容
export function getChaptersDetail(data) {
	return request({
		url: '/lmq/view/readBook',
		method: 'get',
		data
	})
}


// 热搜榜列表
export function hotList(data) {
	return request({
		url: '/lzq/ranking/5a6844f8fc84c2b8efaa8bc5',
		method: 'get',
		data
	})
}
// 好评榜
export function GoodRank(data) {
	return request({
		url: '/lzq/ranking/5a6844aafc84c2b8efaa6b6e',
		method: 'get',
		data
	})
}
// 备用接口获取小说列表
export function getBackbook(data) {
	return request({
		url: '/lqm/Book/lists',
		method: 'post',
		data
	})
}

// 备用接口获取小说详情
export function getBackDetail(data) {
	return request({
		url: '/lqm/Book/content',
		method: 'post',
		data
	})
}
// 备用接口获取章节列表
export function getBackCharts(data) {
	return request({
		url: '/lqm/Book/get_chapter_list',
		method: 'post',
		data
	})
}
// 备用接口获取章节内容
export function getBackContent(data) {
	return request({
		url: '/lqm/Book/chapter',
		method: 'post',
		data
	})
}

