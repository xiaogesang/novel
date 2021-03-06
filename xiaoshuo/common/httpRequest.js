import configdata from './config'
import cache from './cache'
import md5 from './md5.js'

module.exports = {
	config: function(name) {
		var info = null;
		if (name) {
			var name2 = name.split("."); //字符分割
			if (name2.length > 1) {
				info = configdata[name2[0]][name2[1]] || null;
			} else {
				info = configdata[name] || null;
			}
			if (info == null) {
				let web_config = cache.get("web_config");
				if (web_config) {
					if (name2.length > 1) {
						info = web_config[name2[0]][name2[1]] || null;
					} else {
						info = web_config[name] || null;
					}
				}
			}
		}
		return info;
	},
	post: function(url, data, header) {
			// header = header || "application/x-www-form-urlencoded";
			url = this.config("APIHOST")+url;
			// var token = md5('asgaasdgs2345asgasasg' + this.config("APITIME"));
			return new Promise((succ, error) => {
				uni.request({
					url: url,
					data: data,
					method: "POST",
					// header: {
					// 	"content-type": header,
					// 	"time" : this.config("APITIME"),
					// 	"token" : token
					// },
					success: function(result) {
						succ.call(self, result.data)
					},
					fail: function(e) {
						error.call(self, e)
					}
				})
			})
		},
	// post: function(url, data, header) {
	// 	// header = header || "application/x-www-form-urlencoded";
	// 	return new Promise((succ, error) => {
	// 		uni.request({
	// 			url: url,
	// 			data: data,
	// 			method: "POST",
	// 			// header: {
	// 			// 	"content-type": header,
	// 			// },
	// 			success: function(result) {
	// 				succ.call(self, result.data)
	// 			},
	// 			fail: function(e) {
	// 				error.call(self, e)
	// 			}
	// 		})
	// 	})
	// },
	get: function(url, data, header) {
		header = header || "application/x-www-form-urlencoded";
		url = this.config("APIHOST")+url;
		return new Promise((succ, error) => {
			uni.request({
				url: url,
				data: data,
				method: "GET",
				header: {
					"content-type": header,
				},
				success: function(result) {
					succ.call(self, result.data)
				},
				fail: function(e) {
					error.call(self, e)
				}
			})
		})
	},
	post2: function(url, data, header) {
		header = header || "application/x-www-form-urlencoded";
		url = this.config("APIHOST2")+url;
		var token = md5('asgaasdgs2345asgasasg' + this.config("APITIME"));
		data['time'] = this.config("APITIME");
		data['token'] = md5('asgaasdgs2345asgasasg' + this.config("APITIME"));
		return new Promise((succ, error) => {
			uni.request({
				url: url,
				data: data,
				method: "POST",
				header: {
					"content-type": header,
					"time" : this.config("APITIME"),
					"token" : token
				},
				success: function(result) {
					succ.call(self, result.data)
				},
				fail: function(e) {
					error.call(self, e)
				}
			})
		})
	},
	get2: function(url, data, header) {
		header = header || "application/x-www-form-urlencoded";
		url = this.config("APIHOST2")+url;
		var token = md5('asgaasdgs2345asgasasg' + this.config("APITIME"));
		return new Promise((succ, error) => {
			uni.request({
				url: url,
				data: data,
				method: "GET",
				header: {
					"content-type": header,
					"time" : this.config("APITIME"),
					"token" : token
				},
				success: function(result) {
					succ.call(self, result.data)
				},
				fail: function(e) {
					error.call(self, e)
				}
			})
		})
	},
	get3: function(url, data, header) {
		header = header || "application/x-www-form-urlencoded";
		url = url;
		var token = md5('asgaasdgs2345asgasasg' + this.config("APITIME"));
		return new Promise((succ, error) => {
			uni.request({
				url: url,
				data: data,
				method: "GET",
				header: {
					"content-type": header,
					"time" : this.config("APITIME"),
					"token" : token
				},
				success: function(result) {
					succ.call(self, result.data)
				},
				fail: function(e) {
					error.call(self, e)
				}
			})
		})
	},
}
