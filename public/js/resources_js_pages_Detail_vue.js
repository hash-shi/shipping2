(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Detail_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./../router */ "./resources/js/router.js");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./../store */ "./resources/js/store.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      // 画面ロック
      inert: false,
      // 初期値の設定
      // ダイアログ表示フラグ
      showDialog: {
        'CustomerSearch': false,
        // 得意先検索ダイアログの表示・非表示管理フラグ
        'DeliverySearchDelivery': false,
        // 納入先検索ダイアログの表示・非表示管理フラグ(納／倉)
        'WarehouseSearchDelivery': false,
        // 倉庫検索ダイアログの表示・非表示管理フラグ(納／倉)
        'SupplierSearch': false,
        // 仕入先検索ダイアログの表示・非表示管理フラグ
        'WarehouseSearch': false,
        // 倉庫検索ダイアログの表示・非表示管理フラグ
        'DriverSearch': false,
        // 運転手検索ダイアログの表示・非表示管理フラグ
        'ItemSearch': false,
        // 商品検索ダイアログの表示・非表示管理フラグ
        'ItemSearchIndex': -1,
        // 商品検索ダイアログの検索結果格納先Index(明細が複数存在している為)
        'OfficeSearch': false,
        // 営業所検索ダイアログの表示・非表示管理フラグ
        'InputShippingCp': false // 複写ダイアログの表示・非表示管理フラグ

      },
      // ドロップダウン元ネタ
      mstUsers: [],
      mstCustomers: [],
      mstDeliveries: [],
      mstSuppliers: [],
      mstWarehouses: [],
      mstDrivers: [],
      mstHCodesD: [],
      mstPlaces: [],
      mstRemarks: [],
      mstItems: [],
      mstOffices: [],
      // 営業所コード
      officeCode: "",
      // 相手営業所コード
      officeOtherCode: "",
      // ヘッダーとボディデータ
      sihRecord: {
        'STATUS': 0
      },
      sidRecords: [],
      //一時保存値
      orgOfficeOtherCode: "",
      orgCustomerCode: "",
      orgDeliveryCode: "",
      orgSuppliersCode: "",
      orgWarehousesCode: "",
      orgDriversCode: "",
      // 新規or更新
      isNew: true
    };
  },
  methods: {
    //-------------------------------
    // 初期処理
    //-------------------------------
    init: function () {
      var _init = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(sihId, orderNo, hCode, shipDate, userCode, sihIdBase) {
        var _this = this;

        var URL;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                URL = "";

                if (sihId != "" && orderNo != "" && hCode != "" && shipDate != "" && userCode != "" && sihIdBase) {
                  URL = "/api/shippingDetail/" + sihId + "/" + orderNo + "/" + hCode + "/" + shipDate + "/" + userCode + "/" + sihIdBase;
                } else if (sihId != "" && orderNo != "" && hCode != "" && shipDate != "" && userCode != "") {
                  URL = "/api/shippingDetail/" + sihId + "/" + orderNo + "/" + hCode + "/" + shipDate + "/" + userCode;
                } else if (sihId != "") {
                  URL = "/api/shippingDetail/" + sihId;
                }

                _context.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().get(URL, {}).then(function (response) {
                  //---------------------------------------------------------------------
                  // 表示するデータの確定
                  //---------------------------------------------------------------------
                  _this.isNew = response.data.isNew;
                  _this.sihRecord = response.data.sihRecord;
                  _this.sidRecords = response.data.sidRecords;
                  _this.officeCode = response.data.officeCode;
                });

              case 4:
                //画面名称の設定
                document.title = "出荷指示: " + this.sihRecord.ORDER_NO; //初期得意先の設定

                this.orgOfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE;
                this.orgCustomerCode = this.sihRecord.CUSTOMER_CODE;
                this.orgDeliveryCode = this.sihRecord.DELIVERY_CODE;
                this.orgSuppliersCode = this.sihRecord.SUPPLIER_CODE;
                this.orgWarehousesCode = this.sihRecord.WAREHOUSE_CODE;
                this.orgDriversCode = this.sihRecord.DRIVER_CODE; // 相手営業所がない場合は、自営業所を格納する。

                if (this.sihRecord.OFFICE_OTHER_CODE == null) {
                  this.officeOtherCode = this.officeCode;
                  this.orgOfficeOtherCode = "";
                } //画面表示時にコンマ表示を行う


                this.sihRecord.FEE = this.comma(this.sihRecord.FEE);
                this.sihRecord.ADD_FEE = this.comma(this.sihRecord.ADD_FEE);
                this.sihRecord.HIGHWAY_FEE = this.comma(this.sihRecord.HIGHWAY_FEE); //背景色の変更
                // 仮

                if (this.sihRecord.KARI == 1) {
                  // 仮
                  document.body.style.background = 'rgb(223, 255, 223)'; // 緑
                } else {
                  if (this.sihRecord.STATUS == 0) {
                    // 通常
                    document.body.style.background = 'rgb(223, 255, 255)'; // 青
                  } else if (this.sihRecord.STATUS == 1) {
                    // 入力確定
                    document.body.style.background = 'rgb(255, 255, 223)'; // 黄
                  } else if (this.sihRecord.STATUS == 3) {
                    // 端数完了
                    document.body.style.background = 'rgb(255, 223, 159)'; // 橙
                  } else if (this.sihRecord.STATUS == 2) {
                    // 出荷完了
                    document.body.style.background = 'rgb(255, 223, 223)'; // 赤
                  }
                } // 読込回数が多いのでまとめて取得できないか？


                _context.next = 18;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/master/detail", {
                  'HCODE': this.sihRecord.HCODE
                }).then(function (response) {
                  var data = response.data;
                  _this.mstUsers = data.users;
                  _this.mstCustomers = data.customers;
                  _this.mstDeliveries = data.deliveries;
                  _this.mstSuppliers = data.suppliers;
                  _this.mstWarehouses = data.warehouses;
                  _this.mstDrivers = data.drivers;
                  _this.mstHCodesD = data.hcodesD;
                  _this.mstPlaces = data.places;
                  _this.mstRemarks = data.remarks;
                  _this.mstOffices = data.offices;
                });

              case 18:
                this.officeOtherC2N();
                this.officeOtherBlur();
                this.deliveryC2N();
                this.deliveryBlur();
                this.supplierC2N();
                this.supplierBlur(); // 初期フォーカスの設定

                this.setNextField();
                this.$nextTick(function () {
                  return _this.moveToNextField('deliveryTime');
                }); // this.$nextTick(() => $("#orderDate").focus());

              case 26:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function init(_x, _x2, _x3, _x4, _x5, _x6) {
        return _init.apply(this, arguments);
      }

      return init;
    }(),
    //-------------------------------------------------------------------------
    // 画面上部ボタンイベント
    //-------------------------------------------------------------------------
    // 戻る
    back: function back() {
      // 検索条件保持したまま戻りたいので、その方法を検討
      // ローカルストレージかなぁ・・・
      if (this.sihRecord.STATUS == 99) {
        if (confirm("未保存データです。削除しますか？")) {
          _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
        }
      } else {
        _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
      }
    },
    // 複写
    copy: function copy() {
      this.opneDialog('InputShippingCp');
    },
    copyDetail: function copyDetail(sihId, hCode, shipDate, userCode, sihIdBase) {
      this.closeDialog('InputShippingCp');
      _router__WEBPACK_IMPORTED_MODULE_2__.default.push({
        path: "/detail/" + sihId + "_" + hCode + "_" + shipDate + "_" + userCode + "_" + sihIdBase
      });
    },
    // 一時保存
    susp: function () {
      var _susp = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var _this2 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!confirm("一時保存します。よろしいですか？")) {
                  _context2.next = 3;
                  break;
                }

                _context2.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/shipping/susp", {
                  'isNew': this.isNew,
                  'sihRecord': this.sihRecord,
                  'sidRecords': this.sidRecords
                }).then(function (response) {
                  var sihId = response.data.SIH_ID;
                  var orderNo = response.data.ORDER_NO;
                  alert("保存しました。" + "\r\n" + "受注No：" + orderNo);

                  _this2.init(sihId, orderNo, "", "", "", "");
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function susp() {
        return _susp.apply(this, arguments);
      }

      return susp;
    }(),
    // 入力確定
    conf: function () {
      var _conf = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!confirm("入力確定をします。よろしいですか？")) {
                  _context3.next = 3;
                  break;
                }

                _context3.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/shipping/conf", {
                  'isNew': this.isNew,
                  'sihRecord': this.sihRecord,
                  'sidRecords': this.sidRecords
                }).then(function (response) {
                  var sihId = response.data.SIH_ID;
                  var orderNo = response.data.ORDER_NO;
                  alert("確定しました。" + "\r\n" + "受注No：" + orderNo); // this.init(sihId, orderNo, "", "", "", "");

                  _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function conf() {
        return _conf.apply(this, arguments);
      }

      return conf;
    }(),
    // 出荷完了
    comp: function () {
      var _comp = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (!confirm("出荷完了をします。よろしいですか？")) {
                  _context4.next = 3;
                  break;
                }

                _context4.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/shipping/comp", {
                  'isNew': this.isNew,
                  'sihRecord': this.sihRecord,
                  'sidRecords': this.sidRecords
                }).then(function (response) {
                  var sihId = response.data.SIH_ID;
                  var orderNo = response.data.ORDER_NO;
                  alert("完了しました。" + "\r\n" + "受注No：" + orderNo); // this.init(sihId, orderNo, "", "", "", "");

                  _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
                });

              case 3:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, this);
      }));

      function comp() {
        return _comp.apply(this, arguments);
      }

      return comp;
    }(),
    // 削除
    del: function () {
      var _del = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!confirm("本当に削除してもよろしいですか？")) {
                  _context5.next = 3;
                  break;
                }

                _context5.next = 3;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().delete("/api/shipping/", {
                  data: {
                    'sihId': this.sihRecord["SIH_ID"]
                  }
                }).then(function (response) {
                  alert("削除しました。");
                  _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
                });

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, this);
      }));

      function del() {
        return _del.apply(this, arguments);
      }

      return del;
    }(),
    // 指示書入力
    instructionPrint: function () {
      var _instructionPrint = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/shipping/conf", {
                  'isNew': this.isNew,
                  'sihRecord': this.sihRecord,
                  'sidRecords': this.sidRecords
                }).then(function (response) {
                  var sihId = response.data.SIH_ID;
                  var orderNo = response.data.ORDER_NO;
                  window.open("/shipping/instructionPrint/" + sihId); // this.init(sihId, orderNo, "", "", "", "");

                  _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
                });

              case 2:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6, this);
      }));

      function instructionPrint() {
        return _instructionPrint.apply(this, arguments);
      }

      return instructionPrint;
    }(),
    // 伝票印刷
    slipPrint: function () {
      var _slipPrint = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/shipping/conf", {
                  'isNew': this.isNew,
                  'sihRecord': this.sihRecord,
                  'sidRecords': this.sidRecords
                }).then(function (response) {
                  var sihId = response.data.SIH_ID;
                  var orderNo = response.data.ORDER_NO;
                  window.open("/shipping/slipPrint/" + sihId); // this.init(sihId, orderNo, "", "", "", "");

                  _router__WEBPACK_IMPORTED_MODULE_2__.default.push("/?isBack=true");
                });

              case 2:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7, this);
      }));

      function slipPrint() {
        return _slipPrint.apply(this, arguments);
      }

      return slipPrint;
    }(),
    // 日時フォーマット
    toDateTimeComp: function toDateTimeComp(dateObj) {
      if (dateObj == null) {
        return "";
      }

      var dateValue = dateObj.substr(0, 16).split("-").join("/");
      return dateValue;
    },
    // 在庫照会
    openStocksDetail: function openStocksDetail(itemCode) {
      if (_store__WEBPACK_IMPORTED_MODULE_3__.default.state.stocksDetailURL == null || _store__WEBPACK_IMPORTED_MODULE_3__.default.state.stocksDetailURL == "") {
        alert("在庫詳細のURLが設定されていません");
        return;
      }

      var linkURL = _store__WEBPACK_IMPORTED_MODULE_3__.default.state.stocksDetailURL;
      linkURL += "?sub=1";
      linkURL += "&ITEM_CODE=" + encodeURIComponent(itemCode);
      linkURL += "&WAREHOUSE_CODE=" + (this.sihRecord.WAREHOUSE_CODE == null || this.sihRecord.WAREHOUSE_CODE == "" ? "" : encodeURI(this.sihRecord.WAREHOUSE_CODE));
      linkURL += "&user_code=Nologin";
      window.open(linkURL, 'sub', 'width=600,height=400,scrollbars=yes');
    },
    //-------------------------------------------------------------------------
    // ダイアログのオープンクローズ
    //-------------------------------------------------------------------------
    setInert: function setInert(value) {
      this.inert = value;
    },
    opneDialog: function opneDialog(dialog) {
      this.setInert(true);
      this.showDialog[dialog] = true;
    },
    closeDialog: function closeDialog(dialog) {
      this.setInert(false);
      this.showDialog[dialog] = false;
    },
    //-------------------------------------------------------------------------
    // ダイアログのオープンクローズ
    //-------------------------------------------------------------------------
    showInformation: function showInformation(event) {
      $(event.currentTarget).find("div.information").show();
    },
    hideInformation: function hideInformation(event) {
      $(event.currentTarget).find("div.information").hide();
    },
    //-------------------------------------------------------------------------
    // Code2Name
    //-------------------------------------------------------------------------
    // 相手営業所
    officeOtherC2N: function officeOtherC2N() {
      var that = this;
      var targetOffices = this.mstOffices.filter(function (row) {
        return row.CODE == that.sihRecord.OFFICE_OTHER_CODE ? true : false;
      });

      if (targetOffices.length > 0) {
        // 営業所コードを格納(仕入先/倉庫/運転手で使用する。)
        this.officeOtherCode = targetOffices[0].CODE;
        this.sihRecord.OFFICE_OTHER_NAME = targetOffices[0].NAME;
      } else {
        // デフォルト(自分自身)に戻す。
        this.officeOtherCode = this.officeCode;
        this.sihRecord.OFFICE_OTHER_NAME = "";
      }
    },
    // 得意先
    customerC2N: function customerC2N() {
      var that = this;
      var targetCustomers = this.mstCustomers.filter(function (row) {
        return row.CODE == that.sihRecord.CUSTOMER_CODE ? true : false;
      });

      if (targetCustomers.length > 0) {
        this.sihRecord.CUSTOMER_NAME = targetCustomers[0].NAME;
      } else {
        this.sihRecord.CUSTOMER_NAME = "";
      }
    },
    // 納入先
    deliveryC2N: function deliveryC2N() {
      //this.sihRecord.DELIVERY_CODE !=null ?this.sihRecord.DELIVERY_CODE.replace( /[^0-9]/g ,"" ):"";
      var that = this;
      var targetDeliveries = null; // 取区が通常の場合

      if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4) {
        targetDeliveries = this.mstDeliveries.filter(function (row) {
          return row.CODE == that.sihRecord.DELIVERY_CODE ? true : false;
        });
      } // 取区が仕入・融通の場合


      if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4) {
        targetDeliveries = this.mstWarehouses.filter(function (row) {
          return row.CODE == that.sihRecord.DELIVERY_CODE ? true : false;
        });
      }

      if (targetDeliveries != null && targetDeliveries.length > 0) {
        this.sihRecord.DELIVERY_NAME = targetDeliveries[0].NAME;
      } else {
        this.sihRecord.DELIVERY_NAME = "";
      }
    },
    // 仕入先
    supplierC2N: function supplierC2N() {
      var that = this;
      var targetSuppliers = this.mstSuppliers.filter(function (row) {
        return row.CODE == that.sihRecord.SUPPLIER_CODE ? true : false;
      });

      if (targetSuppliers.length > 0) {
        this.sihRecord.SUPPLIER_NAME = targetSuppliers[0].NAME;
      } else {
        this.sihRecord.SUPPLIER_NAME = "";
      }
    },
    // 倉庫
    warehouseC2N: function warehouseC2N() {
      var that = this;
      var targetWarehouses = this.mstWarehouses.filter(function (row) {
        return row.CODE == that.sihRecord.WAREHOUSE_CODE ? true : false;
      });

      if (targetWarehouses.length > 0) {
        this.sihRecord.WAREHOUSE_NAME = targetWarehouses[0].NAME;
      } else {
        this.sihRecord.WAREHOUSE_NAME = "";
      }
    },
    // 運転手
    driverC2N: function driverC2N() {
      var that = this;
      var targetDrivers = this.mstDrivers.filter(function (row) {
        return row.COMPANY_CODE == that.officeCode && row.CODE == that.sihRecord.DRIVER_CODE ? true : false;
      });

      if (targetDrivers.length > 0) {
        this.sihRecord.DRIVER_NAME = targetDrivers[0].NAME;
        this.sihRecord.TRUCKER_CODE = targetDrivers[0].TRUCKER_CODE;
        this.sihRecord.TRUCKER_NAME = targetDrivers[0].TRUCKER_NAME;
      } else {
        this.sihRecord.DRIVER_NAME = "";
        this.sihRecord.TRUCKER_CODE = "";
        this.sihRecord.TRUCKER_NAME = "";
      }
    },
    //-------------------------------------------------------------------------
    // 商品の表示反映
    //-------------------------------------------------------------------------
    itemUpdate: function itemUpdate(index) {
      for (var count = 0; count < this.sidRecords.length; count++) {
        if (index != undefined) {
          if (index != count) {
            continue;
          }
        }

        if (this.sidRecords[count]["items_rel"] != null) {
          this.sidRecords[count].ITEM_NAME = this.sidRecords[count]["items_rel"].NAME;

          if (index != undefined) {
            this.sidRecords[count].QTY_PER_CTN = this.sidRecords[count]["items_rel"].QTY_PER_CTN;
          }

          if (this.sihRecord.LOADING_RATE == "1") {
            this.sidRecords[count].QTY_CTN2 = this.sidRecords[count]["items_rel"].RATE1;
          } else if (this.sihRecord.LOADING_RATE == "2") {
            this.sidRecords[count].QTY_CTN2 = this.sidRecords[count]["items_rel"].RATE2;
          } else if (this.sihRecord.LOADING_RATE == "3") {
            this.sidRecords[count].QTY_CTN2 = this.sidRecords[count]["items_rel"].RATE3;
          }
        } else {
          this.sidRecords[count].ITEM_NAME = null;
          this.sidRecords[count].QTY_PER_CTN = null;
          this.sidRecords[count].QTY_CTN2 = null;
        }
      }
    },
    //-------------------------------------------------------------------------
    // フォーカス外れ時イベント(4桁チェックなど)
    //-------------------------------------------------------------------------
    // 相手営業所(フォーカス外れ時イベント)
    officeOtherBlur: function officeOtherBlur() {
      if (this.sihRecord.OFFICE_OTHER_CODE == null) {
        // デフォルト(自分自身)に戻す。
        this.officeOtherCode = this.officeCode;
        return;
      } // 元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgOfficeOtherCode != null) {
        if (this.sihRecord.OFFICE_OTHER_CODE != this.orgOfficeOtherCode) {
          // 仕入先/倉庫/運転手をクリアする。
          this.sihRecord.SUPPLIER_CODE = "";
          this.sihRecord.SUPPLIER_NAME = "";
          this.sihRecord.WAREHOUSE_CODE = "";
          this.sihRecord.WAREHOUSE_NAME = "";
          this.sihRecord.DRIVER_CODE = "";
          this.sihRecord.DRIVER_NAME = "";
          this.sihRecord.TRUCKER_CODE = "";
          this.sihRecord.TRUCKER_NAME = ""; //元値を新しい値に変更する

          this.orgOfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE; // 存在確認

          var that = this;
          var targetOffices = this.mstOffices.filter(function (row) {
            return row.CODE == that.sihRecord.OFFICE_OTHER_CODE ? true : false;
          });

          if (targetOffices.length == 0) {
            alert("営業所コードが登録されていません。");
            officesOtherCode.focus();
            return;
          }
        }
      } //元値を新しい値に変更する


      this.orgOfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE;
      this.officeOtherC2N();
    },
    // 得意先(フォーカス外れ時イベント)
    customerBlur: function customerBlur() {
      if (this.sihRecord.CUSTOMER_CODE == null) {
        return;
      } //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgCustomerCode != null) {
        // 桁数を揃える
        if (1 <= this.sihRecord.CUSTOMER_CODE.length && this.sihRecord.CUSTOMER_CODE.length <= 4) {
          this.sihRecord.CUSTOMER_CODE = this.officeCode + this.sihRecord.CUSTOMER_CODE.padStart(4, '0');
        } // 変更されているか確認


        if (this.sihRecord.CUSTOMER_CODE != this.orgCustomerCode) {
          this.sihRecord.DELIVERY_CODE = "";
          this.sihRecord.DELIVERY_NAME = "";

          for (var count = 0; count < this.sidRecords.length; count++) {
            this.sidRecords[count].HCODE = null;
            this.sidRecords[count].ITEM_CODE = null;
            this.sidRecords[count].ITEM_NAME = null;
            this.sidRecords[count].QTY_PER_CTN = null;
            this.sidRecords[count].QTY_CTN = null;
            this.sidRecords[count].QTY = null;
            this.sidRecords[count].QTY_CTN2 = null;
            this.sidRecords[count].QTY2 = null; // 20220720_hash-shi_明細クリア_str------------
            // this.sidRecords[count].LOADING_PLACE = null;

            this.sidRecords[count].LOADING_PLACE_CODE = null;
            this.sidRecords[count].LOADING_PLACE_NAME = null; // 20220720_hash-shi_明細クリア_end------------

            this.sidRecords[count].REMARK1 = null;
            this.sidRecords[count].REMARK2 = null;
          } // 20220720_hash-shi_明細クリア_str------------


          this.sihRecord.CONTINUED_SHEET = null;
          this.sihRecord.CURRENT_SHEET = null;
          this.sihRecord.ALL_SHEET = null;
          this.sihRecord.INVOICE_NOTE = null;
          this.sihRecord.DELIVERY_NOTE = null;
          this.sihRecord.TAG_NOTE = null; // 20220720_hash-shi_明細クリア_end------------
          // 元値を新しい値に変更する

          this.orgCustomerCode = this.sihRecord.CUSTOMER_CODE; // 得意先コードに含まれているかをチェックする。
          // あんまりチェックする意義が無いが一応追加する。

          var that = this;
          var targetCustomers = this.mstCustomers.filter(function (row) {
            return row.CODE == that.sihRecord.CUSTOMER_CODE ? true : false;
          });

          if (targetCustomers.length == 0) {
            alert("得意先コードが登録されていません。");
            customerCode.focus();
            return;
          }
        }
      } // 元値を新しい値に変更する


      this.orgCustomerCode = this.sihRecord.CUSTOMER_CODE;
      this.customerC2N();
    },
    // 納入先(フォーカス外れ時イベント)
    deliveryBlur: function deliveryBlur() {
      if (this.sihRecord.DELIVERY_CODE == null) {
        return;
      } // 20220706_hash-shi_納入先変更で明細クリア_str------------
      // 元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgDeliveryCode != null) {
        // 桁揃え
        if (1 <= this.sihRecord.DELIVERY_CODE.length && this.sihRecord.DELIVERY_CODE.length <= 4) {
          this.sihRecord.DELIVERY_CODE = this.officeCode + this.sihRecord.DELIVERY_CODE.padStart(4, '0');
        }

        if (this.sihRecord.DELIVERY_CODE != this.orgDeliveryCode) {
          for (var count = 0; count < this.sidRecords.length; count++) {
            this.sidRecords[count].HCODE = null;
            this.sidRecords[count].ITEM_CODE = null;
            this.sidRecords[count].ITEM_NAME = null;
            this.sidRecords[count].QTY_PER_CTN = null;
            this.sidRecords[count].QTY_CTN = null;
            this.sidRecords[count].QTY = null;
            this.sidRecords[count].QTY_CTN2 = null;
            this.sidRecords[count].QTY2 = null; // 20220720_hash-shi_明細クリア_str------------
            // this.sidRecords[count].LOADING_PLACE = null;

            this.sidRecords[count].LOADING_PLACE_CODE = null;
            this.sidRecords[count].LOADING_PLACE_NAME = null; // 20220720_hash-shi_明細クリア_end------------

            this.sidRecords[count].REMARK1 = null;
            this.sidRecords[count].REMARK2 = null;
          } // 20220720_hash-shi_明細クリア_str------------


          this.sihRecord.CONTINUED_SHEET = null;
          this.sihRecord.CURRENT_SHEET = null;
          this.sihRecord.ALL_SHEET = null;
          this.sihRecord.INVOICE_NOTE = null;
          this.sihRecord.DELIVERY_NOTE = null;
          this.sihRecord.TAG_NOTE = null; // 20220720_hash-shi_明細クリア_end------------
          //元値を新しい値に変更する

          this.orgDeliveryCode = this.sihRecord.DELIVERY_CODE; // コードの存在確認

          var that = this;
          var targetDeliveries = null; // 取区が通常の場合

          if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4) {
            targetDeliveries = this.mstDeliveries.filter(function (row) {
              return row.CODE == that.sihRecord.DELIVERY_CODE ? true : false;
            });
          } // 取区が仕入・融通の場合


          if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4) {
            targetDeliveries = this.mstWarehouses.filter(function (row) {
              return row.CODE == that.sihRecord.DELIVERY_CODE ? true : false;
            });
          }

          if (targetDeliveries.length == 0) {
            alert("納入先コードが登録されていません。");
            deliveryCode.focus();
            return;
          }
        }
      } //元値を新しい値に変更する


      this.orgDeliveryCode = this.sihRecord.DELIVERY_CODE;
      this.deliveryC2N(); // 20220706_hash-shi_納入先変更で明細クリア_end------------
    },
    // 仕入先(フォーカス外れ時イベント)
    supplierBlur: function supplierBlur() {
      if (this.sihRecord.SUPPLIER_CODE == null) {
        return;
      } //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgSuppliersCode != null) {
        // 桁数を揃える
        if (1 <= this.sihRecord.SUPPLIER_CODE.length && this.sihRecord.SUPPLIER_CODE.length <= 4) {
          this.sihRecord.SUPPLIER_CODE = this.officeOtherCode + this.sihRecord.SUPPLIER_CODE.padStart(4, '0');
        } // 変更されているか確認


        if (this.sihRecord.SUPPLIER_CODE != this.orgSuppliersCode) {
          // 元値を新しい値に変更する
          this.orgSuppliersCode = this.sihRecord.SUPPLIER_CODE; // 存在確認

          var that = this;
          var targetSuppliers = this.mstSuppliers.filter(function (row) {
            return row.CODE == that.sihRecord.SUPPLIER_CODE ? true : false;
          });

          if (targetSuppliers.length == 0) {
            alert("仕入先コードが登録されていません。");
            suppliersCode.focus();
            return;
          }
        }
      } // 元値を新しい値に変更する


      this.orgSuppliersCode = this.sihRecord.SUPPLIER_CODE;
      this.supplierC2N();
    },
    // 倉庫(フォーカス外れ時イベント)
    warehouseBlur: function warehouseBlur() {
      if (this.sihRecord.WAREHOUSE_CODE == null) {
        return;
      } //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgWarehousesCode != null) {
        // 桁数を揃える
        if (1 <= this.sihRecord.WAREHOUSE_CODE.length && this.sihRecord.WAREHOUSE_CODE.length <= 4) {
          this.sihRecord.WAREHOUSE_CODE = this.officeOtherCode + this.sihRecord.WAREHOUSE_CODE.padStart(4, '0');
        } // 変更されているか確認


        if (this.sihRecord.WAREHOUSE_CODE != this.orgWarehousesCode) {
          // 元値を新しい値に変更する
          this.orgWarehousesCode = this.sihRecord.WAREHOUSE_CODE; // 存在確認

          var that = this;
          var targetWarehouses = this.mstWarehouses.filter(function (row) {
            return row.CODE == that.sihRecord.WAREHOUSE_CODE ? true : false;
          });

          if (targetWarehouses.length == 0) {
            alert("倉庫コードが登録されていません。");
            suppliersCode.focus();
            return;
          }
        }
      } // 元値を新しい値に変更する


      this.orgWarehousesCode = this.sihRecord.WAREHOUSE_CODE;
      this.warehouseC2N();
    },
    // 運転手(フォーカス外れ時イベント)
    driverBlur: function driverBlur() {
      if (this.sihRecord.DRIVER_CODE == null) {
        return;
      } //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。


      if (this.orgDriversCode != null) {
        // 桁数を揃える
        if (this.sihRecord.DRIVER_CODE.length <= 6) {
          this.sihRecord.DRIVER_CODE = this.sihRecord.DRIVER_CODE.padStart(6, '0');
        } // 変更されているか確認


        if (this.sihRecord.DRIVER_CODE != this.orgDriversCode) {
          // 元値を新しい値に変更する
          this.orgDriversCode = this.sihRecord.DRIVER_CODE; // 存在確認

          var that = this;
          var targetDrivers = this.mstDrivers.filter(function (row) {
            return row.COMPANY_CODE == that.officeCode && row.CODE == that.sihRecord.DRIVER_CODE ? true : false;
          });

          if (targetDrivers.length == 0) {
            alert("運転手コードが登録されていません。");
            driversCode.focus();
            return;
          }
        }
      } // 元値を新しい値に変更する


      this.orgDriversCode = this.sihRecord.DRIVER_CODE;
      this.driverC2N();
    },
    // 商品(フォーカス外れ時イベント)
    itemBlur: function () {
      var _itemBlur = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8(index) {
        var _this3 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                if (!(this.sidRecords[index].ITEM_CODE == null || this.sidRecords[index].ITEM_CODE == "")) {
                  _context8.next = 4;
                  break;
                }

                this.sidRecords[index]["items_rel"] = null;
                this.itemUpdate(index);
                return _context8.abrupt("return");

              case 4:
                _context8.next = 6;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post("/api/master/items", {
                  'searchItemCode': this.sidRecords[index].ITEM_CODE,
                  'searchItemName': null,
                  'searchType': 1
                }).then(function (response) {
                  if (response.data.length > 0) {
                    _this3.sidRecords[index]["items_rel"] = response.data[0];
                  } else {
                    _this3.sidRecords[index]["items_rel"] = null;
                  }

                  _this3.itemUpdate(index);
                });

              case 6:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8, this);
      }));

      function itemBlur(_x7) {
        return _itemBlur.apply(this, arguments);
      }

      return itemBlur;
    }(),
    // 20220720_hash-shi_積込場所名_str------------
    loadingPlacBlur: function () {
      var _loadingPlacBlur = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9(index) {
        var count, places;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // 選択したコードの積込場所名を表示する。
                for (count = 0; count < this.mstPlaces.length; count++) {
                  places = this.mstPlaces[count];

                  if (places["CODE"] === this.sidRecords[index].LOADING_PLACE_CODE) {
                    this.sidRecords[index].LOADING_PLACE_NAME = places["NAME"];
                  }
                }

              case 1:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9, this);
      }));

      function loadingPlacBlur(_x8) {
        return _loadingPlacBlur.apply(this, arguments);
      }

      return loadingPlacBlur;
    }(),
    // 20220720_hash-shi_積込場所名_end------------
    //-------------------------------------------------------------------------
    // ダイアログで選択した値を反映
    //-------------------------------------------------------------------------
    // 営業所ダイアログで選択した営業所を格納してダイアログを閉じる
    selectOfficeDialog: function selectOfficeDialog(officeCode) {
      var _this4 = this;

      this.sihRecord.OFFICE_OTHER_CODE = officeCode;
      this.closeDialog('OfficeSearch');
      this.officeOtherBlur();
      this.officeOtherC2N();
      this.$nextTick(function () {
        return _this4.moveToNextField('officesOtherCode');
      });
    },
    // 得意先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectCustomerDialog: function selectCustomerDialog(customerCode) {
      var _this5 = this;

      this.sihRecord.CUSTOMER_CODE = customerCode;
      this.closeDialog('CustomerSearch');
      this.customerBlur();
      this.customerC2N();
      this.$nextTick(function () {
        return _this5.moveToNextField('customerCode');
      });
    },
    // 納入先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectDeliveryDialog: function selectDeliveryDialog(deliveryCode) {
      var _this6 = this;

      this.sihRecord.DELIVERY_CODE = deliveryCode;
      this.closeDialog('DeliverySearchDelivery');
      this.closeDialog('WarehouseSearchDelivery');
      this.deliveryBlur();
      this.deliveryC2N();
      this.$nextTick(function () {
        return _this6.moveToNextField('deliveryCodeDelivery');
      });
    },
    // 仕入先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectSupplierDialog: function selectSupplierDialog(supplierCode) {
      var _this7 = this;

      this.sihRecord.SUPPLIER_CODE = supplierCode;
      this.closeDialog('SupplierSearch');
      this.supplierC2N();
      this.$nextTick(function () {
        return _this7.moveToNextField('suppliersCode');
      });
    },
    // 倉庫ダイアログで選択した得意先を格納してダイアログを閉じる
    selectWarehouseDialog: function selectWarehouseDialog(warehouseCode) {
      var _this8 = this;

      this.sihRecord.WAREHOUSE_CODE = warehouseCode;
      this.closeDialog('WarehouseSearch');
      this.warehouseC2N();
      this.$nextTick(function () {
        return _this8.moveToNextField('warehousesCode');
      });
    },
    // 運転手ダイアログで選択した得意先を格納してダイアログを閉じる
    selectDriverDialog: function selectDriverDialog(companyCode, driverCode) {
      var _this9 = this;

      this.sihRecord.DRIVER_CODE = driverCode;
      this.closeDialog('DriverSearch');
      this.driverC2N();
      this.$nextTick(function () {
        return _this9.moveToNextField('driversCode');
      });
    },
    // 商品ダイアログで選択した得意先を格納してダイアログを閉じる
    selectItemDialog: function selectItemDialog(item) {
      var _this10 = this;

      var index = this.showDialog.ItemSearchIndex;
      this.sidRecords[index].ITEM_CODE = item.CODE;
      this.sidRecords[index]["items_rel"] = item;
      this.closeDialog('ItemSearch');
      this.itemUpdate(index);
      this.$nextTick(function () {
        return _this10.moveToNextField('itemCode_' + index);
      });
    },
    //-------------------------------------------------------------------------
    // 行操作
    //-------------------------------------------------------------------------
    // 上下入れ替え
    sidRowSwap: function sidRowSwap(index, mode) {
      if (index == 0 && mode == "up") {
        return;
      }

      if (index == 7 && mode == "down") {
        return;
      }

      if (mode == "down") {
        var baseRow = JSON.parse(JSON.stringify(this.sidRecords[index]));
        var targetRow = JSON.parse(JSON.stringify(this.sidRecords[index + 1]));
        this.sidRecords.splice(index, 1, targetRow);
        this.sidRecords.splice(index + 1, 1, baseRow);
      }

      if (mode == "up") {
        var baseRow = JSON.parse(JSON.stringify(this.sidRecords[index]));
        var targetRow = JSON.parse(JSON.stringify(this.sidRecords[index - 1]));
        this.sidRecords.splice(index, 1, targetRow);
        this.sidRecords.splice(index - 1, 1, baseRow);
      }
    },
    // 行の内容を削除
    sidRowDel: function sidRowDel(index) {
      for (var key in this.sidRecords[index]) {
        if (key != 'ORDER_NO' && key != 'RNO') {
          this.sidRecords[index][key] = null;
        }
      }
    },
    getItems: function () {
      var _getItems = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var _this11 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                if (!(this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4)) {
                  _context10.next = 8;
                  break;
                }

                if (!(this.sihRecord.CUSTOMER_CODE == null || this.sihRecord.CUSTOMER_CODE == "")) {
                  _context10.next = 4;
                  break;
                }

                this.mstItems = [];
                return _context10.abrupt("return");

              case 4:
                _context10.next = 6;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post('/api/master/items', {
                  'searchHcode': this.sihRecord.HCODE,
                  'searchCustomerCode': this.sihRecord.CUSTOMER_CODE,
                  'searchDeliveryCode': this.sihRecord.DELIVERY_CODE
                }).then(function (response) {
                  _this11.mstItems = response.data;
                });

              case 6:
                _context10.next = 17;
                break;

              case 8:
                if (!(this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4)) {
                  _context10.next = 16;
                  break;
                }

                if (!(this.sihRecord.SUPPLIER_CODE == null || this.sihRecord.SUPPLIER_CODE == "")) {
                  _context10.next = 12;
                  break;
                }

                this.mstItems = [];
                return _context10.abrupt("return");

              case 12:
                _context10.next = 14;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post('/api/master/items', {
                  'searchHcode': this.sihRecord.HCODE,
                  'searchSupplierCode': this.sihRecord.SUPPLIER_CODE
                }).then(function (response) {
                  _this11.mstItems = response.data;
                });

              case 14:
                _context10.next = 17;
                break;

              case 16:
                // それ意外はありえないが変な値が入ってもいやなので、空に初期化する
                this.mstItems = [];

              case 17:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10, this);
      }));

      function getItems() {
        return _getItems.apply(this, arguments);
      }

      return getItems;
    }(),
    //-------------------------------------------------------------------------
    // 明細行の警告
    //-------------------------------------------------------------------------
    // 商品コードがデータリストに無い場合の警告
    itemWarning: function itemWarning(index) {
      var itemCode = this.sidRecords[index].ITEM_CODE;

      if (itemCode == null) {
        return false;
      }

      if (itemCode == "") {
        return false;
      }

      if (this.mstItems.filter(function (row) {
        return row.CODE == itemCode;
      }).length > 0) {
        return false;
      }

      return true;
    },
    // 商品コードがデータリストに無い場合の警告
    qtyPerCtnWarning: function qtyPerCtnWarning(index) {
      var qtyPerCtn = this.sidRecords[index].QTY_PER_CTN;

      if (qtyPerCtn == null) {
        return false;
      }

      if (qtyPerCtn == "") {
        return false;
      }

      if (this.sidRecords[index]["items_rel"] == null) {
        return false;
      }

      if (this.sidRecords[index]["items_rel"].QTY_PER_CTN == qtyPerCtn) {
        return false;
      }

      return true;
    },
    //コンマ表示関連
    //コンマ表示
    comma: function comma(value) {
      if (!value) return '';
      return value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    },
    //コンマ除去
    delcomma: function delcomma(value) {
      if (!value) return '';
      return value.toString().replace(/,/g, '');
    },
    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    onFunctionKeys: function onFunctionKeys(event) {
      // Typescriptコンパイラに型を伝えるためのおまじない
      if (!(event.target instanceof HTMLElement)) {
        return;
      } // Typescriptコンパイラに型を伝えるためのおまじない


      switch (event.code) {
        case 'F1':
          // 
          event.preventDefault();
          break;

        case 'F3':
          // 
          event.preventDefault();
          break;

        case 'F4':
          // 
          event.preventDefault();
          break;

        case 'F8':
          // 
          event.preventDefault();
          break;

        case 'F9':
          // 
          event.preventDefault();
          break;

        case 'F10':
          // 入力確定
          event.preventDefault();
          var record = this.nextFields.find(function (field) {
            return field.id === 'conf';
          });

          if (!record.disabled) {
            this.conf();
          }

          break;

        case 'F12':
          // 
          event.preventDefault();
          break;
      }
    },
    setNextField: function setNextField() {
      // Enter移動の設定をする
      this.nextFields = [];
      this.nextFields.push({
        'id': 'back',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'copy',
        'disabled': this.isNew && !(this.sihRecord.STATUS == 1 || this.sihRecord.STATUS == 2)
      });
      this.nextFields.push({
        'id': 'susp',
        'disabled': !(this.sihRecord.STATUS == 0 || this.sihRecord.STATUS == 0 || this.sihRecord.STATUS == 99)
      });
      this.nextFields.push({
        'id': 'conf',
        'disabled': !(this.sihRecord.STATUS == 0 || this.sihRecord.STATUS == 0 || this.sihRecord.STATUS == 99)
      });
      this.nextFields.push({
        'id': 'comp',
        'disabled': !(this.sihRecord.STATUS == 0 || this.sihRecord.STATUS == 1 || this.sihRecord.STATUS == 3 || this.sihRecord.STATUS == 99)
      });
      this.nextFields.push({
        'id': 'del',
        'disabled': this.isNew && !(this.sihRecord.STATUS == 1 || this.sihRecord.STATUS == 3)
      });
      this.nextFields.push({
        'id': 'instructionPrint',
        'disabled': this.isNew && !(this.sihRecord.STATUS == 1 || this.sihRecord.STATUS == 3)
      });
      this.nextFields.push({
        'id': 'slipPrint',
        'disabled': this.isNew && !(this.sihRecord.STATUS == 1 || this.sihRecord.STATUS == 3)
      });
      this.nextFields.push({
        'id': 'orderDate',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'orderTime',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'orderUser',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'kari',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'orderUser2',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'shipDate',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryDate',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryAmpn0',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryAmpn1',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryAmpn2',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryTime',
        'disabled': !(this.sihRecord.DELIVERY_AMPM == 1 || this.sihRecord.DELIVERY_AMPM == 2)
      });
      this.nextFields.push({
        'id': 'officesOtherCode',
        'disabled': !(this.sihRecord.HCODE == 4 || this.sihRecord.HCODE == 5 || this.sihRecord.HCODE == 6)
      });
      this.nextFields.push({
        'id': 'customerCode',
        'disabled': !(this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4)
      });
      this.nextFields.push({
        'id': 'deliveryCodeDelivery',
        'disabled': !(this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4)
      });
      this.nextFields.push({
        'id': 'deliveryCodeWarehouse',
        'disabled': !(this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4)
      });
      this.nextFields.push({
        'id': 'suppliersCode',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'warehousesCode',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'driversCode',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'flights',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'fee',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'addFee',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'highwayFee',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'feeClass0',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'feeClass1',
        'disabled': false
      });

      for (var i = 0; i < this.sidRecords.length; i++) {
        this.nextFields.push({
          'id': 'hcode_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'itemCode_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'qtyPerCtn_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'qtyCtn_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'loadingPlaceCode_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'loadingPlaceName_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'ramark1_' + i,
          'disabled': false
        });
        this.nextFields.push({
          'id': 'ramark2_' + i,
          'disabled': false
        });
      }

      this.nextFields.push({
        'id': 'continuedSheet0',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'continuedSheet1',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'currentSheet',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'allSheet',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'invoiceNote',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'deliveryNote',
        'disabled': false
      });
      this.nextFields.push({
        'id': 'tagNote',
        'disabled': false
      });
    },
    moveToNextField: function moveToNextField(nowField) {
      var nextField = "";
      var index = this.nextFields.findIndex(function (field) {
        return field.id === nowField;
      });

      for (var i = 0; i < this.nextFields.length; i++) {
        if (index < this.nextFields.length - 1) {
          index++;
        } else {
          index = 0;
        }

        var record = this.nextFields[index];

        if (!record.disabled) {
          nextField = record.id;
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
    }
  },
  //---------------------------------------------------------------------------
  //
  // 画面ロード時処理
  //
  //---------------------------------------------------------------------------
  mounted: function () {
    var _mounted = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
        while (1) {
          switch (_context11.prev = _context11.next) {
            case 0:
              // 簡易ログインチェック
              if (_store__WEBPACK_IMPORTED_MODULE_3__.default.state.userCode == null) {
                _router__WEBPACK_IMPORTED_MODULE_2__.default.push({
                  path: "/sso"
                });
              } // //得意先の絞込
              // if(this.sihRecord.HCODE == 1){
              //   this.mstCustomers=this.mstCustomers.filter(function(row){ return (row.CODE>1480000)});
              //   this.mstCustomers=this.mstCustomers.filter(function(row){ return (row.CODE<1489999)});
              // }
              // //仕入先の絞込
              // if(this.sihRecord.HCODE != 4){
              //   this.mstSuppliers=this.mstSuppliers.filter(function(row){ return (row.CODE>1480000)});
              //   this.mstSuppliers=this.mstSuppliers.filter(function(row){ return (row.CODE<1489999)});
              // }
              // //取区によるリストの絞込
              // if(this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4) {
              //   // 通常売上
              //   var codes = ["11","12","15","16","35","38","45"];
              //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
              // } else if(this.sihRecord.HCODE == 2 || this.sihRecord.HCODE == 5) {
              //   // 通常仕入
              //   var codes = ["10","13","14","31","34","36","37","41","44"];
              //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
              // } else if(this.sihRecord.HCODE == 3 || this.sihRecord.HCODE == 6) {
              //   // 通常移動
              //   var codes = ["51"];
              //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
              // }


            case 1:
            case "end":
              return _context11.stop();
          }
        }
      }, _callee11);
    }));

    function mounted() {
      return _mounted.apply(this, arguments);
    }

    return mounted;
  }(),
  watch: {
    $route: {
      handler: function handler() {
        //-------------------------------------------
        // 初期タブ制御
        //-------------------------------------------
        var target = this.$route.params.sihId;
        var sihId = "";
        var orderNo = "";
        var hCode = "";
        var shipDate = "";
        var userCode = "";
        var sihIdBase = "";

        if (target != null) {
          var targetSplit = target.split("_");

          if (targetSplit.length == 1) {
            // 修正
            sihId = targetSplit[0];
          } else if (targetSplit.length == 5) {
            // 新規
            sihId = targetSplit[0];
            orderNo = targetSplit[1];
            hCode = targetSplit[2];
            shipDate = targetSplit[3];
            userCode = targetSplit[4];
          } else if (targetSplit.length == 6) {
            // 複写
            sihId = targetSplit[0];
            orderNo = targetSplit[1];
            hCode = targetSplit[2];
            shipDate = targetSplit[3];
            userCode = targetSplit[4];
            sihIdBase = targetSplit[5];
          } //-------------------------------------------
          // 初期データ取得
          //-------------------------------------------


          this.init(sihId, orderNo, hCode, shipDate, userCode, sihIdBase);
        }
      },
      immediate: true
    },
    'sihRecord.CUSTOMER_CODE': function () {
      var _sihRecordCUSTOMER_CODE = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12(code) {
        var _this12 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _context12.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post('/api/master/deliveries', {
                  'searchCustomerCode': code
                }).then(function (response) {
                  _this12.mstDeliveries = response.data;
                });

              case 2:
                _context12.next = 4;
                return this.getItems();

              case 4:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12, this);
      }));

      function sihRecordCUSTOMER_CODE(_x9) {
        return _sihRecordCUSTOMER_CODE.apply(this, arguments);
      }

      return sihRecordCUSTOMER_CODE;
    }(),
    'sihRecord.DELIVERY_CODE': function () {
      var _sihRecordDELIVERY_CODE = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13(code) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                _context13.next = 2;
                return this.getItems();

              case 2:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13, this);
      }));

      function sihRecordDELIVERY_CODE(_x10) {
        return _sihRecordDELIVERY_CODE.apply(this, arguments);
      }

      return sihRecordDELIVERY_CODE;
    }(),
    'sihRecord.SUPPLIER_CODE': function () {
      var _sihRecordSUPPLIER_CODE = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14(code) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                _context14.next = 2;
                return this.getItems();

              case 2:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14, this);
      }));

      function sihRecordSUPPLIER_CODE(_x11) {
        return _sihRecordSUPPLIER_CODE.apply(this, arguments);
      }

      return sihRecordSUPPLIER_CODE;
    }(),
    'sihRecord.LOADING_RATE': function () {
      var _sihRecordLOADING_RATE = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                this.itemUpdate();

              case 1:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15, this);
      }));

      function sihRecordLOADING_RATE() {
        return _sihRecordLOADING_RATE.apply(this, arguments);
      }

      return sihRecordLOADING_RATE;
    }()
  },
  computed: {
    wariai: function wariai() {
      var wariai = 0;

      for (var count = 0; count < this.sidRecords.length; count++) {
        var sidRecord = this.sidRecords[count];
        wariai = wariai + sidRecord.QTY2;
      }

      return wariai.toFixed(1);
    }
  },
  beforeRouteUpdate: function beforeRouteUpdate(to, from, next) {
    this.closeDialog('InputShippingCp');
    next(); // this.load();
  },
  filters: {
    decimalFormat: function decimalFormat(value) {
      if (!value) return '';
      if (value == 0) return '';
      return Number(value).toFixed(1);
    },
    decimalFormatZero: function decimalFormatZero(value) {
      if (!value) return 0;
      if (value == '' || value == null) return 0;
      return Number(value).toFixed(0);
    },
    upperCase: function upperCase(value) {
      if (!value) return '';
      return value.toUpperCase();
    },
    comma: function comma(value) {
      if (!value) return '';
      return value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\ntd.warning[data-v-5ef6da9a] {\n  background-color: yellow;\n}\ndiv.information[data-v-5ef6da9a] {\n  position: absolute;\n  width: 240px;\n  bottom: 30px;\n  text-align: left;\n  background-color: #ffffff;\n  border: 1px solid #000000;\n  border-radius: 3px;\n  padding: 5px;\n  box-sizing: border-box;\n  font-size: 14px;\n  min-height: 28px;\n  display: none;\n}\n.showSmall[data-v-5ef6da9a]{\n  width:25px;\n  font-size:13px;\n}\n.delspinner[data-v-5ef6da9a]::-webkit-outer-spin-button,\n.delspinner[data-v-5ef6da9a]::-webkit-inner-spin-button {\n  -webkit-appearance: none;\n  margin: 0;\n}\n.delspinner[data-v-5ef6da9a]{\n  -moz-appearance:textfield;\n}\n.awake[data-v-5ef6da9a] {\n  background-color: #ffff00;\n  border-color: blue;\n  border-radius: 3px;\n  border-width: 2px;\n}\n.awake[data-v-5ef6da9a]:hover{\n  background-color: #e6e600;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_style_index_0_id_5ef6da9a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_style_index_0_id_5ef6da9a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_style_index_0_id_5ef6da9a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pages/Detail.vue":
/*!***************************************!*\
  !*** ./resources/js/pages/Detail.vue ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Detail.vue?vue&type=template&id=5ef6da9a&scoped=true */ "./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true");
/* harmony import */ var _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Detail.vue?vue&type=script&lang=js */ "./resources/js/pages/Detail.vue?vue&type=script&lang=js");
/* harmony import */ var _Detail_vue_vue_type_style_index_0_id_5ef6da9a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css */ "./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default,
  _Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "5ef6da9a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Detail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Detail.vue?vue&type=script&lang=js":
/*!***************************************************************!*\
  !*** ./resources/js/pages/Detail.vue?vue&type=script&lang=js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css":
/*!***********************************************************************************************!*\
  !*** ./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_style_index_0_id_5ef6da9a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=style&index=0&id=5ef6da9a&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_5ef6da9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=template&id=5ef6da9a&scoped=true */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Detail.vue?vue&type=template&id=5ef6da9a&scoped=true ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.sihRecord != null
    ? _c(
        "div",
        [
          _c(
            "div",
            {
              attrs: { inert: _vm.inert },
              on: { keydown: _vm.onFunctionKeys }
            },
            [
              _c("input", {
                ref: "back",
                attrs: { type: "button", value: "メイン画面" },
                on: { click: _vm.back }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "copy",
                attrs: {
                  disabled:
                    _vm.isNew &&
                    !(_vm.sihRecord.STATUS == 1 || _vm.sihRecord.STATUS == 2),
                  type: "button",
                  value: "複写"
                },
                on: {
                  click: _vm.copy,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.copy($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "susp",
                attrs: {
                  disabled: !(
                    _vm.sihRecord.STATUS == 0 ||
                    _vm.sihRecord.STATUS == 0 ||
                    _vm.sihRecord.STATUS == 99
                  ),
                  type: "button",
                  value: "一時保存"
                },
                on: {
                  click: _vm.susp,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.susp($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "conf",
                staticClass: "awake",
                attrs: {
                  disabled: !(
                    _vm.sihRecord.STATUS == 0 ||
                    _vm.sihRecord.STATUS == 1 ||
                    _vm.sihRecord.STATUS == 99
                  ),
                  type: "button",
                  value: "F10:入力確定"
                },
                on: {
                  click: _vm.conf,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.conf($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "comp",
                attrs: {
                  disabled: !(
                    _vm.sihRecord.STATUS == 0 ||
                    _vm.sihRecord.STATUS == 1 ||
                    _vm.sihRecord.STATUS == 3 ||
                    _vm.sihRecord.STATUS == 99
                  ),
                  type: "button",
                  value: "出荷完了"
                },
                on: {
                  click: _vm.comp,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.comp($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "del",
                attrs: {
                  disabled:
                    _vm.isNew &&
                    !(_vm.sihRecord.STATUS == 1 || _vm.sihRecord.STATUS == 3),
                  type: "button",
                  value: "削除"
                },
                on: {
                  click: _vm.del,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.del($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "instructionPrint",
                attrs: {
                  disabled:
                    _vm.isNew &&
                    !(_vm.sihRecord.STATUS == 1 || _vm.sihRecord.STATUS == 3),
                  type: "button",
                  value: "指示書印刷"
                },
                on: {
                  click: _vm.instructionPrint,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.instructionPrint($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                ref: "slipPrint",
                attrs: {
                  disabled:
                    _vm.isNew &&
                    !(_vm.sihRecord.STATUS == 1 || _vm.sihRecord.STATUS == 3),
                  type: "button",
                  value: "伝票印刷"
                },
                on: {
                  click: _vm.slipPrint,
                  keyup: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                    ) {
                      return null
                    }
                    return _vm.slipPrint($event)
                  }
                }
              }),
              _vm._v(" "),
              _c("pre"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [
                  _vm._v("\n        受付日時\n      ")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.ORDER_DATE,
                        expression: "sihRecord.ORDER_DATE"
                      }
                    ],
                    ref: "orderDate",
                    attrs: { type: "date", max: "9999-12-31" },
                    domProps: { value: _vm.sihRecord.ORDER_DATE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("orderDate")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "ORDER_DATE",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.ORDER_TIME,
                        expression: "sihRecord.ORDER_TIME"
                      }
                    ],
                    ref: "orderTime",
                    attrs: { type: "time", step: "3600" },
                    domProps: { value: _vm.sihRecord.ORDER_TIME },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("orderTime")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "ORDER_TIME",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [
                  _vm._v("\n        受注者\n      ")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.ORDER_USER,
                          expression: "sihRecord.ORDER_USER"
                        }
                      ],
                      ref: "orderUser",
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("orderUser")
                        },
                        change: function($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function(o) {
                              return o.selected
                            })
                            .map(function(o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.$set(
                            _vm.sihRecord,
                            "ORDER_USER",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        }
                      }
                    },
                    _vm._l(_vm.mstUsers, function(user) {
                      return _c(
                        "option",
                        { key: user.CODE, domProps: { value: user.CODE } },
                        [_vm._v(_vm._s(user.CODE) + ":" + _vm._s(user.NAME))]
                      )
                    }),
                    0
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [
                  _vm._v("\n        入力確定\n      ")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _vm.sihRecord.CONFIRM_DATE != null
                    ? _c(
                        "div",
                        {
                          staticStyle: {
                            display: "inline-block",
                            width: "160px"
                          }
                        },
                        [
                          _vm._v(
                            "\n          " +
                              _vm._s(
                                _vm.toDateTimeComp(_vm.sihRecord.CONFIRM_DATE)
                              ) +
                              "\n        "
                          )
                        ]
                      )
                    : _c(
                        "div",
                        {
                          staticStyle: {
                            display: "inline-block",
                            width: "160px"
                          }
                        },
                        [_vm._v("\n          －\n        ")]
                      ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticStyle: {
                        display: "inline-block",
                        "margin-left": "30px"
                      }
                    },
                    [
                      _vm._v(
                        _vm._s(_vm.sihRecord.OFFICE_CODE) +
                          ":" +
                          _vm._s(_vm.sihRecord.OFFICE_NAME)
                      )
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("pre"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("取区")]),
                _vm._v(" "),
                _c("div", { staticClass: "value w100" }, [
                  _c("div", { staticStyle: { "font-weight": "bold" } }, [
                    _vm._v(_vm._s(_vm.sihRecord.HNAME))
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("進捗")]),
                _vm._v(" "),
                _c("div", { staticClass: "value w100" }, [
                  _c("div", { staticStyle: { "font-weight": "bold" } }, [
                    _vm._v(_vm._s(_vm.sihRecord.SNAME))
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("指示書")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.KARI,
                          expression: "sihRecord.KARI"
                        }
                      ],
                      ref: "kari",
                      attrs: { type: "checkbox", name: "check" },
                      domProps: {
                        checked: Array.isArray(_vm.sihRecord.KARI)
                          ? _vm._i(_vm.sihRecord.KARI, null) > -1
                          : _vm.sihRecord.KARI
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("kari")
                        },
                        change: function($event) {
                          var $$a = _vm.sihRecord.KARI,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = null,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 &&
                                _vm.$set(
                                  _vm.sihRecord,
                                  "KARI",
                                  $$a.concat([$$v])
                                )
                            } else {
                              $$i > -1 &&
                                _vm.$set(
                                  _vm.sihRecord,
                                  "KARI",
                                  $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                )
                            }
                          } else {
                            _vm.$set(_vm.sihRecord, "KARI", $$c)
                          }
                        }
                      }
                    }),
                    _vm._v("仮")
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("指示書印刷")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("div", { staticStyle: { "font-weight": "bold" } }, [
                    _vm._v(
                      _vm._s(
                        _vm._f("decimalFormatZero")(_vm.sihRecord.PRINT_COUNT)
                      ) + "回"
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("伝票印刷")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("div", { staticStyle: { "font-weight": "bold" } }, [
                    _vm._v(
                      _vm._s(
                        _vm._f("decimalFormatZero")(_vm.sihRecord.PRINT2_COUNT)
                      ) + "回"
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("受注No.")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.ORDER_NO,
                        expression: "sihRecord.ORDER_NO"
                      }
                    ],
                    attrs: { type: "text", size: "10", disabled: true },
                    domProps: { value: _vm.sihRecord.ORDER_NO },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.sihRecord, "ORDER_NO", $event.target.value)
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("発注者")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.ORDER2_USER,
                          expression: "sihRecord.ORDER2_USER"
                        }
                      ],
                      ref: "orderUser2",
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("orderUser2")
                        },
                        change: function($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function(o) {
                              return o.selected
                            })
                            .map(function(o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.$set(
                            _vm.sihRecord,
                            "ORDER2_USER",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        }
                      }
                    },
                    _vm._l(_vm.mstUsers, function(user) {
                      return _c(
                        "option",
                        { key: user.CODE, domProps: { value: user.CODE } },
                        [_vm._v(_vm._s(user.CODE) + ":" + _vm._s(user.NAME))]
                      )
                    }),
                    0
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("出荷日")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.SHIP_DATE,
                        expression: "sihRecord.SHIP_DATE"
                      }
                    ],
                    ref: "shipDate",
                    attrs: { type: "date", max: "9999-12-31", name: "example" },
                    domProps: { value: _vm.sihRecord.SHIP_DATE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("shipDate")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "SHIP_DATE",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("納品日")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.DELIVERY_DATE,
                        expression: "sihRecord.DELIVERY_DATE"
                      }
                    ],
                    ref: "deliveryDate",
                    attrs: { type: "date", name: "example", max: "9999-12-31" },
                    domProps: { value: _vm.sihRecord.DELIVERY_DATE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("deliveryDate")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "DELIVERY_DATE",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.DELIVERY_AMPM,
                          expression: "sihRecord.DELIVERY_AMPM"
                        }
                      ],
                      ref: "deliveryAmpn0",
                      attrs: { type: "radio", name: "r1", value: "3" },
                      domProps: {
                        checked: _vm._q(_vm.sihRecord.DELIVERY_AMPM, "3")
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("deliveryAmpn0")
                        },
                        change: function($event) {
                          return _vm.$set(_vm.sihRecord, "DELIVERY_AMPM", "3")
                        }
                      }
                    }),
                    _vm._v("無指定")
                  ]),
                  _vm._v(" "),
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.DELIVERY_AMPM,
                          expression: "sihRecord.DELIVERY_AMPM"
                        }
                      ],
                      ref: "deliveryAmpn1",
                      attrs: { type: "radio", name: "r1", value: "1" },
                      domProps: {
                        checked: _vm._q(_vm.sihRecord.DELIVERY_AMPM, "1")
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("deliveryAmpn1")
                        },
                        change: function($event) {
                          return _vm.$set(_vm.sihRecord, "DELIVERY_AMPM", "1")
                        }
                      }
                    }),
                    _vm._v("AM")
                  ]),
                  _vm._v(" "),
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.DELIVERY_AMPM,
                          expression: "sihRecord.DELIVERY_AMPM"
                        }
                      ],
                      ref: "deliveryAmpn2",
                      attrs: { type: "radio", name: "r1", value: "2" },
                      domProps: {
                        checked: _vm._q(_vm.sihRecord.DELIVERY_AMPM, "2")
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("deliveryAmpn2")
                        },
                        change: function($event) {
                          return _vm.$set(_vm.sihRecord, "DELIVERY_AMPM", "2")
                        }
                      }
                    }),
                    _vm._v("PM")
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.DELIVERY_TIME,
                        expression: "sihRecord.DELIVERY_TIME"
                      }
                    ],
                    ref: "deliveryTime",
                    attrs: {
                      type: "time",
                      disabled: !(
                        _vm.sihRecord.DELIVERY_AMPM == 1 ||
                        _vm.sihRecord.DELIVERY_AMPM == 2
                      )
                    },
                    domProps: { value: _vm.sihRecord.DELIVERY_TIME },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("deliveryTime")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "DELIVERY_TIME",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("相手営業所")]),
                _vm._v(" "),
                _vm.sihRecord.HCODE == 4 ||
                _vm.sihRecord.HCODE == 5 ||
                _vm.sihRecord.HCODE == 6
                  ? _c(
                      "div",
                      { staticClass: "value" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.OFFICE_OTHER_CODE,
                              expression: "sihRecord.OFFICE_OTHER_CODE"
                            }
                          ],
                          ref: "officesOtherCode",
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "6",
                            list: "offices",
                            id: "officesOtherCode"
                          },
                          domProps: { value: _vm.sihRecord.OFFICE_OTHER_CODE },
                          on: {
                            keyup: [
                              function($event) {
                                return _vm.officeOtherC2N()
                              },
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField("officesOtherCode")
                              }
                            ],
                            blur: function($event) {
                              return _vm.officeOtherBlur()
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "OFFICE_OTHER_CODE",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "times" },
                          on: {
                            click: function($event) {
                              _vm.sihRecord.OFFICE_OTHER_CODE = ""
                              _vm.officeOtherC2N()
                              _vm.officeOtherBlur()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "search" },
                          on: {
                            click: function($event) {
                              return _vm.opneDialog("OfficeSearch")
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.OFFICE_OTHER_NAME,
                              expression: "sihRecord.OFFICE_OTHER_NAME"
                            }
                          ],
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "50",
                            disabled: ""
                          },
                          domProps: { value: _vm.sihRecord.OFFICE_OTHER_NAME },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "OFFICE_OTHER_NAME",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c(
                  "div",
                  {
                    staticClass: "title",
                    on: {
                      mouseover: _vm.showInformation,
                      mouseout: _vm.hideInformation
                    }
                  },
                  [
                    _vm._v("得意先\n        "),
                    _c("div", { staticClass: "information" }, [
                      _vm._v("得意先を指定してください。")
                    ])
                  ]
                ),
                _vm._v(" "),
                _vm.sihRecord.HCODE == 1 || _vm.sihRecord.HCODE == 4
                  ? _c(
                      "div",
                      { staticClass: "value" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.CUSTOMER_CODE,
                              expression: "sihRecord.CUSTOMER_CODE"
                            }
                          ],
                          ref: "customerCode",
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "6",
                            list: "customers",
                            id: "customerCode"
                          },
                          domProps: { value: _vm.sihRecord.CUSTOMER_CODE },
                          on: {
                            keyup: [
                              function($event) {
                                return _vm.customerC2N()
                              },
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField("customerCode")
                              }
                            ],
                            blur: function($event) {
                              return _vm.customerBlur()
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "CUSTOMER_CODE",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "times" },
                          on: {
                            click: function($event) {
                              _vm.sihRecord.CUSTOMER_CODE = ""
                              _vm.customerC2N()
                              _vm.customerBlur()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "search" },
                          on: {
                            click: function($event) {
                              return _vm.opneDialog("CustomerSearch")
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.CUSTOMER_NAME,
                              expression: "sihRecord.CUSTOMER_NAME"
                            }
                          ],
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "50",
                            disabled: ""
                          },
                          domProps: { value: _vm.sihRecord.CUSTOMER_NAME },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "CUSTOMER_NAME",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c(
                  "div",
                  {
                    staticClass: "title",
                    on: {
                      mouseover: _vm.showInformation,
                      mouseout: _vm.hideInformation
                    }
                  },
                  [_vm._v("納／倉\n        "), _vm._m(0)]
                ),
                _vm._v(" "),
                _vm.sihRecord.HCODE == 1 || _vm.sihRecord.HCODE == 4
                  ? _c(
                      "div",
                      { staticClass: "value" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.DELIVERY_CODE,
                              expression: "sihRecord.DELIVERY_CODE"
                            }
                          ],
                          ref: "deliveryCodeDelivery",
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "6",
                            list: "delivery_destinations",
                            id: "deliveryCode"
                          },
                          domProps: { value: _vm.sihRecord.DELIVERY_CODE },
                          on: {
                            keyup: [
                              function($event) {
                                return _vm.deliveryC2N()
                              },
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField(
                                  "deliveryCodeDelivery"
                                )
                              }
                            ],
                            blur: function($event) {
                              return _vm.deliveryBlur()
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "DELIVERY_CODE",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "times" },
                          on: {
                            click: function($event) {
                              _vm.sihRecord.DELIVERY_CODE = ""
                              _vm.deliveryC2N()
                              _vm.deliveryBlur()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "search" },
                          on: {
                            click: function($event) {
                              return _vm.opneDialog("DeliverySearchDelivery")
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.DELIVERY_NAME,
                              expression: "sihRecord.DELIVERY_NAME"
                            }
                          ],
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "50",
                            disabled: ""
                          },
                          domProps: { value: _vm.sihRecord.DELIVERY_NAME },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "DELIVERY_NAME",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.sihRecord.HCODE != 1 && _vm.sihRecord.HCODE != 4
                  ? _c(
                      "div",
                      { staticClass: "value" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.DELIVERY_CODE,
                              expression: "sihRecord.DELIVERY_CODE"
                            }
                          ],
                          ref: "deliveryCodeWarehouse",
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "6",
                            list: "delivery_destinations",
                            id: "deliveryCode"
                          },
                          domProps: { value: _vm.sihRecord.DELIVERY_CODE },
                          on: {
                            keyup: [
                              function($event) {
                                return _vm.deliveryC2N()
                              },
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField(
                                  "deliveryCodeWarehouse"
                                )
                              }
                            ],
                            blur: function($event) {
                              return _vm.deliveryBlur()
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "DELIVERY_CODE",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "times" },
                          on: {
                            click: function($event) {
                              _vm.sihRecord.DELIVERY_CODE = ""
                              _vm.deliveryC2N()
                              _vm.deliveryBlur()
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("font-awesome-icon", {
                          staticStyle: { cursor: "pointer" },
                          attrs: { icon: "search" },
                          on: {
                            click: function($event) {
                              return _vm.opneDialog("WarehouseSearchDelivery")
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.sihRecord.DELIVERY_NAME,
                              expression: "sihRecord.DELIVERY_NAME"
                            }
                          ],
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "50",
                            disabled: ""
                          },
                          domProps: { value: _vm.sihRecord.DELIVERY_NAME },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.sihRecord,
                                "DELIVERY_NAME",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c(
                  "div",
                  {
                    staticClass: "title",
                    on: {
                      mouseover: _vm.showInformation,
                      mouseout: _vm.hideInformation
                    }
                  },
                  [
                    _vm._v("仕入先\n        "),
                    _c("div", { staticClass: "information" }, [
                      _vm._v("仕入先を指定してください。")
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "value" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.SUPPLIER_CODE,
                          expression: "sihRecord.SUPPLIER_CODE"
                        }
                      ],
                      ref: "suppliersCode",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        size: "6",
                        list: "suppliers",
                        id: "suppliersCode"
                      },
                      domProps: { value: _vm.sihRecord.SUPPLIER_CODE },
                      on: {
                        keyup: [
                          function($event) {
                            return _vm.supplierC2N()
                          },
                          function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return _vm.moveToNextField("suppliersCode")
                          }
                        ],
                        blur: function($event) {
                          return _vm.supplierBlur()
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "SUPPLIER_CODE",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "times" },
                      on: {
                        click: function($event) {
                          _vm.sihRecord.SUPPLIER_CODE = ""
                          _vm.supplierC2N()
                          _vm.supplierBlur()
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "search" },
                      on: {
                        click: function($event) {
                          return _vm.opneDialog("SupplierSearch")
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.SUPPLIER_NAME,
                          expression: "sihRecord.SUPPLIER_NAME"
                        }
                      ],
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        size: "50",
                        disabled: ""
                      },
                      domProps: { value: _vm.sihRecord.SUPPLIER_NAME },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "SUPPLIER_NAME",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c(
                  "div",
                  {
                    staticClass: "title",
                    on: {
                      mouseover: _vm.showInformation,
                      mouseout: _vm.hideInformation
                    }
                  },
                  [_vm._v("倉庫\n        "), _vm._m(1)]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "value" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.WAREHOUSE_CODE,
                          expression: "sihRecord.WAREHOUSE_CODE"
                        }
                      ],
                      ref: "warehousesCode",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        size: "6",
                        list: "warehouses",
                        id: "warehousesCode"
                      },
                      domProps: { value: _vm.sihRecord.WAREHOUSE_CODE },
                      on: {
                        keyup: [
                          function($event) {
                            return _vm.warehouseC2N()
                          },
                          function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return _vm.moveToNextField("warehousesCode")
                          }
                        ],
                        blur: function($event) {
                          return _vm.warehouseBlur()
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "WAREHOUSE_CODE",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "times" },
                      on: {
                        click: function($event) {
                          _vm.sihRecord.WAREHOUSE_CODE = ""
                          _vm.warehouseC2N()
                          _vm.warehouseBlur()
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "search" },
                      on: {
                        click: function($event) {
                          return _vm.opneDialog("WarehouseSearch")
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.WAREHOUSE_NAME,
                          expression: "sihRecord.WAREHOUSE_NAME"
                        }
                      ],
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        size: "50",
                        disabled: ""
                      },
                      domProps: { value: _vm.sihRecord.WAREHOUSE_NAME },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "WAREHOUSE_NAME",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("運転手")]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "value" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.DRIVER_CODE,
                          expression: "sihRecord.DRIVER_CODE"
                        }
                      ],
                      ref: "driversCode",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        size: "6",
                        list: "drivers",
                        id: "driversCode"
                      },
                      domProps: { value: _vm.sihRecord.DRIVER_CODE },
                      on: {
                        keyup: [
                          function($event) {
                            return _vm.driverC2N()
                          },
                          function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return _vm.moveToNextField("driversCode")
                          }
                        ],
                        blur: function($event) {
                          return _vm.driverBlur()
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "DRIVER_CODE",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "times" },
                      on: {
                        click: function($event) {
                          _vm.sihRecord.DRIVER_CODE = ""
                          _vm.driverC2N()
                          _vm.driverBlur()
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("font-awesome-icon", {
                      staticStyle: { cursor: "pointer" },
                      attrs: { icon: "search" },
                      on: {
                        click: function($event) {
                          return _vm.opneDialog("DriverSearch")
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.DRIVER_NAME,
                          expression: "sihRecord.DRIVER_NAME"
                        }
                      ],
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: ""
                      },
                      domProps: { value: _vm.sihRecord.DRIVER_NAME },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.sihRecord,
                            "DRIVER_NAME",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("運送会社")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.TRUCKER_CODE,
                        expression: "sihRecord.TRUCKER_CODE"
                      }
                    ],
                    attrs: {
                      type: "text",
                      autocomplete: "off",
                      size: "10",
                      disabled: ""
                    },
                    domProps: { value: _vm.sihRecord.TRUCKER_CODE },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "TRUCKER_CODE",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.TRUCKER_NAME,
                        expression: "sihRecord.TRUCKER_NAME"
                      }
                    ],
                    attrs: { type: "text", autocomplete: "off", disabled: "" },
                    domProps: { value: _vm.sihRecord.TRUCKER_NAME },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "TRUCKER_NAME",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("便区分")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.FLIGHTS,
                        expression: "sihRecord.FLIGHTS"
                      }
                    ],
                    ref: "flights",
                    attrs: { type: "text", autocomplete: "off", size: "5" },
                    domProps: { value: _vm.sihRecord.FLIGHTS },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("flights")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.sihRecord, "FLIGHTS", $event.target.value)
                      }
                    }
                  }),
                  _vm._v("\n        回目\n      ")
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("運賃")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.FEE,
                        expression: "sihRecord.FEE"
                      }
                    ],
                    ref: "fee",
                    staticClass: "right",
                    attrs: { type: "text", autocomplete: "off", size: "10" },
                    domProps: { value: _vm.sihRecord.FEE },
                    on: {
                      blur: function($event) {
                        _vm.sihRecord.FEE = _vm.comma(_vm.sihRecord.FEE)
                      },
                      focus: function($event) {
                        _vm.sihRecord.FEE = _vm.delcomma(_vm.sihRecord.FEE)
                      },
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("fee")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.sihRecord, "FEE", $event.target.value)
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("付加")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.ADD_FEE,
                        expression: "sihRecord.ADD_FEE"
                      }
                    ],
                    ref: "addFee",
                    staticClass: "right",
                    attrs: { type: "text", autocomplete: "off", size: "10" },
                    domProps: { value: _vm.sihRecord.ADD_FEE },
                    on: {
                      blur: function($event) {
                        _vm.sihRecord.ADD_FEE = _vm.comma(_vm.sihRecord.ADD_FEE)
                      },
                      focus: function($event) {
                        _vm.sihRecord.ADD_FEE = _vm.delcomma(
                          _vm.sihRecord.ADD_FEE
                        )
                      },
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("addFee")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.sihRecord, "ADD_FEE", $event.target.value)
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("有料道路代")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.HIGHWAY_FEE,
                        expression: "sihRecord.HIGHWAY_FEE"
                      }
                    ],
                    ref: "highwayFee",
                    staticClass: "right",
                    attrs: { type: "text", autocomplete: "off", size: "10" },
                    domProps: { value: _vm.sihRecord.HIGHWAY_FEE },
                    on: {
                      blur: function($event) {
                        _vm.sihRecord.HIGHWAY_FEE = _vm.comma(
                          _vm.sihRecord.HIGHWAY_FEE
                        )
                      },
                      focus: function($event) {
                        _vm.sihRecord.HIGHWAY_FEE = _vm.delcomma(
                          _vm.sihRecord.HIGHWAY_FEE
                        )
                      },
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("highwayFee")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "HIGHWAY_FEE",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("運賃振替")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.FEE_CLASS,
                          expression: "sihRecord.FEE_CLASS"
                        }
                      ],
                      ref: "feeClass0",
                      attrs: { type: "radio", name: "radio", value: "1" },
                      domProps: {
                        checked: _vm._q(_vm.sihRecord.FEE_CLASS, "1")
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("feeClass0")
                        },
                        change: function($event) {
                          return _vm.$set(_vm.sihRecord, "FEE_CLASS", "1")
                        }
                      }
                    }),
                    _vm._v("他")
                  ]),
                  _vm._v(" "),
                  _c("label", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.sihRecord.FEE_CLASS,
                          expression: "sihRecord.FEE_CLASS"
                        }
                      ],
                      ref: "feeClass1",
                      attrs: { type: "radio", name: "radio", value: "2" },
                      domProps: {
                        checked: _vm._q(_vm.sihRecord.FEE_CLASS, "2")
                      },
                      on: {
                        keyup: function($event) {
                          if (
                            !$event.type.indexOf("key") &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.moveToNextField("feeClass1")
                        },
                        change: function($event) {
                          return _vm.$set(_vm.sihRecord, "FEE_CLASS", "2")
                        }
                      }
                    }),
                    _vm._v("自")
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("pre"),
              _vm._v(" "),
              _c(
                "table",
                {
                  staticClass: "searchResult",
                  staticStyle: { width: "1330px" }
                },
                [
                  _vm._m(2),
                  _vm._v(" "),
                  _vm._l(_vm.sidRecords, function(sidRecord, index) {
                    return _c("tr", { key: index }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: sidRecord.HCODE,
                              expression: "sidRecord.HCODE"
                            }
                          ],
                          ref: "hcode_" + index,
                          refInFor: true,
                          staticClass: "w40",
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            list: "hcodeD"
                          },
                          domProps: { value: sidRecord.HCODE },
                          on: {
                            keyup: function($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              return _vm.moveToNextField("hcode_" + index)
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(sidRecord, "HCODE", $event.target.value)
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "datalist",
                          { attrs: { id: "hcodeD" } },
                          _vm._l(_vm.mstHCodesD, function(hcodeD) {
                            return _c(
                              "option",
                              {
                                key: hcodeD.CODE,
                                domProps: { value: hcodeD.CODE }
                              },
                              [
                                _vm._v(
                                  _vm._s(hcodeD.CODE) +
                                    " " +
                                    _vm._s(hcodeD.NAME)
                                )
                              ]
                            )
                          }),
                          0
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        { class: { warning: _vm.itemWarning(index) } },
                        [
                          _c("input", {
                            ref: "itemCode_" + index,
                            refInFor: true,
                            attrs: {
                              type: "text",
                              autocomplete: "off",
                              size: "16",
                              list: "items_rel"
                            },
                            domProps: {
                              value: _vm._f("upperCase")(sidRecord.ITEM_CODE)
                            },
                            on: {
                              input: function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "lazy",
                                    undefined,
                                    $event.key,
                                    undefined
                                  )
                                ) {
                                  return null
                                }
                                sidRecord.ITEM_CODE = $event.target.value.toUpperCase()
                              },
                              blur: function($event) {
                                return _vm.itemBlur(index)
                              },
                              keyup: function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField("itemCode_" + index)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("font-awesome-icon", {
                            staticStyle: { cursor: "pointer" },
                            attrs: { icon: "times" },
                            on: {
                              click: function($event) {
                                sidRecord.ITEM_CODE = ""
                                _vm.itemBlur(index)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("font-awesome-icon", {
                            staticStyle: { cursor: "pointer" },
                            attrs: { icon: "search" },
                            on: {
                              click: function($event) {
                                _vm.showDialog.ItemSearchIndex = index
                                _vm.opneDialog("ItemSearch")
                              }
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("font-awesome-icon", {
                            staticStyle: { cursor: "pointer" },
                            attrs: { icon: "arrow-up" },
                            on: {
                              click: function($event) {
                                return _vm.sidRowSwap(index, "up")
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("font-awesome-icon", {
                            staticStyle: { cursor: "pointer" },
                            attrs: { icon: "arrow-down" },
                            on: {
                              click: function($event) {
                                return _vm.sidRowSwap(index, "down")
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("font-awesome-icon", {
                            staticStyle: { cursor: "pointer" },
                            attrs: { icon: "trash" },
                            on: {
                              click: function($event) {
                                return _vm.sidRowDel(index)
                              }
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", [
                        sidRecord.ITEM_NAME != null
                          ? _c(
                              "div",
                              {
                                staticStyle: {
                                  "text-decoration": "underline",
                                  color: "#0000ff",
                                  cursor: "pointer"
                                },
                                on: {
                                  click: function($event) {
                                    return _vm.openStocksDetail(
                                      sidRecord.ITEM_CODE
                                    )
                                  }
                                }
                              },
                              [_vm._v(_vm._s(sidRecord.ITEM_NAME))]
                            )
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        { class: { warning: _vm.qtyPerCtnWarning(index) } },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: sidRecord.QTY_PER_CTN,
                                expression: "sidRecord.QTY_PER_CTN"
                              }
                            ],
                            ref: "qtyPerCtn_" + index,
                            refInFor: true,
                            staticClass: "delspinner",
                            staticStyle: {
                              "text-align": "right",
                              width: "50px"
                            },
                            attrs: {
                              type: "number",
                              autocomplete: "off",
                              size: "5"
                            },
                            domProps: { value: sidRecord.QTY_PER_CTN },
                            on: {
                              keyup: function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField("qtyPerCtn_" + index)
                              },
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  sidRecord,
                                  "QTY_PER_CTN",
                                  $event.target.value
                                )
                              }
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: sidRecord.QTY_CTN,
                              expression: "sidRecord.QTY_CTN"
                            }
                          ],
                          ref: "qtyCtn_" + index,
                          refInFor: true,
                          staticStyle: { "text-align": "right", width: "50px" },
                          attrs: {
                            type: "number",
                            autocomplete: "off",
                            size: "5"
                          },
                          domProps: { value: sidRecord.QTY_CTN },
                          on: {
                            keyup: function($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              return _vm.moveToNextField("qtyCtn_" + index)
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                sidRecord,
                                "QTY_CTN",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "right" }, [
                        _vm._v(
                          _vm._s(
                            _vm._f("comma")(
                              (sidRecord.QTY =
                                sidRecord.QTY_PER_CTN * sidRecord.QTY_CTN == 0
                                  ? ""
                                  : sidRecord.QTY_PER_CTN * sidRecord.QTY_CTN)
                            )
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "right showSmall" }, [
                        _vm._v(
                          _vm._s(_vm._f("decimalFormat")(sidRecord.QTY_CTN2))
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "right showSmall" }, [
                        _vm._v(
                          _vm._s(
                            _vm._f("decimalFormat")(
                              (sidRecord.QTY2 =
                                sidRecord.QTY_CTN * sidRecord.QTY_CTN2)
                            )
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "center" }, [
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: sidRecord.LOADING_PLACE_CODE,
                                expression: "sidRecord.LOADING_PLACE_CODE"
                              }
                            ],
                            ref: "loadingPlaceCode_" + index,
                            refInFor: true,
                            staticStyle: { width: "40px" },
                            on: {
                              change: [
                                function($event) {
                                  var $$selectedVal = Array.prototype.filter
                                    .call($event.target.options, function(o) {
                                      return o.selected
                                    })
                                    .map(function(o) {
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.$set(
                                    sidRecord,
                                    "LOADING_PLACE_CODE",
                                    $event.target.multiple
                                      ? $$selectedVal
                                      : $$selectedVal[0]
                                  )
                                },
                                function($event) {
                                  return _vm.loadingPlacBlur(index)
                                }
                              ],
                              keyup: function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.moveToNextField(
                                  "loadingPlaceCode_" + index
                                )
                              }
                            }
                          },
                          _vm._l(_vm.mstPlaces, function(place) {
                            return _c(
                              "option",
                              {
                                key: place.CODE,
                                domProps: { value: place.CODE }
                              },
                              [
                                _vm._v(
                                  _vm._s(place.CODE) + " " + _vm._s(place.NAME)
                                )
                              ]
                            )
                          }),
                          0
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: sidRecord.LOADING_PLACE_NAME,
                              expression: "sidRecord.LOADING_PLACE_NAME"
                            }
                          ],
                          ref: "loadingPlaceName_" + index,
                          refInFor: true,
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "10"
                          },
                          domProps: { value: sidRecord.LOADING_PLACE_NAME },
                          on: {
                            keyup: function($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              return _vm.moveToNextField(
                                "loadingPlaceName_" + index
                              )
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                sidRecord,
                                "LOADING_PLACE_NAME",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: sidRecord.REMARK1,
                              expression: "sidRecord.REMARK1"
                            }
                          ],
                          ref: "ramark1_" + index,
                          refInFor: true,
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "",
                            list: "remark"
                          },
                          domProps: { value: sidRecord.REMARK1 },
                          on: {
                            keyup: function($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              return _vm.moveToNextField("ramark1_" + index)
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                sidRecord,
                                "REMARK1",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "datalist",
                          { attrs: { id: "remark" } },
                          _vm._l(_vm.mstRemarks, function(remark, index) {
                            return _c("option", { key: index }, [
                              _vm._v(_vm._s(remark.name))
                            ])
                          }),
                          0
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: sidRecord.REMARK2,
                              expression: "sidRecord.REMARK2"
                            }
                          ],
                          ref: "ramark2_" + index,
                          refInFor: true,
                          attrs: {
                            type: "text",
                            autocomplete: "off",
                            size: "",
                            list: "remark"
                          },
                          domProps: { value: sidRecord.REMARK2 },
                          on: {
                            keyup: function($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              return _vm.moveToNextField("ramark2_" + index)
                            },
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                sidRecord,
                                "REMARK2",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ])
                    ])
                  }),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { attrs: { colspan: "8" } }),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.wariai,
                            expression: "wariai"
                          }
                        ],
                        staticClass: "showSmall",
                        attrs: {
                          type: "text",
                          autocomplete: "off",
                          disabled: "",
                          name: ""
                        },
                        domProps: { value: _vm.wariai },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.wariai = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "4" } })
                  ])
                ],
                2
              ),
              _vm._v(" "),
              _c("pre", [_vm._v("　")]),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("続き")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.CONTINUED_SHEET,
                        expression: "sihRecord.CONTINUED_SHEET"
                      }
                    ],
                    ref: "continuedSheet0",
                    attrs: { type: "radio", name: "r3", value: "1" },
                    domProps: {
                      checked: _vm._q(_vm.sihRecord.CONTINUED_SHEET, "1")
                    },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("continuedSheet0")
                      },
                      change: function($event) {
                        return _vm.$set(_vm.sihRecord, "CONTINUED_SHEET", "1")
                      }
                    }
                  }),
                  _vm._v("有\n        "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.CONTINUED_SHEET,
                        expression: "sihRecord.CONTINUED_SHEET"
                      }
                    ],
                    ref: "continuedSheet1",
                    attrs: { type: "radio", name: "r3", value: "2" },
                    domProps: {
                      checked: _vm._q(_vm.sihRecord.CONTINUED_SHEET, "2")
                    },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("continuedSheet1")
                      },
                      change: function($event) {
                        return _vm.$set(_vm.sihRecord, "CONTINUED_SHEET", "2")
                      }
                    }
                  }),
                  _vm._v("無\n        "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.CURRENT_SHEET,
                        expression: "sihRecord.CURRENT_SHEET"
                      }
                    ],
                    ref: "currentSheet",
                    staticClass: "right w40 delspinner",
                    attrs: {
                      type: "number",
                      autocomplete: "off",
                      size: "1",
                      name: ""
                    },
                    domProps: { value: _vm.sihRecord.CURRENT_SHEET },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("currentSheet")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "CURRENT_SHEET",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v("枚目\n        "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.ALL_SHEET,
                        expression: "sihRecord.ALL_SHEET"
                      }
                    ],
                    ref: "allSheet",
                    staticClass: "right w40 delspinner",
                    attrs: {
                      type: "number",
                      autocomplete: "off",
                      size: "1",
                      name: ""
                    },
                    domProps: { value: _vm.sihRecord.ALL_SHEET },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("allSheet")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "ALL_SHEET",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v("枚中\n        割合"),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.wariai,
                        expression: "wariai"
                      }
                    ],
                    attrs: { type: "text", disabled: "", name: "" },
                    domProps: { value: _vm.wariai },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.wariai = $event.target.value
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("送り状記事")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.INVOICE_NOTE,
                        expression: "sihRecord.INVOICE_NOTE"
                      }
                    ],
                    ref: "invoiceNote",
                    attrs: {
                      type: "text",
                      autocomplete: "off",
                      size: "120",
                      placeholder: "送り状に記事がある場合はここに入力"
                    },
                    domProps: { value: _vm.sihRecord.INVOICE_NOTE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("invoiceNote")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "INVOICE_NOTE",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("納品書記事")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.DELIVERY_NOTE,
                        expression: "sihRecord.DELIVERY_NOTE"
                      }
                    ],
                    ref: "deliveryNote",
                    attrs: {
                      type: "text",
                      autocomplete: "off",
                      size: "120",
                      placeholder: "納品書に記事がある場合はここに入力"
                    },
                    domProps: { value: _vm.sihRecord.DELIVERY_NOTE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("deliveryNote")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.sihRecord,
                          "DELIVERY_NOTE",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("br"),
              _vm._v(" "),
              _c("div", { staticClass: "tv" }, [
                _c("div", { staticClass: "title" }, [_vm._v("付箋")]),
                _vm._v(" "),
                _c("div", { staticClass: "value" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.sihRecord.TAG_NOTE,
                        expression: "sihRecord.TAG_NOTE"
                      }
                    ],
                    ref: "tagNote",
                    attrs: {
                      type: "text",
                      autocomplete: "off",
                      size: "120",
                      placeholder: "ここに何か入力すると付箋になります。"
                    },
                    domProps: { value: _vm.sihRecord.TAG_NOTE },
                    on: {
                      keyup: function($event) {
                        if (
                          !$event.type.indexOf("key") &&
                          _vm._k(
                            $event.keyCode,
                            "enter",
                            13,
                            $event.key,
                            "Enter"
                          )
                        ) {
                          return null
                        }
                        return _vm.moveToNextField("tagNote")
                      },
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.sihRecord, "TAG_NOTE", $event.target.value)
                      }
                    }
                  })
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _vm.showDialog.CustomerSearch
            ? _c("CustomerSearchDialog", {
                attrs: {
                  officeCode: this.officeCode,
                  hCode: _vm.sihRecord.HCODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("CustomerSearch")
                  },
                  select: _vm.selectCustomerDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.DeliverySearchDelivery
            ? _c("DeliverySearchDialog", {
                attrs: {
                  officeCode: this.officeCode,
                  hCode: _vm.sihRecord.HCODE,
                  customerCode: _vm.sihRecord.CUSTOMER_CODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("DeliverySearchDelivery")
                  },
                  select: _vm.selectDeliveryDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.WarehouseSearchDelivery
            ? _c("WarehouseSearchDialog", {
                attrs: {
                  officeCode: this.officeOtherCode,
                  hCode: _vm.sihRecord.HCODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("WarehouseSearchDelivery")
                  },
                  select: _vm.selectDeliveryDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.SupplierSearch
            ? _c("SupplierSearchDialog", {
                attrs: {
                  officeCode: this.officeOtherCode,
                  hCode: _vm.sihRecord.HCODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("SupplierSearch")
                  },
                  select: _vm.selectSupplierDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.WarehouseSearch
            ? _c("WarehouseSearchDialog", {
                attrs: {
                  officeCode: this.officeOtherCode,
                  hCode: _vm.sihRecord.HCODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("WarehouseSearch")
                  },
                  select: _vm.selectWarehouseDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.DriverSearch
            ? _c("DriverSearchDialog", {
                attrs: {
                  officeCode: this.officeCode,
                  officeOtherCode: this.officeOtherCode,
                  hCode: _vm.sihRecord.HCODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("DriverSearch")
                  },
                  select: _vm.selectDriverDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.ItemSearch
            ? _c("ItemSearchDialog", {
                attrs: {
                  searchHcode: _vm.sihRecord.HCODE,
                  searchCustomerCode: _vm.sihRecord.CUSTOMER_CODE,
                  searchDeliveryCode: _vm.sihRecord.DELIVERY_CODE,
                  searchSupplierCode: _vm.sihRecord.SUPPLIER_CODE
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("ItemSearch")
                  },
                  select: _vm.selectItemDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.OfficeSearch
            ? _c("OfficeSearchDialog", {
                on: {
                  close: function($event) {
                    return _vm.closeDialog("OfficeSearch")
                  },
                  select: _vm.selectOfficeDialog
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _vm.showDialog.InputShippingCp
            ? _c("InputShippingDialog", {
                attrs: {
                  mode: "copy",
                  hCode: _vm.sihRecord.HCODE,
                  baseSihId: _vm.sihRecord.SIH_ID
                },
                on: {
                  close: function($event) {
                    return _vm.closeDialog("InputShippingCp")
                  },
                  complete: _vm.copyDetail
                }
              })
            : _vm._e()
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "information" }, [
      _vm._v("納入先を指定してください。"),
      _c("br"),
      _vm._v("（仕入の時は入荷する倉庫を指定）")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "information" }, [
      _vm._v("出荷倉庫を指定してください。"),
      _c("br"),
      _vm._v("（仕入の時は仕入元の倉庫）")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", { staticClass: "w20" }),
      _vm._v(" "),
      _c("th", { staticClass: "w40" }, [_vm._v("区")]),
      _vm._v(" "),
      _c("th", { staticClass: "w200" }, [_vm._v("コード")]),
      _vm._v(" "),
      _c("th", { staticClass: "w60" }),
      _vm._v(" "),
      _c("th", { staticClass: "w150" }, [_vm._v("商品名")]),
      _vm._v(" "),
      _c("th", { staticClass: "w60" }, [_vm._v("入数")]),
      _vm._v(" "),
      _c("th", { staticClass: "w60" }, [_vm._v("袋数")]),
      _vm._v(" "),
      _c("th", { staticClass: "w60" }, [_vm._v("数量")]),
      _vm._v(" "),
      _c("th", { staticClass: "showSmall" }, [_vm._v("率")]),
      _vm._v(" "),
      _c("th", { staticClass: "showSmall" }, [_vm._v("積数")]),
      _vm._v(" "),
      _c("th", { staticClass: "w70" }, [_vm._v("積込場所")]),
      _vm._v(" "),
      _c("th", { staticClass: "w100" }, [_vm._v("積込場所名")]),
      _vm._v(" "),
      _c("th", { staticClass: "w150" }, [_vm._v("備考1")]),
      _vm._v(" "),
      _c("th", { staticClass: "w150" }, [_vm._v("備考2")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);