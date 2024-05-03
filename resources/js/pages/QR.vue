<template>
  <html>
    <head>
      <title>QRコードラベル印刷</title>
      <meta charset="utf-8"/>
    </head>
    <body>
      <div :inert="inert">
        <div>
          <input type="button" value="ラベル印刷" id="printButton"  v-bind:disabled="this.printDate == '' || (this.supplierCode == '' && this.warehouseCode == '') || this.itemCode == '' || this.qtyPer == '' || this.pattern == '' || this.numSheet == ''"  v-on:click="qrPrint" :ref="'printButton'" @keyup.enter="moveToNextField('printButton')">
          <pre></pre>

          <div class="tv">
            <div class="title">
              年月日
            </div>
            <div class="value">
              <input type="date" name="" value="2021-03-09" id="printDate" v-model="printDate" max="9999-12-31" v-on:change="printDateChange();" :ref="'printDate'" @keyup.enter="moveToNextField('printDate')">
              　　　　　　連番：{{ serialNumberSlice(lotSeq) }}
            </div>
          </div>
          <br />

          <div class="tv">
            <div class="title">
              仕入先
            </div>
            <div class="value">
              <input type="text" autocomplete="off" size="16" name="" value="" list="suppliers" v-model="supplierCode" v-on:change="supplierChange();" v-bind:disabled="this.warehouseCode != '' && this.warehouseCode != null" :ref="'supplierCode'" @keyup.enter="moveToNextField('supplierCode')">
              <datalist id="suppliers">
                <option v-for="suppliers in mstSuppliers" :key="suppliers.CODE" :value="suppliers.CODE">{{ suppliers.CODE }}:{{ suppliers.NAME }}</option>
              </datalist>
              <font-awesome-icon icon="times"  style="cursor:pointer;" v-on:click="supplierCode='';supplierChange();" />
              <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="opneDialog('SupplierSearch');" />
              <input type="text" disabled v-model="supplierName">
            </div>
          </div>
          <br />

          <div class="tv">
            <div class="title">
              倉庫
            </div>
            <div class="value">
              <input type="text" autocomplete="off" size="16" name="" value="" list="warehouses" v-model="warehouseCode" v-on:change="warehousesChange();" v-bind:disabled="this.supplierCode != '' && this.supplierCode != null" :ref="'warehouseCode'" @keyup.enter="moveToNextField('warehouseCode')">
              <datalist id="warehouses">
                <option v-for="warehouses in mstWarehouses" :key="warehouses.CODE" :value="warehouses.CODE">{{ warehouses.CODE }}:{{ warehouses.NAME }}</option>
              </datalist>
              <font-awesome-icon icon="times"  style="cursor:pointer;" v-on:click="warehouseCode='';warehousesChange();" />
              <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="opneDialog('WarehouseSearch');" />
              <input type="text" disabled v-model="warehouseName">
            </div>
          </div>
          <br />

          <div class="tv">
            <div class="title">
              商品
            </div>
            <div class="value">
              <input type="text" autocomplete="off" size="16" name="" value="" list="items" v-model="itemCode" v-on:change="itemChange();" id="item" :ref="'itemCode'" @keyup.enter="moveToNextField('itemCode')">
              <datalist id="items">
                <option v-for="item in mstItem" :key="item.CODE" :value="item.CODE">{{ item.CODE }}:{{ item.NAME }}</option>
              </datalist>
              <font-awesome-icon icon="times"  style="cursor:pointer;" v-on:click="itemCode='';itemChange();" />
              <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="opneDialog('ItemSearch');" />
              <input type="text" disabled v-model="itemName">
            </div>
          </div>

          <br />

          <div class="tv">
            <div class="title" id="div_qtyPer">
              入数
            </div>
            <div class="value">
              <input type="text" autocomplete="off" size="16" name="" value="" v-model="qtyPer" v-on:change="qtyPerChange();" id="qtyPer" :ref="'qtyPer'" @keyup.enter="moveToNextField('qtyPer')">
              <font-awesome-icon icon="times" v-on:click="qtyPer='';" style="cursor:pointer;" />
            </div>
          </div>

          <br />

          <div class="tv">
            <div class="title">
              形態
            </div>
            <div class="value">
              <!-- <input type="text" size="16" name="" value="" v-model="pattern" v-on:change="" id="pattern" v-bind:disabled="this.supplierName == '' || this.supplierName == null "> -->
              <select v-model="pattern" class="w170" :ref="'pattern'" @keyup.enter="moveToNextField('pattern')">
                <option value=""></option>
                <option v-for="pattern in patterns" :key="pattern.key" v-bind:value="pattern.value">
                  {{ pattern.value }}
                </option>
              </select>
              <font-awesome-icon icon="times" v-on:click="pattern='';" style="cursor:pointer;" />
            </div>
          </div>

          <br />

          <div class="tv">
            <div class="title" style="background-color: deepskyblue;">
              発行枚数
            </div>
            <div class="value">
              <input type="text" autocomplete="off" size="16" name="" v-model="numSheet" id="numSheet" maxLength=3 v-on:change="numSheet=changeNumber(numSheet);setNextField();" :ref="'numSheet'" @keyup.enter="moveToNextField('numSheet')">
              <font-awesome-icon icon="times" v-on:click="numSheet='';" style="cursor:pointer;" />
            </div>
          </div>

          <br />

          <div class="tv">
            <div class="title" style="background-color: deepskyblue;">
              開始位置
            </div>
            <div class="value">
              <input type="text" autocomplete="off"size="16" name="" v-model="startNum" id="startNum" maxLength=2 v-on:change="startNum=changeNumber(startNum);setNextField();" :ref="'startNum'" @keyup.enter="moveToNextField('startNum')">
              <font-awesome-icon icon="times" v-on:click="startNum='';" style="cursor:pointer;" />
            </div>
          </div>
        </div>
        <br />

        <table class="searchResult">
          <tr><th>ラベル発行履歴</th></tr>
        </table>
        {{ ((pageNow - 1) * pageDataCount) + (pageResults.length > 0 ? 1:0) }}件 から {{ ((pageNow - 1) * pageDataCount) + pageResults.length }}件 までを表示（全 {{ qrRecords.length }} 件）
        <br />

        <ul class="paging">
          <li v-if="pageNow!=1 && pageCount>0" v-on:click="pageNow=pageNow-1">&lt;</li>
          <li v-if="isShowPageFirst" :class="{'selected':1==pageNow}" v-on:click="pageNow=1">1</li>
          <li v-if="isShowPageFirst && isShowPageFirstDot">..</li>
          <li v-for="page of this.pagingCount" :key="page" :class="{'selected':page==pageNow}" v-on:click="pageNow=page">{{ page }}</li>
          <li v-if="isShowPageLast && isShowPageLastDot">..</li>
          <li v-if="isShowPageLast" :class="{'selected':pageCount==pageNow}" v-on:click="pageNow=pageCount">{{ pageCount }}</li>
          <li v-if="pageNow!=pageCount && pageCount>0" v-on:click="pageNow=pageNow+1">&gt;</li>
        </ul>
        <br />

        <input type="button" value="再発行" id="printButtonRe" v-on:click="qrPrintRe" v-bind:disabled="this.qrRecords == null || this.qrRecords.length==0" :ref="'printButtonRe'" @keyup.enter="moveToNextField('printButtonRe')">
        <table class="searchResult">
          <tr>
            
            <th class="w80">
              再発行
            </th>
            <th class="w120">
              年月日
              <div class="sort">
                <div class="down" v-bind:class="{sortSelect:sortKey=='PRINT_DATE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('PRINT_DATE', 'desc')" /></div>
                <div class="up"   v-bind:class="{sortSelect:sortKey=='PRINT_DATE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('PRINT_DATE', 'asc')" /></div>
              </div>
            </th>
            <th class="w100">
              連番
              <div class="sort">
                <div class="down" v-bind:class="{sortSelect:sortKey=='LOTSEQ'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('LOTSEQ', 'desc')" /></div>
                <div class="up"   v-bind:class="{sortSelect:sortKey=='LOTSEQ'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('LOTSEQ', 'asc')" /></div>
              </div>
            </th>
            <th class="w120">
              仕入先/倉庫
              <div class="sort">
                <div class="down" v-bind:class="{sortSelect:sortKey=='SW_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('SW_CODE', 'desc')" /></div>
                <div class="up"   v-bind:class="{sortSelect:sortKey=='SW_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('SW_CODE', 'asc')" /></div>
              </div>
            </th>
            <th class="w300">
              仕入先名/倉庫名
            </th>
            <th class="w120">
              商品
              <div class="sort">
                <div class="down" v-bind:class="{sortSelect:sortKey=='ITEM_CODE'&&sortOrder=='desc'}"><font-awesome-icon icon="sort-amount-down" v-on:click="setSort('ITEM_CODE', 'desc')" /></div>
                <div class="up"   v-bind:class="{sortSelect:sortKey=='ITEM_CODE'&&sortOrder=='asc' }"><font-awesome-icon icon="sort-amount-up-alt" v-on:click="setSort('ITEM_CODE', 'asc')" /></div>
              </div>
            </th>
            <th class="w300">
              商品名
            </th>
            <th class="w80">
              入数
            </th>
            <th class="w80">
              形態
            </th>
          </tr>
          <tr v-for="(pageResult, index) of this.pageResults" :key="index">

            <td style="text-align: center;">
              <input type="checkbox" name="check" v-model="pageResult.PRINT_FLG">
            </td>
            <td style="text-align: center;">
              {{ pageResult.PRINT_DATE }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.LOTSEQ }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.SW_CODE }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.SW_NAME }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.ITEM_CODE }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.ITEM_NAME }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.QTY_PER }}
            </td>
            <td style="text-align: center;">
              {{ pageResult.PATTERN }}
            </td>

          </tr>
        </table>
      </div>
      <!-- 仕入先 -->
      <SupplierSearchDialog   v-if="this.showDialog.SupplierSearch"  :officeCode="this.officeCode" :hCode="null" @close="closeDialog('SupplierSearch')"  @select="selectSupplierDialog"  ></SupplierSearchDialog>
      <!-- 倉庫 -->
      <WarehouseSearchDialog  v-if="this.showDialog.WarehouseSearch" :officeCode="this.officeCode" :hCode="null" @close="closeDialog('WarehouseSearch')" @select="selectWarehouseDialog" ></WarehouseSearchDialog>
      <!-- 商品 -->
      <ItemSearchDialog       v-if="this.showDialog.ItemSearch"      :searchHcode="this.hCode" :searchCustomerCode="null" :searchDeliveryCode="null" :searchSupplierCode="this.supplierCode" @close="closeDialog('ItemSearch')" @select="selectItemDialog" ></ItemSearchDialog>
    </body>
  </html>
</template>

<script>
import axios from 'axios';
import router from './../router'
import store from "./../store"
document.title="QRラベル印刷"; 

export default {
  computed: { },
  data() {
    return {
      officeCode: '',
    }
  },

  mounted: async function(){
    await axios.get("/api/qrPrintInit").then(response =>{
      this.printDate            = response.data.printDate;
      this.numSheet             = response.data.numSheet;
      this.officeCode           = response.data.officeCode;
      this.lotSeq               = response.data.lotSeq;
      this.screenRedrawInterval = response.data.screenRedrawInterval;
      // this.pattern              = response.data.pattern;
      // this.screenRedraw();
    });

    // 仕入先リスト
    await axios.post("/api/master/suppliers", { 'searchOfficeCode' : this.officeCode }).then(response => { 
      this.mstSuppliers = response.data;
    });

    // 倉庫リスト
    await axios.post("/api/master/warehouses", { 'searchOfficeCode' : this.officeCode }).then(response => { 
      this.mstWarehouses = response.data;
    });

    // 商品リスト
    await axios.post("/api/master/items", { 'searchSupplierCode' : this.supplierCode }).then(response => { 
      this.mstItem = response.data;
    });

    // Enter移動の設定をする
    this.setNextField();
    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField("printButtonRe"));

  },

  data() {
    return {

			// 画面ロック
			inert: false,   // 初期値の設定

			// ダイアログ表示フラグ
			showDialog: {
				"SupplierSearch": false,
				"WarehouseSearch": false,               // 倉庫検索ダイアログの表示・非表示管理フラグ
				"ItemSearch": false,                    // 商品検索ダイアログの表示・非表示管理フラグ
			},

      officeCode: "",
      printDate : "",
      lotSeq:"",                //日付連番

      hCode:2,                  // 取引区分、いずれはマスタ管理にする。

      mstSuppliers: [],         //仕入先リスト
      supplierCode:"",          //仕入先コード
      supplierName:"",          //仕入先名称

      mstWarehouses: [],        //倉庫リスト
      warehouseCode:"",         //倉庫コード
      warehouseName:"",         //倉庫名称

      mstItem:[],               //商品リスト
      itemCode:"",              //商品コード
      itemName:"",              //商品名称

      qtyPer:"",                //入数
      qtyPerOrg:"",             //元入数

      patterns :[
        { key: "A", value: "A", },
        { key: "B", value: "B", },
      ],                        //形態リスト
      pattern:"",               //形態

      numSheet:"",              //印刷枚数
      startNum:1,               //印刷開始位置
      screenRedrawInterval:"",  //画面更新間隔

      qrRecords:[],

      // 検索結果とソート
      sihRecords: [],
      sortKey: "printDate",
      sortOrder:"desc",
      isNotSureShipping: false,

      // ページング
      pageCount: 0,
      pageNow: 1,
      pageDataCount: 12,
      isShowPageFirst: false, isShowPageFirstDot: false,
      isShowPageLast: false,  isShowPageLastDot : false,

      //タイマー
      intervalSeach:null,

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
		closeDialog:function (dialog)   {
			this.setInert(false);
			this.showDialog[dialog] = false;
		},

		//-------------------------------------------------------------------------
		// 仕入先
		//-------------------------------------------------------------------------
    // ダイアログ選択値の格納、ダイアログを閉じる
    selectSupplierDialog: function(supplierCodes){
      this.supplierCode = supplierCodes;
      this.closeDialog('SupplierSearch');
      this.supplierChange();
      this.$nextTick(() => this.moveToNextField('supplierCode'));
    },
    // 仕入先変更(フォーカス外れ時イベント)
    supplierChange: async function(){

      // 桁数が4桁の場合は営業所コードを付ける。
      if (this.supplierCode.length == 4) { this.supplierCode = '148' + this.supplierCode; }

      // 仕入先名の検索・表示
      var that = this;
      var targetSuppliers = this.mstSuppliers.filter(function(row){ return row.CODE == that.supplierCode ? true : false; });
      if (targetSuppliers.length > 0){
        this.supplierName = targetSuppliers[0].NAME;
      } else {
        this.supplierName = "";
      }

      // 商品マスタの再取得が必要ないのなら、コードのリセットはいらない
      // 履歴の検索
      this.search();
      this.setNextField();
      // // 仕入先が変化したので、商品リストを再取得
      // await axios.post("/api/master/items", { 'searchSupplierCode' : this.supplierCode }).then(response => { this.mstItem = response.data; });
      // // 商品コードのリセット
      // this.itemCode = null;
      // this.itemChange();

    },

		//-------------------------------------------------------------------------
		// 倉庫
		//-------------------------------------------------------------------------
    // ダイアログ選択値の格納、ダイアログを閉じる
    selectWarehouseDialog: function(warehouseCodes){
      this.warehouseCode = warehouseCodes;
      this.closeDialog('WarehouseSearch');
      this.warehouseChange();
      this.$nextTick(() => this.moveToNextField('warehouseCode'));
    },
    // 倉庫変更(フォーカス外れ時イベント)
    warehousesChange: async function(){

      // 桁数が4桁の場合は営業所コードを付ける。
      if (this.warehouseCode.length == 4) { this.warehouseCode = '148' + this.warehouseCode; }

      // 倉庫名の検索・表示
      var that = this;
      var targetWarehouses = this.mstWarehouses.filter(function(row){ return row.CODE == that.warehouseCode ? true : false; });
      if (targetWarehouses.length > 0){
        this.warehouseName = targetWarehouses[0].NAME;
      } else {
        this.warehouseName = "";
      }

      // 商品マスタの再取得が必要ないのなら、コードのリセットはいらない
      // 履歴の検索
      this.search();
      this.setNextField();
      // // 倉庫が変化した場合、商品リストはなにも基準に変化するのか?
      // // 一旦なにもない状態で再取得を行う。
      // await axios.post("/api/master/items", { }).then(response => { this.mstItem = response.data; });
      // // 商品コードのリセット
      // this.itemCode = null;
      // this.itemChange();

    },

		//-------------------------------------------------------------------------
		// 商品
		//-------------------------------------------------------------------------
    // 商品ダイアログで選択した得意先を格納してダイアログを閉じる
    selectItemDialog: function(item){
      this.itemCode=item.CODE;
      this.closeDialog('ItemSearch');
      this.itemChange();
      this.$nextTick(() => this.moveToNextField('itemCode'));
    },
    // 商品変更(フォーカス外れ時イベント)
    itemChange: async function(){

      // 商品名の検索・表示
      var that = this;
      var targetItems = this.mstItem.filter(function(row){ return row.CODE == that.itemCode ? true : false; });
      if (targetItems.length > 0){
        this.itemName   = targetItems[0].NAME;
        this.qtyPer     = targetItems[0].QTY_PER_CTN;
        this.qtyPerOrg  = targetItems[0].QTY_PER_CTN;
        this.pattern    = "A";
      } else {
        this.itemName   = "";
        this.qtyPer     = "";
        this.qtyPerOrg  = "";
        this.pattern    = "";
      }

      // 入数
      this.qtyPerChange();

      // 履歴の検索
      this.search();
      this.setNextField();
    },

    // 入数変更(フォーカス外れ時イベント)
    qtyPerChange:function() {
      this.qtyPer = this.changeNumber(this.qtyPer);
      this.qtyPerOrg = this.changeNumber(this.qtyPerOrg);

      // デフォルト数と異なる場合
      if (this.qtyPer != this.qtyPerOrg) {
        $('#div_qtyPer').css("background-color", "Yellow");
      } else {
        $('#div_qtyPer').css("background-color", "#eeeeee");
      }
      this.setNextField();
    },


    //QRコードラベルの印刷
    qrPrint: async function(){

      // 最後に最新の連番を取得しなおす。
      await axios.post("api/serialNumberChange", { "printDate" : this.printDate }).then (response =>{
        this.lotSeq = response.data.lotSeq;
      });
      
      // 登録処理
      await axios.post("/api/qrPrint/regist", {
        'printDate'     : this.printDate,
        'lotseq'        : this.lotSeq,
        'supplierCode'  : this.supplierCode,
        'warehouseCode' : this.warehouseCode,
        'itemCode'      : this.itemCode,
        'qtyPer'        : this.qtyPer,
        'pattern'       : this.pattern,
        'numSheet'      : this.numSheet,
        'startNum'      : this.startNum,
      }).then(response => {

        // 印刷データID
        var printResultID = response.data.printResultID;

        axios.get("api/resetSession/",{}).then (response =>{
          
          // 印刷
          window.open("/qrPrint/" + printResultID, "印刷ページ");
          // 最新連番取得
          axios.post("api/serialNumberChange", { "printDate" : this.printDate }).then (response =>{ this.lotSeq = response.data.lotSeq; });

        });
      });
    },

    // 再印刷
    qrPrintRe: async function(){
      
      // 一覧からチェックされているデータを取得する。
      var rePrintDates = this.qrRecords.filter((qrRecord) => qrRecord.PRINT_FLG == true);
      // そのまま送り返してもいいがサイズ縮小も兼ねてIDのみにする。
      var rePrintIds = new Array();
      for (var i = 0; i < rePrintDates.length; i++) {
        rePrintIds.push(rePrintDates[i]['ID']);
      }

      // 登録処理
      await axios.post("/api/qrPrint/rePrint", {
        'startNum'      : this.startNum,
        'rePrintIds'    : rePrintIds,
      }).then(response => {

        var printResultID = response.data.printResultID;

        axios.get("api/resetSession/",{}).then (response =>{

          // 印刷
          window.open("/qrPrint/" + printResultID, "印刷ページ");
          // 最新連番取得
          axios.post("api/serialNumberChange", { "printDate" : this.printDate }).then (response =>{ this.lotSeq = response.data.lotSeq; });

        });
      });
    },

    // 日付変更(フォーカス外れ時イベント)
    printDateChange : async function(){
      await axios.post("api/serialNumberChange", { "printDate" : this.printDate }).then (response =>{
        this.lotSeq = response.data.lotSeq;
      });

      // 日付は変更しても仕入先のリセットはしない。

      // 履歴の検索
      this.search();
      this.setNextField();
    },

    // 連番を0詰めする
    serialNumberSlice : function(lotSeq) {
      lotSeq = parseInt(lotSeq);
      if (lotSeq == 0) { lotSeq = 1; }
      lotSeq = ('000000' + lotSeq).slice(-6);
      return lotSeq;
    },

    // その他--------------------------------------------------------------------------------

    // 数値のみに変換する
    changeNumber : function(value){

      if (!value) { return ''; }
      var m = String(value).match(/^[0-9]+$/);
      if (0 < m) { return value; }

      // 全角を半角に変換
      value = value.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
          return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
      });

      // 数値に変換(変換できない文字列は無視される)
      value = parseFloat(value);
      return value;
    }, 

    //半角の大文字に変換する
    changeHarf:function(value){
      value=value.replace("あ","A")
      value=value.replace("い","I")
      value=value.replace("う","U")
      value=value.replace("え","E")
      value=value.replace("お","O")
      value = value.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
      });
      value = value.replace( /[^ア-ﾟ!-~]/g , "" );
      return value.toUpperCase();
    },

    // 発行履歴の取得
    search : async function(){

      this.qrRecords = [];
      this.pageNow = 0;
      this.pageCount = 0;

      await axios.post("api/qrPrint/search", { 
        'printDate'     : this.printDate,
        'supplierCode'  : this.supplierCode,
        'warehouseCode' : this.warehouseCode,
        'itemCode'      : this.itemCode,
      }).then(response => {
        this.qrRecords = response.data;
        this.pageNow = 1;
        this.pageCount = Math.ceil(this.qrRecords.length / this.pageDataCount);
        this.setNextField()
      });
    },

    // 並び順設定
    setSort: function(sortKey, sortOrder){
      this.sortKey = sortKey;
      this.sortOrder = sortOrder;
    },

    pdfPrint : async function(pdfName) {
      await axios.get("api/resetSession" , {}).then (response =>{
        window.open("/pdfPrint/" + pdfName, "印刷ページ");
      });
    },

		//---------------------------------------------------------------------
		// タブキーorEnterキー
		//---------------------------------------------------------------------
		setNextField() {
			// Enter移動の設定をする
			this.nextFields = []
			this.nextFields.push({ 'id':'printButton', 'disabled': (this.printDate == '' || (this.supplierCode == '' && this.warehouseCode == '') || this.itemCode == '' || this.qtyPer == '' || this.pattern == '' || this.numSheet == ''), });
			this.nextFields.push({ 'id':'printDate', 'disabled': false, });
      this.nextFields.push({ 'id':'supplierCode', 'disabled': (this.warehouseCode != '' && this.warehouseCode != null), });
			this.nextFields.push({ 'id':'warehouseCode', 'disabled': (this.supplierCode != '' && this.supplierCode != null), });
			this.nextFields.push({ 'id':'itemCode', 'disabled': false, });
			this.nextFields.push({ 'id':'qtyPer', 'disabled': false, });
			this.nextFields.push({ 'id':'pattern', 'disabled': false, });
			this.nextFields.push({ 'id':'numSheet', 'disabled': false, });
			this.nextFields.push({ 'id':'startNum', 'disabled': false, });
      this.nextFields.push({ 'id':'printButtonRe', 'disabled': (this.qrRecords == null || this.qrRecords.length==0), });
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

 computed : {

    pageResults(){

        var startIndex      = (this.pageNow - 1) *  this.pageDataCount;
        var endIndex        = startIndex + this.pageDataCount;
        var that            = this;

        if (this.qrRecords == null) { return []; }

        return this.qrRecords.sort(function(a, b){
          if (that.sortOrder == "asc"){
            if (that.sortKey == 'LOTSEQ') {
              if (parseInt(a[that.sortKey]) < parseInt(b[that.sortKey])) return -1;
              if (parseInt(a[that.sortKey]) >= parseInt(b[that.sortKey])) return 1;
            } else {
              if (a[that.sortKey] <  b[that.sortKey]) return -1;
              if (a[that.sortKey] >= b[that.sortKey]) return 1;
            }
          }
          if (that.sortOrder == "desc"){
            if (that.sortKey == 'LOTSEQ') {
              if (parseInt(a[that.sortKey]) <  parseInt(b[that.sortKey])) return 1;
              if (parseInt(a[that.sortKey]) >= parseInt(b[that.sortKey])) return -1;
            } else {
              if (a[that.sortKey] <  b[that.sortKey]) return 1;
              if (a[that.sortKey] >= b[that.sortKey]) return -1;
            }
          }
        }).slice(startIndex,endIndex);
    },

    pagingCount(){
        // 全ページが10ページ以内の場合はページングの間引きはしない
        this.isShowPageFirst = false;
        this.isShowPageLast  = false;
        if (this.pageCount <= 10){
            return this.pageCount;
        }

        // ページングの間引き対象
        var result = [];

        // 自ページよりも前のページをページングに格納
        var tempPrevMin = ((this.pageNow - 5 < 1) ? 1 : this.pageNow - 5);
        for (var count = tempPrevMin ; count < this.pageNow ; count++){ result.push(count); }
        
        // 自ページをページングに格納
        result.push(this.pageNow);
        
        // 自ページよりも後のページをページングに格納
        var tempPrevCount = result.length;
        var tempNextMax   = this.pageNow + 1 + 5 + (5 - tempPrevCount);
        if (tempNextMax >= this.pageCount){ tempNextMax = this.pageCount; }
        for (var count = this.pageNow + 1 ; count <= tempNextMax; count++){ result.push(count); }

        // それでもページを満たしていない場合は前ページよりも前に追加
        if (result.length < 10){
            tempPrevMin-=1;
            for (; result.length < 10 ; tempPrevMin--)
            result.unshift(tempPrevMin);
        }

        // 生成したページング一覧にトップが含まれていない場合はトップへのページングを表示するフラグを立てる
        // ただし、生成したページングの先頭の値が1と連続する関係(つまり2)の場合は、...による接続は表示しない
        if (result.indexOf(1) == -1){
            this.isShowPageFirst = true;
            this.isShowPageFirstDot = true;
            if (result[0] - 1 == 1){ this.isShowPageFirstDot = false; }
        }

        // 生成したページング一覧にラストが含まれていない場合はラストへのページングを表示するフラグを立てる
        // ただし、生成したページングの終端の値がラストと連続する関係(つまりラスト-1)の場合は、...による接続は表示しない
        if (result.indexOf(this.pageCount) == -1){
            this.isShowPageLast = true;
            this.isShowPageLastDot = true;
            if (result[result.length - 1] + 1 == this.pageCount){ this.isShowPageLastDot = false; }
        }
        return result;
    }

 },
}
</script>

<style scoped>
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
</style>

