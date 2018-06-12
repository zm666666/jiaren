import Vue from 'vue'
import Router from 'vue-router'
import login from '@/components/page/login'
import admin from '@/components/page/admin'
import member from '@/components/page/member'
import timeTable from '@/components/page/timeTable'

Vue.use(Router)

export default new Router({
	routes: [
		{
			path: '/',
			redirect:function () {
				if(localStorage.login!=='true'){
					return '/login';
				}
				else{
					if(localStorage.userType==='admin')
						return '/admin/course';
					else
						return '/member/checkCourse';
				}
			}
		},
		{
			path: '/login',
			name: 'login',
			component: login
		},
		{
			path: '/admin/:tableName',
			name: 'admin',
			component: admin
		},
		{
			path: '/member/:otherCondition',
			name: 'member',
			component: member
		},
		{
			path:'/timeTable/:otherCondition',
			name:'timeTable',
			component:timeTable
		}
	]
})
