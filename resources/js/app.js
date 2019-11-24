import './bootstrap'
import Vue from 'vue'
import App from './App.vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'v-slim-dialog/dist/v-slim-dialog.css'
import VueResource from 'vue-resource'
import SlimDialog from 'v-slim-dialog'
import moment from 'moment-timezone'
moment.tz.setDefault('Asia/Bangkok')
Vue.prototype.$moment = moment
Vue.use(SlimDialog)
Vue.use(VueResource)
new Vue({
	el: '#app',
	template: '<App/>',
	components: {
		App
	}
})
Vue.http.options.credentials = false
Vue.http.headers.common['Content-Type'] = 'application/json'