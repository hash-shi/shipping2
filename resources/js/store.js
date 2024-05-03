import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

//-----------------------------------------------------------------------------
// Vuex
//-----------------------------------------------------------------------------
export default new Vuex.Store({
    state: {
      userCode              : null,
      userName              : null,
      companyCode           : null,
      companyName           : null,
      officeCode            : null,
      officeName            : null,
      searchShipDate        : null,
      searchStatus          : null,
      searchOrderNos        : null,
      searchFlights         : null,
      stocksDetailURL       : null,
    },
    mutations: {
      setUserCode(state, userCode){
        state.userCode = userCode;
      },
      setCompanyCode(state, companyCode){
        state.companyCode = companyCode;
      },
      setCompanyName(state, companyName){
        state.companyName = companyName;
      },
      setOfficeCode(state, officeCode){
        state.officeCode = officeCode;
      },
      setOfficeName(state, officeName){
        state.officeName = officeName;
      },
      setUserName(state, userName){
        state.userName = userName;
      },
      setStocksDetailURL(state, stocksDetailURL){
        state.stocksDetailURL = stocksDetailURL;
      },
      setSearch(state, searchConditions){
        state.searchWarehouses          = searchConditions["searchWarehouses"];
        state.searchShipDateFrom        = searchConditions["searchShipDateFrom"];
        state.searchShipDateTo          = searchConditions["searchShipDateTo"];
        state.searchStatus              = searchConditions["searchStatus"];
        state.searchOrderNos            = searchConditions["searchOrderNos"];
        state.searchFlights             = searchConditions["searchFlights"];
      }
    },
    plugins: [createPersistedState({
      storage: window.sessionStorage
    })]
});
