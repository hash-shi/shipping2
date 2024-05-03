<template>
  <div>
    <div class="dialogBase">
      <div class="dialogBackground"></div>
      <div class="dialogFrame">
        <div class="dialogHeader">
          <div class="dialogTitle">
            運転手検索
          </div>
          <button v-on:click="close">閉じる</button>
        </div>
        <div class="dialogBody">
          <div class="searchArea">
            <div class="tv">
              <div class="title">営業所</div>
              <div class="value"><input type="search" size="6" v-model="searchs.officeCode" :ref="'driver_officeCode'" @keyup.enter="moveToNextField('driver_officeCode')"></div>
            </div>
            <br />
            <div class="tv" v-if="hCode == 4 || hCode == 5 || hCode == 6">
              <div class="title">相手営業所</div>
              <div class="value"><input type="search" size="6" v-model="searchs.officeOtherCode" :ref="'driver_officeOtherCode'" @keyup.enter="moveToNextField('driver_officeOtherCode')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">運転手読み</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.driverKana" :ref="'driver_driverKana'" @keyup.enter="moveToNextField('driver_driverKana')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">運転手名</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.driverName" :ref="'driver_driverName'" @keyup.enter="moveToNextField('driver_driverName')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">運送会社読み</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.truckerKana" :ref="'driver_truckerKana'" @keyup.enter="moveToNextField('driver_truckerKana')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">運送会社</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.truckerName" :ref="'driver_truckerName'" @keyup.enter="moveToNextField('driver_truckerName')"></div>
            </div>
            <br />
            
            <div style="width: 100%;text-align:center;margin-top: 10px;margin-bottom: 10px;">
              <button style="width:100px;height: 32px;" v-on:click="search" :ref="'driver_search'" @keyup.enter="search">検索</button>
            </div>
          </div>
          <table class="searchResult">
            <tr>
              <th class="w100 left">コード</th>
              <th class="left">名称</th>
              <th class="left">運送会社コード</th>
              <th class="left">運送会社名</th>
            </tr>
            <tr v-for="(result, index) in results" :key="index">
              <td class="w100"><div style="text-decoration: underline;cursor:pointer;" v-on:click="select(result.COMPANY_CODE, result.CODE)">{{ result.CODE }}</div></td>
              <td>{{ result.NAME }}</td>
              <td>{{ result.TRUCKER_CODE }}</td>
              <td>{{ result.TRUCKER_NAME }}</td>
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
    officeOtherCode : String,
    hCode : Number,
  },
  data() {
    return {
      searchs: {
        'officeCode': "",
        'officeOtherCode': "",
        'driverKana': "",
        'driverName': "",
        'truckerKana': "",
        'truckerName': "",
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
      await axios.post("/api/master/drivers", {
        'searchOfficeCode'   : this.searchs.officeCode,
        'searchOfficeOtherCode': this.searchs.officeOtherCode,
        'searchDriverKana'   : this.searchs.driverKana,
        'searchDriverName'   : this.searchs.driverName,
        'searchTruckerKana'  : this.searchs.truckerKana,
        'searchTruckerName'  : this.searchs.truckerName,
      })
      .then(response => {
        this.results = response.data;
      });
    },
    //---------------------------------------------------------------------
    // 選択
    //---------------------------------------------------------------------
    select: function(companyCode, driverCode){
      this.$emit("select",companyCode, driverCode);
    },

    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {
      // Enter移動の設定をする
      this.nextFields = []
			this.nextFields.push({ 'id':'driver_officeCode', 'disabled': false, });
			this.nextFields.push({ 'id':'driver_officeOtherCode', 'disabled': !(this.hCode == 4 || this.hCode == 5 || this.hCode == 6), });
			this.nextFields.push({ 'id':'driver_driverKana', 'disabled': false, });
			this.nextFields.push({ 'id':'driver_driverName', 'disabled': false, });
			this.nextFields.push({ 'id':'driver_truckerKana', 'disabled': false, });
			this.nextFields.push({ 'id':'driver_truckerName', 'disabled': false, });
      this.nextFields.push({ 'id':'driver_search', 'disabled': false, });
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

    // // 営業所コード
    // // 通常の場合は営業所で絞り込み
    // // 融通の場合はなし
    // if (this.hCode == 1 || this.hCode == 2 || this.hCode == 3) {
    //   this.searchOfficeCode = this.officeCode;
    // }

    this.searchs.officeCode = this.officeCode;
    this.searchs.officeOtherCode = this.officeOtherCode;

    // 検索
    await this.search();

    // Enter移動の設定をする
    this.setNextField();
    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField('driver_search'));
  },
}
</script>
<style scoped>
</style>
