<template>
  <div>
    <div class="dialogBase" style="overflow-y:none;">
      <div class="dialogBackground"></div>
      <div class="dialogFrame" style="height:325px;width:550px;overflow-y:auto !important;">
        <div class="dialogHeader">
          <div class="dialogTitle" v-if="mode=='new'">
            新規登録
          </div>
          <div class="dialogTitle" v-if="mode=='copy'">
            複写
          </div>
          <button v-on:click="close">閉じる</button>
        </div>
        <div class="dialogBody">
          <div v-if="mode=='new'">
            新規登録する出荷指示の取区と出荷日を入力してください。
          </div>
          <div v-if="mode=='copy'">
            複写先の出荷日を入力してください。
          </div>
          <br />

          <div class="tv" v-if="mode=='new'">
            <div class="title">取区</div>
            <div class="value" >
              <label v-for="(hcodeH, index) of this.HCODESH" :key="index">
                <br v-if="index!=0 && (index % 3)==0" />
                <input type="radio" :id="'hcodeH_'+index" name="r2" :value="hcodeH.CODE" v-model="HCODE" :ref="'inputShipping_hcodeH_' + index" @keyup.enter="moveToNextField('inputShipping_hcodeH_' + index)">{{ hcodeH.NAME }}
              </label>
            </div>
          </div>

          <div class="tv">
            <div class="title">受注No.</div>
            <div class="value">
              <input type="text" size="10" v-model="ORDER_NO" disabled ref="inputShipping_orderNo" @keyup.enter="moveToNextField('inputShipping_orderNo')">
            </div>
          </div>
          <br />
          <div class="tv">
            <div class="title">出荷日</div>
            <div class="value">
              <input v-if="mode=='new'"   type="date" max="9999-12-31" v-model="SHIP_DATE" ref="inputShipping_shipDate" @keyup.enter="moveToNextField('inputShipping_shipDate')">
              <input v-if="mode=='copy'"  type="date" max="9999-12-31" v-model="SHIP_DATE" ref="inputShipping_shipDate" @keyup.enter="moveToNextField('inputShipping_shipDate')">
            </div>
          </div>

          <div style="width:100%;text-align:center;margin-top: 40px;">
            <button v-if="mode=='new'"   style="width:150px;height:40px;" ref="inputShipping_regist" v-on:click="inputShipping_regist" @keyup.enter="inputShipping_regist">新規登録</button>
            <button v-if="mode=='copy'"  style="width:150px;height:40px;" ref="inputShipping_copy"   v-on:click="inputShipping_copy"   @keyup.enter="inputShipping_copy">複写</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
<script>
import router from '../router'
import store from "../store"
import $ from "jquery";
export default {
  props: {
    mode: {
      type: String,
    },
    baseSihId: {
      type: String,
    },
    hCode: {
      type: Number,
    },
  },
  data() {
    return {
      SIH_ID: "",
      ORDER_NO: "",
      HCODE: "",
      SHIP_DATE: "",
      HCODESH: [],
      nextFields: [],
    }
  },
  methods: {
    //---------------------------------------------------------------------
    // ダイアログのクローズ
    //---------------------------------------------------------------------
    close: function(){
      this.$emit("close");
    },

    //---------------------------------------------------------------------
    // 新規登録
    //---------------------------------------------------------------------
    inputShipping_regist: async function(){
      // ダイアログを閉じて入力画面に遷移する。
      this.$emit("complete", 0, this.ORDER_NO, this.HCODE, this.SHIP_DATE, store.state.userCode);
    },

    //---------------------------------------------------------------------
    // 複写
    //---------------------------------------------------------------------
    inputShipping_copy: async function(){
      // 複写完了後は編集画面へ遷移する
      this.$emit("complete", 0, this.ORDER_NO, this.hCode, this.SHIP_DATE, store.state.userCode, this.baseSihId);
    },

    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {
      // Enter移動の設定をする
      this.nextFields = []
      for(var i = 0; i < this.HCODESH.length; i++) {
        this.nextFields.push({ 'id':'inputShipping_hcodeH_' + i, 'disabled': false, });
      }
      this.nextFields.push({ 'id':'inputShipping_orderNo', 	'disabled': true, });
      this.nextFields.push({ 'id':'inputShipping_shipDate', 'disabled': false, });
      this.nextFields.push({ 'id':'inputShipping_regist', 	'disabled': !(this.mode=='new'), });
      this.nextFields.push({ 'id':'inputShipping_copy', 		'disabled': !(this.mode!='new'), });
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

  //-------------------------------------------------------------------------
  // 初期処理
  //-------------------------------------------------------------------------
  mounted: async function() {
    await axios.get("/api/today", {})
    .then(response => {
      this.SHIP_DATE = response.data;
    });

    await axios.post("/api/master/hcodesH", {})
    .then(response => { 
      this.HCODESH = response.data; 
    });

    await axios.get("/api/orderNo", {})
    .then(response => {
      this.ORDER_NO = response.data;
    });

    if (this.hCode != null && this.hCode != "") { this.HCODE = this.hCode; }

    // Enter移動の設定をする
    this.setNextField();

    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField('inputShipping_copy'));
  },
}
</script>
<style scoped>

</style>