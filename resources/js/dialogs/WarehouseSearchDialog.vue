<template>
  <div>
    <div class="dialogBase">
      <div class="dialogBackground"></div>
      <div class="dialogFrame">
        <div class="dialogHeader">
          <div class="dialogTitle">
            倉庫検索
          </div>
          <button v-on:click="close">閉じる</button>
        </div>
        <div class="dialogBody">
          <div class="searchArea">
            <div class="tv">
              <div class="title">営業所コード</div>
              <div class="value"><input type="search" size="6" v-model="searchs.officeCode" :ref="'warehouse_officeCode'" @keyup.enter="moveToNextField('warehouse_officeCode')"></div>
              <div class="value"><label>以外<input type="checkbox" name="check" v-model="searchs.notLike" :ref="'warehouse_notLike'" @keyup.enter="moveToNextField('warehouse_notLike')"></label></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">倉庫名カナ</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.warehouseKana" :ref="'warehouse_warehouseKana'" @keyup.enter="moveToNextField('warehouse_warehouseKana')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">倉庫名</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.warehouseName" :ref="'warehouse_warehouseName'" @keyup.enter="moveToNextField('warehouse_warehouseName')"></div>
            </div>
            <br />
            
            <div style="width: 100%;text-align:center;margin-top: 10px;margin-bottom: 10px;">
              <button style="width:100px;height: 32px;" v-on:click="search" :ref="'warehouse_search'" @keyup.enter="moveToNextField('warehouse_search')">検索</button>
            </div>
          </div>
          <table class="searchResult">
            <tr>
              <th class="w100 left">コード</th>
              <th class="left">名称</th>
              <th class="left">カナ</th>
            </tr>
            <tr v-for="result in results" :key="result.CODE">
              <td class="w100"><div style="text-decoration: underline;cursor:pointer;" v-on:click="select(result.CODE)">{{ result.CODE }}</div></td>
              <td>{{ result.NAME }}</td>
              <td>{{ result.NAME1 }}</td>
            </tr>
          </table>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    officeCode : String,
    hCode : String,
  },
  data() {
    return {
      searchs: {
        'officeCode': "",
        'warehouseKana': "",
        'warehouseName': "",
        'notLike' : false,
      },
      results: [],
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
    // 検索
    //---------------------------------------------------------------------
    search: async function(){
      await axios.post("/api/master/warehouses", {
        'searchOfficeCode'      : this.searchs.officeCode,
        'searchWarehouseKana'   : this.searchs.warehouseKana,
        'searchWarehouseName'   : this.searchs.warehouseName,
        'notLike'               : ((this.searchs.notLike) ? 1 : 0),
      })
      .then(response => {
        this.results = response.data;
      });
    },
    //---------------------------------------------------------------------
    // 選択
    //---------------------------------------------------------------------
    select: function(warehouseCode){
      this.$emit("select", warehouseCode);
    },
    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {
      // Enter移動の設定をする
      this.nextFields = []
			this.nextFields.push({ 'id':'warehouse_officeCode', 'disabled': false, });
			this.nextFields.push({ 'id':'warehouse_notLike', 'disabled': false, });
			this.nextFields.push({ 'id':'warehouse_warehouseKana', 'disabled': false, });
			this.nextFields.push({ 'id':'warehouse_warehouseName', 'disabled': false, });
			this.nextFields.push({ 'id':'warehouse_search', 'disabled': false, });
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
  mounted: async function(){

    // 営業所コード
    this.searchs.officeCode = this.officeCode;

    // 融通時は相手営業所を見る。not自営業所をする必要がない？
    // // 通常の場合は営業所で絞り込み
    // // 融通の場合は逆絞り込み
    // if (this.hCode == null || this.hCode == 1 || this.hCode == 2 || this.hCode == 3) {
    //   this.notLike = false;
    // } else {
    //   this.notLike = true;
    // }

    // 検索
    await this.search();
    // Enter移動の設定をする
    this.setNextField();
    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField('warehouse_search'));
  },
}
</script>
<style scoped>
</style>
