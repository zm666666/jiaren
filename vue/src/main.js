// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import Axios from 'axios'
import Qs from 'qs'
import store from './vuex/store'
import 'font-awesome/scss/font-awesome.scss'

Axios.defaults.baseURL = '';
Axios.defaults.transformRequest=function(data){
	return Qs.stringify(data);
};
Vue.prototype.axios= Axios;
Vue.config.productionTip = false;
Vue.use(ElementUI);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
