(self.webpackChunk=self.webpackChunk||[]).push([[819],{7819:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>m});var r=n(7757),a=n.n(r),s=n(8453),o=n(5682);function i(t,e,n,r,a,s,o){try{var i=t[s](o),u=i.value}catch(t){return void n(t)}i.done?e(u):Promise.resolve(u).then(r,a)}function u(t){return function(){var e=this,n=arguments;return new Promise((function(r,a){var s=t.apply(e,n);function o(t){i(s,r,a,o,u,"next",t)}function u(t){i(s,r,a,o,u,"throw",t)}o(void 0)}))}}var c,f,d;const h={data:function(){return{hasUserCode:!1}},methods:{getUser:(d=u(a().mark((function t(e){var n=this;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/api/sso/"+e,{}).then((function(t){t.data.length>0?(n.$store.commit("setUserCode",e),n.$store.commit("setUserName",t.data[0].NAME)):(n.$store.commit("setUserCode",null),n.$store.commit("setUserName",null))}));case 2:case"end":return t.stop()}}),t)}))),function(t){return d.apply(this,arguments)}),getConfig:(f=u(a().mark((function t(){var e=this;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/api/config",{}).then((function(t){for(var n=0;n<t.data.length;n++)"COMPANY_CODE"==t.data[n].ID&&e.$store.commit("setCompanyCode",t.data[n].VALUE),"COMPANY_NAME"==t.data[n].ID&&e.$store.commit("setCompanyName",t.data[n].VALUE),"OFFICE_CODE"==t.data[n].ID&&e.$store.commit("setOfficeCode",t.data[n].VALUE),"OFFICE_NAME"==t.data[n].ID&&e.$store.commit("setOfficeName",t.data[n].VALUE),"STOCKS_DETAIL_URL"==t.data[n].ID&&e.$store.commit("setStocksDetailURL",t.data[n].VALUE)}));case 2:case"end":return t.stop()}}),t)}))),function(){return f.apply(this,arguments)})},mounted:(c=u(a().mark((function t(){var e,n;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(e=this.$route.query.user_code,n=this.$route.query.mode,null==e||null==n){t.next=8;break}return t.next=5,this.getUser(e);case 5:return t.next=7,this.getConfig();case 7:null==o.Z.state.userCode||null==o.Z.state.userName||"ship"!=n&&"qr"!=n||null==o.Z.state.officeCode||("ship"==n&&s.Z.push({path:"/"}),"qr"==n&&s.Z.push({path:"/qr"}));case 8:case"end":return t.stop()}}),t,this)}))),function(){return c.apply(this,arguments)})};const m=(0,n(1900).Z)(h,(function(){var t=this.$createElement;return(this._self._c||t)("div")}),[],!1,null,"041116fa",null).exports}}]);