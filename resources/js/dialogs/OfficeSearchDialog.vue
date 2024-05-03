<template>
  <div>
    <div class="dialogBase">
      <div class="dialogBackground"></div>
      <div class="dialogFrame">
        <div class="dialogHeader">
          <div class="dialogTitle">
            営業所検索
          </div>
          <button v-on:click="close">閉じる</button>
        </div>
        <div class="dialogBody">
          <div class="searchArea">
            <div class="tv">
              <div class="title">営業所コード</div>
              <div class="value"><input type="search" size="6" v-model="searchs.officeCode" :ref="'office_officeCode'" @keyup.enter="moveToNextField('office_officeCode')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">営業所カナ</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.officeKana" :ref="'office_officeKana'" @keyup.enter="moveToNextField('office_officeKana')"></div>
            </div>
            <br />
            <div class="tv">
              <div class="title">営業所名</div>
              <div class="value"><input type="search" size="40" placeholder="あいまい検索のキーワードを入力" v-model="searchs.officeName" :ref="'office_officeName'" @keyup.enter="moveToNextField('office_officeName')"></div>
            </div>
            <br />
            <div style="width: 100%;text-align:center;margin-top: 10px;margin-bottom: 10px;">
              <button style="width:100px;height: 32px;" v-on:click="search" :ref="'office_search'" @keyup.enter="moveToNextField('office_search')">検索</button>
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

  },
  data() {
    return {
      searchs :{
        'officeCode': "",
        'officeKana': "",
        'officeName': "",
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
      await axios.post("/api/master/offices", {
        'searchOfficeCode'   : this.searchs.officeCode,
        'searchOfficeKana'   : this.searchs.officeKana,
        'searchOfficeName'   : this.searchs.officeName,
      })
      .then(response => {
        this.results = response.data;
      });
    },
    //---------------------------------------------------------------------
    // 選択
    //---------------------------------------------------------------------
    select: function(officeCode){
      this.$emit("select", officeCode);
    },

    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    setNextField() {
      // Enter移動の設定をする
      this.nextFields = []
			this.nextFields.push({ 'id':'office_officeCode', 'disabled': false, });
			this.nextFields.push({ 'id':'office_officeKana', 'disabled': false, });
			this.nextFields.push({ 'id':'office_officeName', 'disabled': false, });
			this.nextFields.push({ 'id':'office_search', 'disabled': false, });
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
    // 検索
    await this.search();
    // Enter移動の設定をする
    this.setNextField();
    // 初期フォーカスの設定
    this.$nextTick(() => this.moveToNextField('office_search'));
  },
}
</script>
<style scoped>
</style>
