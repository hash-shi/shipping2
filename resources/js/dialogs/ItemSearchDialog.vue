<template>
  <div>
    <div class="dialogBase">
      <div class="dialogBackground"></div>
      <div class="dialogFrame">
        <div class="dialogHeader">
          <div class="dialogTitle">
            商品検索
          </div>
          <button v-on:click="close">閉じる</button>
        </div>
        <div class="dialogBody">
          <div class="searchArea">
            <!-- 20220720_hash-shi_得意先・納入先の絞り込み追加_str------------ -->
            <!-- 通常売上/融通売上の場合 -->
            <div v-if="searchs.hcode == 1 || searchs.hcode == 4">
              <div class="tv">
                <div class="title">得意先コード</div>
                <div class="value"><input type="search" size="6" v-model="searchs.customerCode" :ref="'item_customerCode'" @keyup.enter="moveToNextField('item_customerCode')"></div>
              </div>
              <br />
              <div class="tv">
                <div class="title">納入先コード</div>
                <div class="value"><input type="search" size="6" v-model="searchs.deliveryCode" :ref="'item_deliveryCode'" @keyup.enter="moveToNextField('item_deliveryCode')"></div>
              </div>
              <br />
            </div>
            <!-- 通常売上/融通売上以外の場合 -->
            <div v-if="searchs.hcode != 1 && searchs.hcode != 4">
              <div class="tv">
                <div class="title">仕入先コード</div>
                <div class="value"><input type="search" size="6" v-model="searchs.supplierCode" :ref="'item_supplierCode'" @keyup.enter="moveToNextField('item_supplierCode')"></div>
              </div>
              <br />
            </div>
            <!-- 20220720_hash-shi_得意先・納入先の絞り込み追加_end------------ -->
            <div class="tv">
              <div class="title">商品コード</div>
              <div class="value"><input type="search" size="6" v-model="searchs.itemCode" :ref="'item_itemCode'" @keyup.enter="moveToNextField('item_itemCode')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">商品名</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.itemName" :ref="'item_itemName'" @keyup.enter="moveToNextField('item_itemName')"></div>
            </div>
            <br />
            
            <div style="width: 100%;text-align:center;margin-top: 10px;margin-bottom: 10px;">
              <button style="width:100px;height: 32px;" v-on:click="search" :ref="'item_search'" @keyup.enter="moveToNextField('item_search')">検索</button>
            </div>
          </div>

          <div class="searchResult">
            <table class="searchRecord">
              <thead>
                <tr>
                  <th class="w100 left">コード</th>
                  <th class="left">名称</th>
                  <th class="w100 left">目付</th>
                  <th class="w100 left">入数</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="result in results" :key="result.CODE">
                  <td class="w100"><div style="text-decoration: underline;cursor:pointer;" v-on:click="select(result)">{{ result.CODE }}</div></td>
                  <td>{{ result.NAME }}</td>
                  <td class="right">{{ result.WEIGHT }}</td>
                  <td class="right">{{ result.QTY_PER_CTN }}</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  // 20220720_hash-shi_得意先・納入先の絞り込み追加_str------------
  props: {
    hcode : String,
    // ↓2026/03/31_hash-shi_融通変換対応------------------------------
    officeCode  : String,
    officeCodeF : String,
    officeCodeT : String,
    // ↑2026/03/31_hash-shi_融通変換対応------------------------------
    customerCode : String,
    deliveryCode : String,
    supplierCode : String,
  },
  // 20220720_hash-shi_得意先・納入先の絞り込み追加_end------------
  data() {
    return {
      searchs: {
        'hcode': "",
        // ↓2026/03/31_hash-shi_融通変換対応------------------------------
        'officeCode':"",
        'officeCodeF':"",
        'officeCodeT':"",
        // ↑2026/03/31_hash-shi_融通変換対応------------------------------
        'customerCode': "",
        'deliveryCode': "",
        'supplierCode': "",
        'itemCode': "",
        'itemName': "",
        'like': false,
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
      await axios.post("/api/master/items", {
        'hcode'         : this.searchs.hcode,
        // ↓2026/03/31_hash-shi_融通変換対応------------------------------
        'officeCode'    : this.searchs.officeCode,
        'officeCodeF'   : this.searchs.officeCodeF,
        'officeCodeT'   : this.searchs.officeCodeT,
        // ↑2026/03/31_hash-shi_融通変換対応------------------------------
        // 20220720_hash-shi_得意先・納入先の絞り込み追加_str------------
        'customerCode'  : this.searchs.customerCode,
        'deliveryCode'  : this.searchs.deliveryCode,
        'supplierCode'  : this.searchs.supplierCode,
        // 20220720_hash-shi_得意先・納入先の絞り込み追加_end------------
        'itemCode'      : this.searchs.itemCode,
        'itemName'      : this.searchs.itemName,
        'like'          : ((this.searchs.like) ? 1 : 0),
      })
      .then(response => {
        this.results = response.data;
      });
    },
    //---------------------------------------------------------------------
    // 選択
    //---------------------------------------------------------------------
    select: function(item){
      this.$emit("select", item);
    },
    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {
      // Enter移動の設定をする
      this.nextFields = []
			this.nextFields.push({ 'id':'item_customerCode', 'disabled': !(this.searchs.hcode == 1 || this.searchs.hcode == 4), });
			this.nextFields.push({ 'id':'item_deliveryCode', 'disabled': !(this.searchs.hcode == 1 || this.searchs.hcode == 4), });
			this.nextFields.push({ 'id':'item_supplierCode', 'disabled': !(this.searchs.hcode != 1 && this.searchs.hcode != 4), });
			this.nextFields.push({ 'id':'item_itemCode', 'disabled': false, });
			this.nextFields.push({ 'id':'item_itemName', 'disabled': false, });
			this.nextFields.push({ 'id':'item_search',   'disabled': false, });
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

    this.searchs.hcode = this.hcode;
    // ↓2026/03/31_hash-shi_融通変換対応------------------------------
    this.searchs.officeCode = this.officeCode;
    this.searchs.officeCodeF = this.officeCodeF;
    this.searchs.officeCodeT = this.officeCodeT;
    // ↑2026/03/31_hash-shi_融通変換対応------------------------------
    this.searchs.customerCode = this.customerCode;
    this.searchs.deliveryCode = this.deliveryCode;
    this.searchs.supplierCode = this.supplierCode;
    
    await this.search();
    // Enter移動の設定をする
    this.setNextField();
    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField('item_search'));
  },
}
</script>
<style scoped>
  .searchResult {
    height: 350px;
  }
</style>
