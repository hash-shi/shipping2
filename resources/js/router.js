import Vue from 'vue'
import VueRouter from 'vue-router'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    { path: '/sso',                      name: 'SSO',            component: () => import('./pages/SSO.vue')},
    { path: '/',                         name: 'Index',          component: () => import('./pages/Index.vue') },
    { path: '/detail/:sihId'  ,          name: 'Detail',         component: () => import('./pages/Detail.vue') },
    { path: '/qr',                       name: 'QR',             component: () => import('./pages/QR.vue')},
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
