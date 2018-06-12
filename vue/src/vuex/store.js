//引入相关文件
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

//定义初始化变量
const state = {
	tableName:'course'
};

//定义动作 事件处理方法
const mutations = {
	changeTableName(state,str){
		state.tableName=str;
	},
};

//对外的事件方法
const actions = {

};

const getters = {

};

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
})
