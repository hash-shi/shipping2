import Vue from 'vue'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './views/app.vue'
import jQuery from 'jquery'
import store from "./store"

import './../assets/css/common.css'

require('./bootstrap');

import { ajaxStart, ajaxEnd } from './common/AjaxWait'
import { htmlspecialchars } from './common/Utility' 

window.Vue = require('vue');

//-----------------------------------------------------------------------------
// Dialog
//-----------------------------------------------------------------------------
Vue.component("InputShippingDialog"    , require('./dialogs/InputShippingDialog.vue').default)
Vue.component("CustomerSearchDialog"   , require('./dialogs/CustomerSearchDialog.vue').default)
Vue.component("DeliverySearchDialog"   , require('./dialogs/DeliverySearchDialog.vue').default)
Vue.component("DriverSearchDialog"     , require('./dialogs/DriverSearchDialog.vue').default)
Vue.component("SupplierSearchDialog"   , require('./dialogs/SupplierSearchDialog.vue').default)
Vue.component("WarehouseSearchDialog"  , require('./dialogs/WarehouseSearchDialog.vue').default)
Vue.component("ItemSearchDialog"       , require('./dialogs/ItemSearchDialog.vue').default)
Vue.component("OfficeSearchDialog"       , require('./dialogs/OfficeSearchDialog.vue').default)
//-----------------------------------------------------------------------------
// Read Axios
//-----------------------------------------------------------------------------
axios.defaults.baseURL = "";

// Axios request intercept
axios.interceptors.request.use((config) =>{

  // もし、待ち画面を表示したくないAPI通信があれば、ここで特殊処理を追加
  var isWaitView = true;
  if (config.url.indexOf("/api/deliveries/") == 0){ isWaitView = false; }
  if (config.url.indexOf("/api/itemsCustomer/") == 0){ isWaitView = false; }
  if (config.url.indexOf("/api/itemsDelivery/") == 0){ isWaitView = false; }
  if (config.url.indexOf("/api/itemsTransfer/") == 0){ isWaitView = false; }
  if (config.url.indexOf("/api/master/") == 0){ isWaitView = false; }
  
  // タイムアウト値を設定
  config.timeout = 360000

  // AjaxWait画面を表示
  if (isWaitView == true){
    ajaxStart();
  }

  // インターセプト終了
  return config;
})

// Axios response intercept
axios.interceptors.response.use((response) =>{

  // AjaxWait画面終了
  ajaxEnd();

  // インターセプト終了
  return response;
},
(error) => {
  // エラー種別の判定
  if (error.response.status == 422) {
    //-------------------------------------------------------------------------
    // 入力値チェック処理
    // 複数行系のチェック結果が帰ってきた場合は、後で扱い安い形式に変換してerrorsに組み込んでおく
    //-------------------------------------------------------------------------
    var errorMessageDetail = "";
    var errorArrayInfos = {};
    var pattern = /^([1-9]\d*|0)$/;
    Object.keys(error.response.data.errors).forEach(key => {
      var isArray = false;
      var arrayIndex = -1;
      var arrayGroup = "";
      var arrayItem  = "";
      if (key.split(".").length == 3){
        if (pattern.test(key.split(".")[1])){
          isArray    = true;
          arrayIndex = parseInt(key.split(".")[1], 10);
          arrayGroup = key.split(".")[0];
          arrayItem  = key.split(".")[2];
        }
      }
      // エラーメッセージ収集
      var countTemp = 0;
      error.response.data.errors[key].some(function(values){
        // １つの項目に対して複数のエラーが表示される可能性があるので、１件目のみに制限したかったが出来なかった為、ループカウントで監視することにした
        if (countTemp == 0){

          // エラーメッセージ収集
          errorMessageDetail += (errorMessageDetail==""?"":"\n") + values

          // 複数行系の場合の処理
          // エラー配列情報に行毎のエラー内容を格納
          if (isArray){
            if (!(arrayGroup in errorArrayInfos)){ errorArrayInfos[arrayGroup] = {}; }
            if (!(arrayIndex+"" in errorArrayInfos[arrayGroup])){ errorArrayInfos[arrayGroup][arrayIndex+""] = [];}
            errorArrayInfos[arrayGroup][arrayIndex+""].push(values)
          }
        }
        countTemp++;
      });
    });
    alert(errorMessageDetail);
  } else {
    var errorMessage = "";
    var responseData = "";
    if (error.response.data.message){
      errorMessage = error.response.data.message;
    }
    if (error.response.data){
      responseData = JSON.stringify(error.response.data);
    }
    alert("致命的なエラーが発生しました。開発元までご連絡ください。" + "\n\n" + error.message + "\n\n" + errorMessage + "\n\n" + responseData);
  }

  // AjaxWait終了
  ajaxEnd()

  // インターセプト終了
  return Promise.reject(error);
})
Vue.use(VueAxios, axios)

//-----------------------------------------------------------------------------
// jQuery
//-----------------------------------------------------------------------------
global.jquery = jQuery
global.$ = jQuery
window.$ = window.jQuery = require('jquery')

//-----------------------------------------------------------------------------
// Read FontAwesome
//-----------------------------------------------------------------------------
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon, FontAwesomeLayersText } from '@fortawesome/vue-fontawesome'
library.add(fas)
Vue.component('font-awesome-icon', FontAwesomeIcon)

//-----------------------------------------------------------------------------
// Vue
//-----------------------------------------------------------------------------
const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App />'
});
