<template>
  <div>
    <div :inert="inert">
      <div class="tv">
        <div class="title">出荷日</div>
        <div class="value">
          <input type="date" v-model="searchs.shipDateFrom" max="9999-12-31" ref="searchShipDateFrom" v-on:change="changeShipDate" @keyup.enter="moveToNextField('searchShipDateFrom')">
          ～
          <input type="date" v-model="searchs.shipDateTo"   max="9999-12-31" ref="searchShipDateTo" v-on:change="changeShipDate" @keyup.enter="moveToNextField('searchShipDateTo')">
        </div>
      </div>
      <br />
      <div class="tv">
        <div class="title">進捗</div>
          <div class="value">
          <div v-for="(statusItem, index) in master.status" :key="index" style="display:inline-block;">
            <label>
              <input type="checkbox" :value="statusItem.status" :ref="'searchStatus_' + index" v-model="searchs.status" @keyup.enter="moveToNextField('searchStatus_' + index)">{{ statusItem.label }}({{ statusItem.count }})
            </label>
          </div>
          ※()内の数値は件数
        </div>
      </div>
      <br />
      <div class="tv">
        <div class="title">受注NO</div>
        <div class="value" >
          <input type="text" autocomplete="off" id="orderNo" ref="orderNo" v-model="searchs.orderNo" list="orderNoList" class="w100" @keyup.enter="moveToNextField('orderNo')">
          <datalist id="orderNoList">
            <option v-for="orderNo in master.orderNo" :key="orderNo.ORDER_NO" :value="orderNo.ORDER_NO">
              {{ orderNo.ORDER_NO }}
            </option>
          </datalist>
        </div>
      </div>
      ※新規の場合は入力せずに新規登録ボタンを押してください。
      <br />
      <div class="tv">
        <div class="title">運送便</div>
        <div class="value">
          <select ref="flights" v-model="searchs.flights" class="w250" @keyup.enter="moveToNextField('flights')">
            <option value="">選択なし</option>
            <option v-for="driver in master.drivers" :key="driver.DRIVER_CODE+':'+driver.FLIGHTS" :value="driver.DRIVER_CODE+':' + driver.FLIGHTS">
              {{ driver.DRIVER_CODE }} : {{ driver.DRIVER_NAME }} : {{ driver.FLIGHTS }}
            </option>
          </select>
        </div>
      </div>
      <br />
    
      <button type="button" ref="search" class="awake" title="指定した条件で指示データを検索します。" v-on:click="search" @keyup.enter="search">検索</button>
      <button type="button" ref="regist" class="awake" title="新規登録画面へ" v-on:click="regist" @keyup.enter="regist">新規登録</button>
    
      <pre></pre>
  
      <button type="button" ref="reload" v-on:click="search">最新</button>
      <button type="button" ref="update" v-on:click="update">更新</button>
      {{ ((pageNow - 1) * pageDataCount) + (pageResults.length>0?1:0) }}件 から {{ ((pageNow - 1) * pageDataCount) + pageResults.length }}件 までを表示（全 {{ sihRecords.length }} 件）
      <div v-if="isNotSureShipping" style="display:inline-block;color:#ff0000;"> ※運送便未確定のデータが{{ sureShippingCount }}件あります。</div>
      <br>
      <ul class="paging">
        <li v-if="pageNow!=1 && pageCount>0" v-on:click="pageNow=pageNow-1">&lt;</li>
        <li v-if="isShowPageFirst" :class="{'selected':1==pageNow}" v-on:click="pageNow=1">1</li>
        <li v-if="isShowPageFirst && isShowPageFirstDot">..</li>
        <li v-for="page of this.pagingCount" :key="page" :class="{'selected':page==pageNow}" v-on:click="pageNow=page">{{ page }}</li>
        <li v-if="isShowPageLast && isShowPageLastDot">..</li>
        <li v-if="isShowPageLast" :class="{'selected':pageCount==pageNow}" v-on:click="pageNow=pageCount">{{ pageCount }}</li>
        <li v-if="pageNow!=pageCount && pageCount>0" v-on:click="pageNow=pageNow+1">&gt;</li>
      </ul>
  
      <table class="searchResult">
        <tr>
          <th class="w110">
            受注No
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='ORDER_NO'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('ORDER_NO', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='ORDER_NO'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('ORDER_NO', 'asc')" /></div>
            </div>
          </th>
          <th class="w100">
            取区
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='HCODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('HCODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='HCODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('HCODE', 'asc')" /></div>
            </div>
          </th>
          <th class="w100">
            出荷日
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='SHIP_DATE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('SHIP_DATE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='SHIP_DATE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('SHIP_DATE', 'asc')" /></div>
            </div>
          </th>
          <th class="w100">
            納品日
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='DELIVERY_DATE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('DELIVERY_DATE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='DELIVERY_DATE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('DELIVERY_DATE', 'asc')" /></div>
            </div>
          </th>
          <th>
            得意先
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='CUSTOMER_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('CUSTOMER_CODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='CUSTOMER_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('CUSTOMER_CODE', 'asc')" /></div>
            </div>
          </th>
          <th>
            納入先
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='DELIVERY_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('DELIVERY_CODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='DELIVERY_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('DELIVERY_CODE', 'asc')" /></div>
            </div>
          </th>
          <th>
            運転手
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='DRIVER_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('DRIVER_CODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='DRIVER_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('DRIVER_CODE', 'asc')" /></div>
            </div>
          </th>
          <th>
            便区分
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='FLIGHTS'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('FLIGHTS', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='FLIGHTS'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('FLIGHTS', 'asc')" /></div>
            </div>
          </th>
          <th>
            仕入先
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='SUPPLIER_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('SUPPLIER_CODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='SUPPLIER_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('SUPPLIER_CODE', 'asc')" /></div>
            </div>
          </th>
          <th>
            倉庫
            <div class="sort">
              <div class="down" v-bind:class="{sortSelect:sortKey=='WAREHOUSE_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('WAREHOUSE_CODE', 'desc')" /></div>
              <div class="up"   v-bind:class="{sortSelect:sortKey=='WAREHOUSE_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('WAREHOUSE_CODE', 'asc')" /></div>
            </div>
          </th>
          <th class="w40">S</th>
          <th class="w40">付</th>
          <th class="w90">入力確定</th>
          <th class="w90">出荷実績日</th>
        </tr>
  <!-- sihRecords pageResults-->
        <tr v-for="(sihRecord, index) of pageResults" :key="index" v-bind:class="{ 'hasKARI': hasKARI(sihRecord.KARI) }">
          <!-- 受注No -->
          <td class="center" style="height: 46px;text-decoration: underline;color: #0000ff;">
            <div title="編集画面へ" style="cursor:pointer;" v-on:click="detail(sihRecord.SIH_ID)">{{ sihRecord.ORDER_NO }}</div>
          </td>
          <!-- 取区 -->
          <td class="center">
            {{ sihRecord.HNAME }}
          </td>
          <!-- 出荷日 -->
          <td class="center">
            {{ toDate(sihRecord.SHIP_DATE) }}
          </td>
          <!-- 納品日 -->
          <td class="center">
            {{ toDate(sihRecord.DELIVERY_DATE) }}
          </td>
          <!-- 得意先 -->
          <td>
            {{ sihRecord.CUSTOMER_CODE }}<br />{{ sihRecord.CUSTOMER_NAME }}
          </td>
          <!-- 納入先 -->
          <td>
            {{ sihRecord.DELIVERY_CODE }}<br />{{ sihRecord.DELIVERY_NAME }}
          </td>
          <!-- 運転手 -->
          <td v-bind:class="{nothing: sihRecord.DRIVER_CODE=='' || sihRecord.DRIVER_CODE==null}">
            <input type="text" autocomplete="off" size="4" :value="sihRecord.DRIVER_CODE | upperCase" @input.lazy="sihRecord.DRIVER_CODE = ($event.target.value).toUpperCase()" v-on:keyup="driverC2N(index)" v-on:blur="driverBlur(index);" :ref="'driver_' + index" @keyup.enter="moveToNextField('driver_' + index)">
       <!-- <input type="text" autocomplete="off" size="16" list="items_rel" :value="sidRecord.ITEM_CODE | upperCase" @input.lazy="sidRecord.ITEM_CODE = ($event.target.value).toUpperCase()" v-on:keyup="itemC2N(index)" v-on:blur="itemBlur(index);" :ref="'itemCode_' + index" @keyup.enter="moveToNextField('itemCode_' + index)"> -->
            <font-awesome-icon icon="times" v-on:click="sihRecord.DRIVER_CODE='';driverBlur(index);" style="cursor:pointer;" />
            <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="showDialog.DriverSearchIndex=index;opneDialog('DriverSearch')" />
            <br />
            {{ sihRecord.DRIVER_NAME }}
          </td>
          <!-- 便区分 -->
          <td v-bind:class="{nothing: sihRecord.FLIGHTS=='' || sihRecord.FLIGHTS==null}">
            <input type="text" autocomplete="off" :ref="'flights_' + index" size="1" v-model="sihRecord.FLIGHTS" @keyup.enter="moveToNextField('flights_' + index)">
          </td>
          <!-- 仕入先 -->
          <td>
            {{ sihRecord.SUPPLIER_CODE }}<br />{{ sihRecord.SUPPLIER_NAME }}
          </td>
          <!-- 倉庫 -->
          <td>
            {{ sihRecord.WAREHOUSE_CODE }}<br />{{ sihRecord.WAREHOUSE_NAME }}
          </td>
          <!-- S -->
          <td class="center" v-bind:class="{complete: sihRecord.STATUS=='2'}">
            {{ toStatus(sihRecord.STATUS) }}
          </td>
          <!-- 付 -->
          <td class="center" v-bind:class="{hasTag: sihRecord.TAG_NOTE!=''&&sihRecord.TAG_NOTE!=null}">
            <div style="position:relative;cursor:help;" v-if="sihRecord.TAG_NOTE!=''&&sihRecord.TAG_NOTE!=null" v-on:mouseover="showTagNote" v-on:mouseout="hideTagNote">
              <div class="fukidashiTagNote">{{ sihRecord.TAG_NOTE }}</div>
              <font-awesome-icon icon="comment" />
            </div>
          </td>
          <!-- 入力確定 -->
          <td class="center">
            <div style="position:relative;cursor:pointer;" v-if="sihRecord.CONFIRM_DATE!=''&&sihRecord.CONFIRM_DATE!=null" v-on:mouseover="showConfirmDate" v-on:mouseout="hideConfirmDate">
              {{ toMonthDay(sihRecord.CONFIRM_DATE)}} 
              <div class="datesNote">
                確定時刻：{{ toDateTime(sihRecord.CONFIRM_DATE) }}
                <br>
                受発注者：{{ sihRecord.NAME }}
              </div>
            </div>
          </td>
          <!-- 出荷実績日 -->
          <td v-bind:class="{difference: sihRecord.QTY != sihRecord.QTY_RESULT &&( sihRecord.QTY_RESULT !='' && sihRecord.QTY_RESULT !=null)}">
            <div style="position:relative;cursor:pointer;" v-if="sihRecord.SHIP_DATE_RESULT!=''&&sihRecord.SHIP_DATE_RESULT!=null" v-on:mouseover="showConfirmDate" v-on:mouseout="hideConfirmDate">
              {{ toDateTime(sihRecord.SHIP_DATE_RESULT) }}
              <div class="datesNote">
                QTY：{{ sihRecord.QTY }}
                <br>
                QTY_RESULT：{{ sihRecord.QTY_RESULT }}
                <br>
                modified：{{ toDateTime(sihRecord.modified) }}
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  
    <!-- 新規登録 -->
    <InputShippingDialog  v-if="showDialog.InputShipping" :mode="'new'" :hCode="1" @close="closeDialog('InputShipping')" @complete="detail" ></InputShippingDialog>
    <!-- 運転手 -->
    <DriverSearchDialog   v-if="showDialog.DriverSearch"  :officeCode="this.officeCode" :hCode="this.hCode" @close="closeDialog('DriverSearch')" @select="selectDriverDialog"></DriverSearchDialog>
  </div>
</template>
<script>
import router from './../router'
import store from "./../store"
import $ from "jquery";
export default {
  computed: { },
  data() {
    return {

      // 画面ロック
      inert: false,   // 初期値の設定

      // ダイアログ表示フラグ
      showDialog: {
        "InputShipping": false,
        "DriverSearch": false,          // 運転手検索ダイアログの表示・非表示管理フラグ
        "DriverSearchIndex": -1,
      },

      // 検索条件
      searchs: {
        'warehouses': "",
        'shipDateFrom': "",
        'shipDateTo': "",
        'status': [],
        'orderNo': "",
        'flights': "",
      },

      // 検索結果とソート
      sihRecords: [],
      sortKey: "ORDER_NO",
      sortOrder:"desc",
      isNotSureShipping: false,

      // ドロップダウン元ネタ
      master: {
        'status': [],
        'drivers': [],
        'orderNo': [],
      },

      //一時保存値
      origin: {
        'DriverCode': [],
      },

      //運送未確定数
      sureShippingCount:0,

      //画面更新間隔
      screenRedrawInterval:"",

      // 営業所コード
      officeCode:"",

      // // 検索用会社コード
      // companyCodeSearch: "",

      //
      hCode:"",

      //タイマー
      intervalSeach:null,

      // ページング
      pageCount: 0,
      pageNow: 1,
      pageOld: 0,
      pageDataCount: 10,
      isShowPageFirst: false, isShowPageFirstDot: false,
      isShowPageLast: false,  isShowPageLastDot : false,

      nextFields :[],
    }
  },
  methods: {

    //-------------------------------------------------------------------------
    // ダイアログのオープンクローズ
    //-------------------------------------------------------------------------
    setInert:function(value) { this.inert = value; },
    opneDialog:function (dialog) {
      this.setInert(true);
      this.showDialog[dialog] = true;
    },
    closeDialog:function (dialog) {
      this.setInert(false);
      this.showDialog[dialog] = false;
    },
    //-------------------------------------------------------------------------
    // ダイアログで選択した値を反映
    //-------------------------------------------------------------------------
    // 運転手ダイアログで選択した得意先を格納してダイアログを閉じる
    selectDriverDialog: function(driverCode, truckerCode, companyCode) {
      var index = this.showDialog.DriverSearchIndex;
      this.sihRecords[index].TRUCKER_CODE = truckerCode;
      this.sihRecords[index].DRIVER_CODE = driverCode;
      this.closeDialog('DriverSearch');
      this.driverBlur(index);
      this.driverC2N(index);
      this.$nextTick(() => this.moveToNextField('driver_' + this.showDialog.DriverSearchIndex));
    },

    //-------------------------------------------------------------------------
    // マスタ検索
    //-------------------------------------------------------------------------
    // 運送会社
    getTruckerName: async function (truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getTruckerName", { 'code': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },
    // 運転手
    getDriverName: async function (driverCode, truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getDriverName", { 'code': driverCode, 'truckerCode': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },
    // 特殊処理、運転手コードから運送会社コードを取得
    getDriverTrucker: async function (driverCode, truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getDriverTrucker", { 'code': driverCode, 'truckerCode': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },

    //-------------------------------------------------------------------------
    // 運転手関連
    //-------------------------------------------------------------------------
    // キー入力
    driverC2N: async function (index){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecords[index].DRIVER_CODE??"").length < 6) { 
        this.sihRecords[index].DRIVER_NAME = "";
        this.sihRecords[index].TRUCKER_CODE = "";
        this.sihRecords[index].TRUCKER_NAME = "";
        return;
      }
      // 変更がある場合のみ処理
      if (this.origin.DriverCode[index] == this.sihRecords[index].DRIVER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.DriverCode[index] = this.sihRecords[index].DRIVER_CODE;
      // 名称取得
      this.sihRecords[index].DRIVER_NAME = await this.getDriverName(this.sihRecords[index].DRIVER_CODE, this.sihRecords[index].TRUCKER_CODE, this.officeCode);
      this.sihRecords[index].TRUCKER_CODE = await this.getDriverTrucker(this.sihRecords[index].DRIVER_CODE, this.sihRecords[index].TRUCKER_CODE, this.officeCode);
      this.sihRecords[index].TRUCKER_NAME = await this.getTruckerName(this.sihRecords[index].TRUCKER_CODE, this.officeCode);
    },
    // フォーカスアウト
    driverBlur: async function(index) {
      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecords[index].DRIVER_CODE??"").length && (this.sihRecords[index].DRIVER_CODE??"").length <= 6){
        this.sihRecords[index].DRIVER_CODE = this.sihRecords[index].DRIVER_CODE.padStart(6, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.DriverCode[index] == this.sihRecords[index].DRIVER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.DriverCode[index] = this.sihRecords[index].DRIVER_CODE;
      // 名称取得
      this.sihRecords[index].DRIVER_NAME = await this.getDriverName(this.sihRecords[index].DRIVER_CODE, this.sihRecords[index].TRUCKER_CODE, this.officeCode);
      this.sihRecords[index].TRUCKER_CODE = await this.getDriverTrucker(this.sihRecords[index].DRIVER_CODE, this.sihRecords[index].TRUCKER_CODE, this.officeCode);
      this.sihRecords[index].TRUCKER_NAME = await this.getTruckerName(this.sihRecords[index].TRUCKER_CODE, this.officeCode);
      // 
      this.driverC2N(index);
    },

    //-------------------------------------------------------------------------
    // 検索処理
    //-------------------------------------------------------------------------
    search: async function(){
      this.isNotSureShipping = false;
      await axios.post("/api/shippingSearch", {
        'searchWarehouses'    : this.searchs.warehouses,
        'searchShipDateFrom'  : this.searchs.shipDateFrom,
        'searchShipDateTo'    : this.searchs.shipDateTo,
        'searchStatus'        : this.searchs.status,
        'searchOrderNos'      : this.searchs.orderNo,
        'searchFlights'       : this.searchs.flights,
      })
      .then(response => {

        // 検索結果とページング情報の格納
        this.sihRecords = response.data.sihRecords;
        this.pageNow = 1;
        this.pageCount = Math.ceil(this.sihRecords.length / this.pageDataCount);

        // ページングエリアに「※運送便未確定のデータがあります。」を表示するか否かの判断
        this.sureShippingCount=0;
        for (var count = 0 ; count < this.sihRecords.length ; count++) {
          if (this.sihRecords[count]["DRIVER_CODE"] == null || this.sihRecords[count]["FLIGHTS"] == null) {
            this.sureShippingCount+=1;
          }
        }
        if(this.sureShippingCount > 0){
          this.isNotSureShipping = true;
        }
      })
    },
    setSort: function(sortKey, sortOrder) {
      this.sortKey = sortKey;
      this.sortOrder = sortOrder;
    },
    update: async function() {
      if (confirm("更新します。よろしいですか？")) {
        await axios.post("/api/shipping/update", {
          'sihRecords' : this.sihRecords,
        })
        .then(response => {
          alert("更新しました。");
          // 再検索
          this.search();
        });
      }
    },
    //-------------------------------------------------------------------------
    // 新規登録
    //-------------------------------------------------------------------------
    regist: function(){
      this.$store.commit("setSearch" , {
        'searchWarehouses'    : this.searchs.warehouses,
        'searchShipDateFrom'  : this.searchs.shipDateFrom,
        'searchShipDateTo'    : this.searchs.shipDateTo,
        'searchStatus'        : this.searchs.status,
        'searchOrderNos'      : this.searchs.orderNo,
        'searchFlights'       : this.searchs.flights,
      });
      this.opneDialog("InputShipping");
    },
    //-------------------------------------------------------------------------
    // 詳細へ遷移
    //-------------------------------------------------------------------------
    detail: function(sihId, orderNo, hCode, shipDate, userCode){
      this.$store.commit("setSearch" , {
        'searchWarehouses'    : this.searchs.warehouses,
        'searchShipDateFrom'  : this.searchs.shipDateFrom,
        'searchShipDateTo'    : this.searchs.shipDateTo,
        'searchStatus'        : this.searchs.status,
        'searchOrderNos'      : this.searchs.orderNo,
        'searchFlights'       : this.searchs.flights,
      });

      if (orderNo !== undefined && hCode !== undefined && shipDate !== undefined && userCode !== undefined) {
        // 新規
        router.push({ path: "/detail/" + sihId + "_" + orderNo + "_" + hCode + "_" + shipDate + "_" + userCode });
      } else {
        // 修正
        router.push({ path: "/detail/" + sihId });
      }
    },
    //-------------------------------------------------------------------------
    // 出荷日の変更イベント
    //-------------------------------------------------------------------------
    changeShipDate: async function() {
      await axios.post("/api/shippingSearchDateInfo", {
        "shipDateFrom"  : this.searchs.shipDateFrom,
        "shipDateTo"  : this.searchs.shipDateTo,
      })
      .then(response => {
      
        // 進捗のカッコ内の件数
        this.master.status = response.data.searchStatusList;
        this.searchs.status = [];

        // 運送便
        this.master.drivers = response.data.flightsList;
        this.searchs.flights = "";

        //受付NO
        this.master.orderNo  = response.data.orderNoList;
        this.searchs.orderNo = "";
      });
    },
    //-------------------------------------------------------------------------
    // 付箋の表示
    //-------------------------------------------------------------------------
    showTagNote: function(event) {
      $(event.currentTarget).find("div.fukidashiTagNote").show();
    },
    hideTagNote: function(event) {
      $(event.currentTarget).find("div.fukidashiTagNote").hide();
    },
    //-------------------------------------------------------------------------
    // コンバート
    //-------------------------------------------------------------------------
    // 日付フォーマット
    toDate: function(dateObj){
      if (dateObj == null){ return ""; }
      var dateValue = dateObj.substr(2, 8).split("-").join("/");
      return dateValue;
    },
    // 日付フォーマット(月日)
    toMonthDay: function(dateObj){
      if (dateObj == null){ return ""; }
      var dateValue = dateObj.substr(5, 6).split("-").join("/");
      return dateValue;
    },
    // 日時フォーマット
    toDateTime: function(dateObj){
      if (dateObj == null){ return ""; }
      var dateValue = dateObj.substr(5,11).split("-").join("/");
      return dateValue;
    },
    // ステータス
    toStatus: function(status){
      if (status == "0"){ return ""; }
      if (status == "1"){ return "確"; }
      if (status == "2"){ return "完"; }
      return "";
    },
    // 取区
    toHCode: function(status){
      if (status == "1"){ return "通常売上"; }
      if (status == "2"){ return "通常仕入"; }
      if (status == "3"){ return "通常移動"; }
      if (status == "4"){ return "融通売上"; }
      if (status == "5"){ return "融通仕入"; }
      if (status == "6"){ return "融通移動"; }
      return "";
    },

    //-------------------------------------------------------------------------
    // 入力確定、出荷実績日の詳細表示
    //-------------------------------------------------------------------------
    showConfirmDate: function(event){
      $(event.currentTarget).find("div.datesNote").show();
    },
    hideConfirmDate: function(event){
      $(event.currentTarget).find("div.datesNote").hide();
    },

    hasKARI: function(KARI) {
      return (KARI == 1);
    },

    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {

      // Enter移動の設定をする
      this.nextFields = []

      this.nextFields.push({ 'id':'searchShipDateFrom', 'disabled': false, });
      this.nextFields.push({ 'id':'searchShipDateTo', 'disabled': false, });

      for (var i = 0; i < this.master.status.length; i++) {
        this.nextFields.push({ 'id':'searchStatus_' + i,	'disabled': (this.master.status.length == 0), });
      }

      this.nextFields.push({ 'id':'orderNo', 'disabled': false, });
      this.nextFields.push({ 'id':'flights', 'disabled': false, });
      this.nextFields.push({ 'id':'search', 'disabled': false, });
      this.nextFields.push({ 'id':'regist', 'disabled': false, });
      this.nextFields.push({ 'id':'reload', 'disabled': false, });
      this.nextFields.push({ 'id':'update', 'disabled': false, });

      for (var i = 0; i < this.pageDataCount; i++) {
        this.nextFields.push({ 'id':'driver_' + i, 'disabled': (this.pageDataCount == 0), }); 
        this.nextFields.push({ 'id':'flights_' + i, 'disabled': (this.pageDataCount == 0), });
      }

    },
    moveToNextField(nowField) {
      var nextField = ""
      var index = this.nextFields.findIndex(field => field.id === nowField);
      for (var i = 0; i < this.nextFields.length; i++) {
        if (index < (this.nextFields.length - 1)) { index++ } else { index = 0 }
        var record = this.nextFields[index]
        if (!record.disabled) {
          nextField = record.id
          break;
        }
      }
      if (nextField) {
        // this.$refs[nextField].focus();
        if (this.$refs[nextField]) {
          if (Array.isArray(this.$refs[nextField])) {
            this.$refs[nextField][0].focus();
          } else {
            this.$refs[nextField].focus();
          }
        }
      }
    },
  },
  mounted: async function(){

    // 簡易ログインチェック
    if (store.state.userCode==null){ router.push({ path: "/sso" }); }

    await axios.get("/api/shippingSearchInit", {})
      .then(response => {
        this.searchs.shipDateFrom   = response.data.searchShipDateFrom;
        this.searchs.shipDateTo     = response.data.searchShipDateTo;
        this.searchs.status         = response.data.searchStatus;
        this.searchs.orderNo        = response.data.searchOrderNos;
        this.searchs.flights        = response.data.searchFlights;
        this.screenRedrawInterval   = response.data.screenRedrawInterval;
        this.officeCode             = response.data.officeCode;
        // this.companyCodeSearch 		  = response.data.officeCode;
      });

    // 戻りの場合はVuexから前回の検索結果を取得する
    var isBack = this.$route.query.isBack;
    if (isBack == "true"){
      if (store.state.searchWarehouses != null && store.state.searchWarehouses != undefined){ this.searchs.warehouses = store.state.searchWarehouses; }
      if (store.state.searchShipDateFrom != null && store.state.searchShipDateFrom != undefined){ this.searchs.shipDateFrom = store.state.searchShipDateFrom; }
      if (store.state.searchShipDateTo != null && store.state.searchShipDateTo != undefined){ this.searchs.shipDateTo = store.state.searchShipDateTo; }
      if (store.state.searchStatus != null && store.state.searchStatus != undefined)  { this.searchs.status = store.state.searchStatus;   }
      if (store.state.searchOrderNos != null && store.state.searchOrderNos != undefined){ this.searchs.orderNo = store.state.searchOrderNos; }
    }

    // 日付ドライバー検索
    await this.changeShipDate();

    if (isBack == "true"){
      if (store.state.searchFlights != null && store.state.searchFlights != undefined)  { this.searchs.flights = store.state.searchFlights;   }
    }

    // 初回検索
    await this.search();
    // 20220812_hash-shi_タイマー再描画の停止_str------------
    // this.screenRedraw();
    // 20220812_hash-shi_タイマー再描画の停止_end------------

    //画面名称の設定
    document.title="出荷指示一覧"; 

    //画面の背景色の変更
    document.body.style.background  = "#ffffff";

    // 初期フォーカスの設定
    this.setNextField();
    // this.$nextTick(() => this.moveToNextField('orderNo'));
    this.$nextTick(() => $("#orderNo").focus());
  },
  
  computed: {
    pageResults() {
      var startIndex  = (this.pageNow - 1) * this.pageDataCount;
      var endIndex    = startIndex + this.pageDataCount;
      var that        = this;
      var result = this.sihRecords.sort(function(a, b){
        if (that.sortOrder == "asc"){
          if (a[that.sortKey] <  b[that.sortKey]) return -1;
          if (a[that.sortKey] >= b[that.sortKey]) return 1;
        }
        if (that.sortOrder == "desc"){
          if (a[that.sortKey] <  b[that.sortKey]) return 1;
          if (a[that.sortKey] >= b[that.sortKey]) return -1;
        }
      }).slice(startIndex,endIndex);

      if (this.pageOld != this.pageNow) {
        this.origin.DriverCode = [];
        for(var i = 0; i < result.length; i++) {
          this.origin.DriverCode.push(result[i].DRIVER_CODE);
          this.pageOld = this.pageNow
        }
      }

      return result;
    },
    pagingCount() {
      // 全ページが20ページ以内の場合はページングの間引きはしない
      this.isShowPageFirst = false;
      this.isShowPageLast  = false;
      if (this.pageCount <= 10){
        return this.pageCount;
      }

      // ページングの間引き対象
      var result = [];

      // 自ページよりも前のページをページングに格納
      var tempPrevMin = this.pageNow-5<1?1:this.pageNow-5;
      for (var count = tempPrevMin ; count < this.pageNow ; count++){ result.push(count); }
      
      // 自ページをページングに格納
      result.push(this.pageNow);
      
      // 自ページよりも後のページをページングに格納
      var tempPrevCount = result.length;
      var tempNextMax   = this.pageNow + 1 + 5 + (5 - tempPrevCount);
      if (tempNextMax >= this.pageCount){ tempNextMax = this.pageCount; }
      for (var count = this.pageNow + 1 ; count <= tempNextMax; count++){ result.push(count); }

      // それでもページを満たしていない場合は前ページよりも前に追加
      if (result.length < 10) {
        tempPrevMin-=1;
        for (; result.length < 10 ; tempPrevMin--)
        result.unshift(tempPrevMin);
      }

      // 生成したページング一覧にトップが含まれていない場合はトップへのページングを表示するフラグを立てる
      // ただし、生成したページングの先頭の値が1と連続する関係(つまり2)の場合は、...による接続は表示しない
      if (result.indexOf(1) == -1) {
        this.isShowPageFirst = true;
        this.isShowPageFirstDot = true;
        if (result[0] - 1 == 1){ this.isShowPageFirstDot = false; }
      }

      // 生成したページング一覧にラストが含まれていない場合はラストへのページングを表示するフラグを立てる
      // ただし、生成したページングの終端の値がラストと連続する関係(つまりラスト-1)の場合は、...による接続は表示しない
      if (result.indexOf(this.pageCount) == -1) {
        this.isShowPageLast = true;
        this.isShowPageLastDot = true;
        if (result[result.length - 1] + 1 == this.pageCount){ this.isShowPageLastDot = false; }
      }
      return result;
    }
  },
  filters:{
    decimalFormat:function(value) {
      if (!value) return ''
      if(value == 0) return ''
      return Number(value).toFixed(1);
    },
    decimalFormatZero:function(value) {
      if (!value) return 0
      if (value == '' || value == null) return 0
      return Number(value).toFixed(0);
    },
    upperCase:function(value) {
      if (!value) return ''
      return value.toUpperCase();
    },
    comma:function(value){
      if (!value) return ''
      return value.toString().replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    },
  },
};
</script>
<style scoped>
  td.nothing {
    background-color: yellow;
  }
  td.complete {
    background-color: gray;
    color: #ffffff;
  }
  td.hasTag {
    background-color: yellow;
  }
  td.difference  {
    background-color: yellow;
  }
  div.fukidashiTagNote {
    position: absolute;
    width: 300px;
    bottom: 28px;
    right: 10px;
    text-align: left;
    background-color: #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    padding: 5px;
    box-sizing: border-box;
    font-size: 14px;
    min-height: 28px;
    display: none;
  }
  div.datesNote {
    position: absolute;
    width: 200px;
    bottom: 28px;
    right: 10px;
    text-align: left;
    background-color: #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    padding: 5px;
    box-sizing: border-box;
    font-size: 14px;
    min-height: 28px;
    display: none;
  }
  div.sort {
    display: inline-block;
    position: relative;
  }
  div.sort > div.up {
    display: inline-block;
    cursor: pointer;
  }
  div.sort > div.down {
    display: inline-block;
    cursor: pointer;
  }
  div.sortSelect {
    color: #ff0000;
  }
  .hasKARI {
    background-color : rgb(207, 255, 207);
  }

  .awake {
    font-size: 20px;
    background-color: #ffff00;
    border-color: blue;
    border-radius: 3px;
    border-width: 2px;
  }
  .awake:hover{
    background-color: #e6e600;
  }
  .awake:focus{
    background-color: #e6e600;
  }
</style>