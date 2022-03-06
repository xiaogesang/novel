import Vue from 'vue'
import App from './App'
import httpApi from './common/httpApi'
import HttpRequest from './common/httpRequest'
import HttpCache from './common/cache'
import uView from "uview-ui";
Vue.use(uView);
// import store from './store'

Vue.config.productionTip = false
Vue.prototype.$api = httpApi
Vue.prototype.$axios = HttpRequest
Vue.prototype.$Sysconf = HttpRequest.config


App.mpType = 'app'

const app = new Vue({
	...App
})
app.$mount()
