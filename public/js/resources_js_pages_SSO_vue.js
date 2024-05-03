(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_SSO_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./../router */ "./resources/js/router.js");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./../store */ "./resources/js/store.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      hasUserCode: false
    };
  },
  methods: {
    getUser: function () {
      var _getUser = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(userCode) {
        var _this = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios.get("/api/sso/" + userCode, {}).then(function (response) {
                  if (response.data.length > 0) {
                    _this.$store.commit("setUserCode", userCode);

                    _this.$store.commit("setUserName", response.data[0].NAME);
                  } else {
                    _this.$store.commit("setUserCode", null);

                    _this.$store.commit("setUserName", null);
                  }
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      function getUser(_x) {
        return _getUser.apply(this, arguments);
      }

      return getUser;
    }(),
    getConfig: function () {
      var _getConfig = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var _this2 = this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios.get("/api/config", {}).then(function (response) {
                  for (var count = 0; count < response.data.length; count++) {
                    if (response.data[count].ID == "COMPANY_CODE") {
                      _this2.$store.commit("setCompanyCode", response.data[count].VALUE);
                    }

                    if (response.data[count].ID == "COMPANY_NAME") {
                      _this2.$store.commit("setCompanyName", response.data[count].VALUE);
                    }

                    if (response.data[count].ID == "OFFICE_CODE") {
                      _this2.$store.commit("setOfficeCode", response.data[count].VALUE);
                    }

                    if (response.data[count].ID == "OFFICE_NAME") {
                      _this2.$store.commit("setOfficeName", response.data[count].VALUE);
                    }

                    if (response.data[count].ID == "STOCKS_DETAIL_URL") {
                      _this2.$store.commit("setStocksDetailURL", response.data[count].VALUE);
                    }
                  }
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }));

      function getConfig() {
        return _getConfig.apply(this, arguments);
      }

      return getConfig;
    }()
  },
  mounted: function () {
    var _mounted = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
      var userCode, mode;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              userCode = this.$route.query.user_code;
              mode = this.$route.query.mode;

              if (!(userCode != undefined && mode != undefined)) {
                _context3.next = 8;
                break;
              }

              _context3.next = 5;
              return this.getUser(userCode);

            case 5:
              _context3.next = 7;
              return this.getConfig();

            case 7:
              if (_store__WEBPACK_IMPORTED_MODULE_2__.default.state.userCode != null && _store__WEBPACK_IMPORTED_MODULE_2__.default.state.userName != null && (mode == "ship" || mode == "qr") && _store__WEBPACK_IMPORTED_MODULE_2__.default.state.officeCode != null) {
                if (mode == "ship") {
                  _router__WEBPACK_IMPORTED_MODULE_1__.default.push({
                    path: "/"
                  });
                }

                if (mode == "qr") {
                  _router__WEBPACK_IMPORTED_MODULE_1__.default.push({
                    path: "/qr"
                  });
                }
              }

            case 8:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3, this);
    }));

    function mounted() {
      return _mounted.apply(this, arguments);
    }

    return mounted;
  }()
});

/***/ }),

/***/ "./resources/js/pages/SSO.vue":
/*!************************************!*\
  !*** ./resources/js/pages/SSO.vue ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SSO.vue?vue&type=template&id=640c8296&scoped=true */ "./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true");
/* harmony import */ var _SSO_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SSO.vue?vue&type=script&lang=js */ "./resources/js/pages/SSO.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SSO_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default,
  _SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "640c8296",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/SSO.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/SSO.vue?vue&type=script&lang=js":
/*!************************************************************!*\
  !*** ./resources/js/pages/SSO.vue?vue&type=script&lang=js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SSO_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SSO.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SSO_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true":
/*!******************************************************************************!*\
  !*** ./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SSO_vue_vue_type_template_id_640c8296_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SSO.vue?vue&type=template&id=640c8296&scoped=true */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/SSO.vue?vue&type=template&id=640c8296&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  return _c("div")
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);