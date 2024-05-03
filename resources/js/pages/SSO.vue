<template>
    <div>
    </div>
</template>
<script>
import router from './../router'
import store from "./../store"
export default {
    data() {
        return {
            hasUserCode: false,
        }
    },
    methods: {
        getUser: async function(userCode){
            await axios.get("/api/sso/" + userCode, {})
            .then(response => {
                if (response.data.length > 0){
                    this.$store.commit("setUserCode" , userCode);
                    this.$store.commit("setUserName" , response.data[0].NAME);
                } else {
                    this.$store.commit("setUserCode" , null);
                    this.$store.commit("setUserName" , null);
                }
            });
        },
        getConfig: async function(){
            await axios.get("/api/config", {})
            .then(response => {
                for (var count = 0 ; count < response.data.length ; count++){
                    if (response.data[count].ID == "COMPANY_CODE"){ this.$store.commit("setCompanyCode" , response.data[count].VALUE); }
                    if (response.data[count].ID == "COMPANY_NAME"){ this.$store.commit("setCompanyName" , response.data[count].VALUE); }
                    if (response.data[count].ID == "OFFICE_CODE" ){ this.$store.commit("setOfficeCode"  , response.data[count].VALUE); }
                    if (response.data[count].ID == "OFFICE_NAME" ){ this.$store.commit("setOfficeName"  , response.data[count].VALUE); }
                    if (response.data[count].ID == "STOCKS_DETAIL_URL" ){ this.$store.commit("setStocksDetailURL"  , response.data[count].VALUE); }
                }
            });
        },
    },
    mounted: async function() {
        var userCode = this.$route.query.user_code;
        var mode     = this.$route.query.mode;
        if (userCode != undefined && mode != undefined){
            await this.getUser(userCode);
            await this.getConfig();
            if (store.state.userCode != null && store.state.userName != null && (mode == "ship" || mode == "qr") && store.state.officeCode != null){
                if (mode == "ship"){ router.push({ path: "/" }); }
                if (mode == "qr"  ){ router.push({ path: "/qr" }); }
            }
        }
    }    
}
</script>
<style scoped>

</style>
