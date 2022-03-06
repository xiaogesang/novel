


const request = (config) => {

        config.url =  config.url
	if (!config.data) {
		config.data = {}
	}

	console.log('请求参数：', JSON.stringify(config.data))
	
	let promise = new Promise((resolve, reject) => {
	    uni.request(config).then(response => {
				//异常
				if (response[0]) {
					reject({message : "网络超时"})
				}else{
					let res = response[1].data
					//处理拦截器
					// if (res.code != 1) {
					// 	console.log(res)
					// 	// msg(res.msg)
					// 	uni.showToast({
					// 		title:res.msg+'请求失败'
					// 	})
					// 	reject(res)
					// }

					resolve(res)
				}
	        }).catch(error => {
	            reject(error)
	        }
	    )
	})
	return promise
};

export default request