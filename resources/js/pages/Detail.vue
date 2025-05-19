<template>
<div v-if="sihRecord!=null">
  <div :inert="inert" @keydown="onFunctionKeys">
  <input type="button" value="メイン画面" :ref="'back'"  v-on:click="back">

  <input v-bind:disabled="(isNew&&!(sihRecord.STATUS==1||sihRecord.STATUS==2))" type="button" value="複写" v-on:click="copy" :ref="'copy'" @keyup.enter="copy">
  <input v-bind:disabled="!(sihRecord.STATUS==0||sihRecord.STATUS==0||sihRecord.STATUS==99)" type="button" value="一時保存" v-on:click="susp" :ref="'susp'" @keyup.enter="susp">
  <input v-bind:disabled="!(sihRecord.STATUS==0||sihRecord.STATUS==1||sihRecord.STATUS==3||sihRecord.STATUS==99)" type="button" class="awake" value="F10:入力確定" v-on:click="conf" :ref="'conf'" @keyup.enter="conf">
  <input v-bind:disabled="!(sihRecord.STATUS==0||sihRecord.STATUS==1||sihRecord.STATUS==3||sihRecord.STATUS==99)" type="button" value="出荷完了" v-on:click="comp" :ref="'comp'" @keyup.enter="comp">
  <input v-bind:disabled="(isNew&&!(sihRecord.STATUS==1||sihRecord.STATUS==3))" type="button" value="削除" v-on:click="del" :ref="'del'" @keyup.enter="del">
  <input v-bind:disabled="(isNew&&!(sihRecord.STATUS==1||sihRecord.STATUS==3))" type="button" value="指示書印刷" v-on:click="instructionPrint" :ref="'instructionPrint'" @keyup.enter="instructionPrint">
  <input v-bind:disabled="(isNew&&!(sihRecord.STATUS==1||sihRecord.STATUS==3))" type="button" value="伝票印刷" v-on:click="slipPrint" :ref="'slipPrint'" @keyup.enter="slipPrint">

  <pre></pre>

  <div class="tv">
    <div class="title">
    受付日時
    </div>
    <div class="value">
    <input type="date" max="9999-12-31" v-model="sihRecord.ORDER_DATE" :ref="'orderDate'" @keyup.enter="moveToNextField('orderDate')">
    <input type="time" v-model="sihRecord.ORDER_TIME" step="3600" :ref="'orderTime'" @keyup.enter="moveToNextField('orderTime')">
   </div>
  </div>
  <div class="tv">
    <div class="title">
    受注者
    </div>
    <div class="value">
    <select v-model="sihRecord.ORDER_USER" :ref="'orderUser'" @keyup.enter="moveToNextField('orderUser')">
      <option v-for="user in master.Users" :key="user.CODE" :value="user.CODE">{{ user.CODE }}:{{ user.NAME }}</option>
    </select>
    </div>
  </div>

  <div class="tv">
    <div class="title">
    入力確定
    </div>
    <div class="value">
    <div v-if="sihRecord.CONFIRM_DATE!=null" style="display:inline-block;width: 160px;">
      {{ toDateTimeComp(sihRecord.CONFIRM_DATE) }}
    </div>
    <div v-else style="display:inline-block;width: 160px;">
      －
    </div>
    <div style="display:inline-block;margin-left: 30px;">{{sihRecord.OFFICE_CODE}}:{{sihRecord.OFFICE_NAME}}</div>
    </div>
  </div>
  <br />

  <pre></pre>

  <div class="tv">
    <div class="title">取区</div>
    <div class="value w100">
      <div style="font-weight:bold;">{{ sihRecord.HNAME }}</div>
    </div>
  </div>

  <div class="tv">
    <div class="title">進捗</div>
    <div class="value w100">
    <div style="font-weight:bold;">{{ sihRecord.SNAME }}</div>
    </div>
  </div>

  <div class="tv">
    <div class="title">指示書</div>
    <div class="value">
    <label><input type="checkbox" name="check" v-model="sihRecord.KARI" :ref="'kari'" @keyup.enter="moveToNextField('kari')">仮</label>
    </div>
  </div>

  <div class="tv">
    <div class="title">指示書印刷</div>
    <div class="value">
    <div style="font-weight:bold;">{{ sihRecord.PRINT_COUNT | decimalFormatZero }}回</div>
    </div>
  </div>

  <div class="tv">
    <div class="title">伝票印刷</div>
    <div class="value">
    <div style="font-weight:bold;">{{ sihRecord.PRINT2_COUNT | decimalFormatZero }}回</div>
    </div>
  </div>

  <!-- <div class="tv">
    <div class="title">積載率</div>
    <div class="value">
    <label><input type="radio" name="r4" value="1" v-model="sihRecord.LOADING_RATE">率1</label>
    <label><input type="radio" name="r4" value="2" v-model="sihRecord.LOADING_RATE">率2</label>
    <label><input type="radio" name="r4" value="3" v-model="sihRecord.LOADING_RATE">率3</label>
    </div>
  </div> -->

  <br />

  <div class="tv">
    <div class="title">受注No.</div>
    <div class="value">
    <input type="text" size="10" v-bind:disabled="true" v-model="sihRecord.ORDER_NO">
    </div>
  </div>
  <div class="tv">
    <div class="title">発注者</div>
    <div class="value">
    <select v-model="sihRecord.ORDER2_USER" :ref="'orderUser2'" @keyup.enter="moveToNextField('orderUser2')">
      <option v-for="user in master.Users" :key="user.CODE" :value="user.CODE">{{ user.CODE }}:{{ user.NAME }}</option>
    </select>
    </div>
  </div>
  <div class="tv">
    <div class="title">出荷日</div>
    <div class="value">
    <input type="date" max="9999-12-31" name="example" v-model="sihRecord.SHIP_DATE" :ref="'shipDate'" @keyup.enter="moveToNextField('shipDate')">
    </div>
  </div>
  <div class="tv">
    <div class="title">納品日</div>
    <div class="value">
    <input type="date" name="example" max="9999-12-31" v-model="sihRecord.DELIVERY_DATE" :ref="'deliveryDate'" @keyup.enter="moveToNextField('deliveryDate')">
    <label><input type="radio" name="r1" value="3" v-model="sihRecord.DELIVERY_AMPM" :ref="'deliveryAmpn0'" @keyup.enter="moveToNextField('deliveryAmpn0')">無指定</label>
    <label><input type="radio" name="r1" value="1" v-model="sihRecord.DELIVERY_AMPM" :ref="'deliveryAmpn1'" @keyup.enter="moveToNextField('deliveryAmpn1')">AM</label>
    <label><input type="radio" name="r1" value="2" v-model="sihRecord.DELIVERY_AMPM" :ref="'deliveryAmpn2'" @keyup.enter="moveToNextField('deliveryAmpn2')">PM</label>
    <input type="time" v-bind:disabled="!(sihRecord.DELIVERY_AMPM==1||sihRecord.DELIVERY_AMPM==2)" v-model="sihRecord.DELIVERY_TIME" :ref="'deliveryTime'" @keyup.enter="moveToNextField('deliveryTime')">
    </div>
  </div>
  <br />

  <div class="tv">
    <div class="title">相手営業所</div>
    <div class="value" v-if="sihRecord.HCODE==4 || sihRecord.HCODE==5 || sihRecord.HCODE==6">
    <input type="text" autocomplete="off" size="6" list="offices" id="officesOtherCode" v-model="sihRecord.OFFICE_OTHER_CODE" v-on:keyup="officeOtherC2N()" v-on:blur="officeOtherBlur()" :ref="'officesOtherCode'" @keyup.enter="moveToNextField('officesOtherCode')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.OFFICE_OTHER_CODE='';officeOtherC2N();officeOtherBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('OfficeSearch')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.OFFICE_OTHER_NAME">
    </div>
  </div>
  <br />

  <div class="tv">
    <div class="title" v-on:mouseover="showInformation" v-on:mouseout="hideInformation">得意先
    <div class="information">得意先を指定してください。</div>
    </div>
    <!-- 売上の場合のみ表示 -->
    <div class="value"  v-if="sihRecord.HCODE==1 || sihRecord.HCODE==4">
    <input type="text" autocomplete="off" size="6" list="customers" id="customerCode" v-model="sihRecord.CUSTOMER_CODE" v-on:keyup="customerC2N()" v-on:blur="customerBlur()" :ref="'customerCode'" @keyup.enter="moveToNextField('customerCode')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.CUSTOMER_CODE='';customerC2N();customerBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('CustomerSearch')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.CUSTOMER_NAME">
    </div>
  </div>
  <br />

  <div class="tv">
    <div class="title" v-on:mouseover="showInformation" v-on:mouseout="hideInformation">納／倉
    <div class="information">納入先を指定してください。<br>（仕入の時は入荷する倉庫を指定）</div>
    </div>

    <!-- 売上の場合は納入先を表示 -->
    <div class="value" v-if="sihRecord.HCODE==1 || sihRecord.HCODE==4">
    <input type="text" autocomplete="off" size="6" list="delivery_destinations" id="deliveryCode" v-model="sihRecord.DELIVERY_CODE" v-on:keyup="deliveryC2N()" v-on:blur="deliveryBlur()" :ref="'deliveryCodeDelivery'" @keyup.enter="moveToNextField('deliveryCodeDelivery')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.DELIVERY_CODE='';deliveryC2N();deliveryBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('DeliverySearchDelivery')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.DELIVERY_NAME">
    </div>

    <!-- 仕入と移動は場合は倉庫を表示 -->
    <div class="value" v-if="sihRecord.HCODE!=1 && sihRecord.HCODE!=4 ">
    <input type="text" autocomplete="off" size="6" list="delivery_destinations" id="deliveryCode" v-model="sihRecord.DELIVERY_CODE" v-on:keyup="deliveryC2N()" v-on:blur="deliveryBlur()" :ref="'deliveryCodeWarehouse'" @keyup.enter="moveToNextField('deliveryCodeWarehouse')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.DELIVERY_CODE='';deliveryC2N();deliveryBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('WarehouseSearchDelivery')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.DELIVERY_NAME">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title" v-on:mouseover="showInformation" v-on:mouseout="hideInformation">仕入先
    <div class="information">仕入先を指定してください。</div>
    </div>
    <div class="value">
    <input type="text" autocomplete="off" size="6" list="suppliers" id="supplierCode" v-model="sihRecord.SUPPLIER_CODE" v-on:keyup="supplierC2N()" v-on:blur="supplierBlur()" :ref="'supplierCode'" @keyup.enter="moveToNextField('supplierCode')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.SUPPLIER_CODE='';supplierC2N();supplierBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('SupplierSearch')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.SUPPLIER_NAME">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title" v-on:mouseover="showInformation" v-on:mouseout="hideInformation">倉庫
    <div class="information">出荷倉庫を指定してください。<br>（仕入の時は仕入元の倉庫）</div>
    </div>
    <div class="value">
    <input type="text" autocomplete="off" size="6" list="warehouses" id="warehouseCode" v-model="sihRecord.WAREHOUSE_CODE" v-on:keyup="warehouseC2N()" v-on:blur="warehouseBlur()" :ref="'warehouseCode'" @keyup.enter="moveToNextField('warehouseCode')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.WAREHOUSE_CODE='';warehouseC2N();warehouseBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('WarehouseSearch')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.WAREHOUSE_NAME">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title">運転手</div>
    <div class="value">
    <input type="text" autocomplete="off" size="6" list="drivers" id="driverCode" v-model="sihRecord.DRIVER_CODE" v-on:keyup="driverC2N()" v-on:blur="driverBlur()" :ref="'driverCode'" @keyup.enter="moveToNextField('driverCode')">
    <font-awesome-icon icon="times" v-on:click="sihRecord.DRIVER_CODE='';driverC2N();driverBlur();" style="cursor:pointer;" />
    <font-awesome-icon icon="search" v-on:click="opneDialog('DriverSearch')" style="cursor:pointer;" />
    <input type="text" autocomplete="off" disabled v-model="sihRecord.DRIVER_NAME">
    </div>
  </div>
  <div class="tv">
    <div class="title">運送会社</div>
    <div class="value">
    <input type="text" autocomplete="off" size="10" disabled v-model="sihRecord.TRUCKER_CODE">
    <input type="text" autocomplete="off" disabled v-model="sihRecord.TRUCKER_NAME">
    </div>
  </div>
  <div class="tv">
    <div class="title">便区分</div>
    <div class="value">
    <input type="text" autocomplete="off" size="5" v-model="sihRecord.FLIGHTS" :ref="'flights'" @keyup.enter="moveToNextField('flights')">
    回目
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title">運賃</div>
    <div class="value"><input type="text" autocomplete="off" class="right" size="10" v-model="sihRecord.FEE" v-on:blur="sihRecord.FEE=comma(sihRecord.FEE)" v-on:focus="sihRecord.FEE=delcomma(sihRecord.FEE)" :ref="'fee'" @keyup.enter="moveToNextField('fee')"></div>
  </div>
  <div class="tv">
    <div class="title">付加</div>
    <div class="value"><input type="text" autocomplete="off" class="right" size="10" v-model="sihRecord.ADD_FEE" v-on:blur="sihRecord.ADD_FEE=comma(sihRecord.ADD_FEE)" v-on:focus="sihRecord.ADD_FEE=delcomma(sihRecord.ADD_FEE)" :ref="'addFee'" @keyup.enter="moveToNextField('addFee')"></div>
  </div>
  <div class="tv">
    <div class="title">有料道路代</div>
    <div class="value"><input type="text" autocomplete="off" class="right" size="10" v-model="sihRecord.HIGHWAY_FEE" v-on:blur="sihRecord.HIGHWAY_FEE=comma(sihRecord.HIGHWAY_FEE)" v-on:focus="sihRecord.HIGHWAY_FEE=delcomma(sihRecord.HIGHWAY_FEE)" :ref="'highwayFee'" @keyup.enter="moveToNextField('highwayFee')"></div>
  </div>
  <div class="tv">
    <div class="title">運賃振替</div>
    <div class="value">
    <label><input type="radio" name="radio" value="1" v-model="sihRecord.FEE_CLASS" :ref="'feeClass0'" @keyup.enter="moveToNextField('feeClass0')">他</label>
    <label><input type="radio" name="radio" value="2" v-model="sihRecord.FEE_CLASS" :ref="'feeClass1'" @keyup.enter="moveToNextField('feeClass1')">自</label>
    </div>
  </div>

  <pre></pre>

  <!--
  行の追加削除、上へ下へは次の感じ
  https://mae.chab.in/archives/2146
  -->

  <table class="searchResult" style="width:1330px">
    <tr>
    <th class="w20"></th>
    <th class="w40">区</th>
    <th class="w200">コード</th>
    <th class="w60"></th>
    <th class="w150">商品名</th>
    <th class="w60">入数</th>
    <th class="w60">袋数</th>
    <th class="w60">数量</th>
    <th class="showSmall">率</th>
    <th class="showSmall">積数</th>
    <th class="w70">積込場所</th>
    <th class="w100">積込場所名</th>
    <th class="w150">備考1</th>
    <th class="w150">備考2</th>
    </tr>
    <tr v-for="(sidRecord, index) of sidRecords" :key="index">
    <td>{{ index + 1 }}</td>
    <td>
      <input type="text" autocomplete="off" v-model="sidRecord.HCODE" list="hcodeD" class="w40" :ref="'hcode_' + index" @keyup.enter="moveToNextField('hcode_' + index)">
      <datalist id="hcodeD">
      <option v-for="hcodeD in master.HCodesD" :key="hcodeD.CODE" :value="hcodeD.CODE">{{ hcodeD.CODE }} {{ hcodeD.NAME }}</option>
      </datalist>
      <!--
      <select style="width:40px;" v-model="sidRecord.HCODE">
      <option v-for="hcodeD in mstHCodesD" :key="hcodeD.CODE" :value="hcodeD.CODE">{{ hcodeD.CODE }} {{ hcodeD.NAME }}</option>
      </select>
      -->
    </td>
    <td v-bind:class="{warning: itemWarning(index)}">
      <input type="text" autocomplete="off" size="16" list="items_rel" :value="sidRecord.ITEM_CODE | upperCase" @input.lazy="sidRecord.ITEM_CODE = ($event.target.value).toUpperCase()" v-on:keyup="itemC2N(index)" v-on:blur="itemBlur(index);" :ref="'itemCode_' + index" @keyup.enter="moveToNextField('itemCode_' + index)">
      <font-awesome-icon icon="times" v-on:click="sidRecord.ITEM_CODE='';itemBlur(index);" style="cursor:pointer;" />
      <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="showDialog.ItemSearchIndex=index;opneDialog('ItemSearch')" />
    </td>
    <td>
      <font-awesome-icon icon="arrow-up"  style="cursor:pointer;" v-on:click="sidRowSwap(index, 'up')" />
      <font-awesome-icon icon="arrow-down"  style="cursor:pointer;" v-on:click="sidRowSwap(index, 'down')" />
      <font-awesome-icon icon="trash"     style="cursor:pointer;" v-on:click="sidRowDel(index)" />
    </td>
    <td>
      <div v-if="sidRecord.ITEM_NAME!=null" v-on:click="openStocksDetail(sidRecord.ITEM_CODE)"  style="text-decoration:underline;color:#0000ff;cursor:pointer;">{{ sidRecord.ITEM_NAME }}</div>
    </td>
    <td v-bind:class="{warning:qtyPerCtnWarning(index)}">
      <input type="number" autocomplete="off" class="delspinner" size="5" style="text-align:right;width:50px;" v-model="sidRecord.QTY_PER_CTN" :ref="'qtyPerCtn_' + index" @keyup.enter="moveToNextField('qtyPerCtn_' + index)">
    </td>
    <td>
      <input type="number" autocomplete="off" size="5" style="text-align:right;width:50px;" v-model="sidRecord.QTY_CTN" :ref="'qtyCtn_' + index" @keyup.enter="moveToNextField('qtyCtn_' + index)">
    </td>
    <td class="right">{{ sidRecord.QTY = (sidRecord.QTY_PER_CTN * sidRecord.QTY_CTN) == 0 ? "":(sidRecord.QTY_PER_CTN * sidRecord.QTY_CTN) | comma }}</td>
    <td class="right showSmall">{{ sidRecord.QTY_CTN2 |decimalFormat }}</td>
    <td class="right showSmall">{{ sidRecord.QTY2 = (sidRecord.QTY_CTN * sidRecord.QTY_CTN2) | decimalFormat }}</td>
    <td class="center">
      <select style="width:40px;" v-model="sidRecord.LOADING_PLACE_CODE" v-on:change="placeBlur(index)" :ref="'loadingPlaceCode_' + index" @keyup.enter="moveToNextField('loadingPlaceCode_' + index)">
      <option v-for="place in master.Places" :key="place.CODE" :value="place.CODE">{{ place.CODE }} {{ place.NAME }}</option>
      </select>
    </td>
    <td>
      <input type="text" autocomplete="off" size="10" v-model="sidRecord.LOADING_PLACE_NAME" :ref="'loadingPlaceName_' + index" @keyup.enter="moveToNextField('loadingPlaceName_' + index)">
    </td>
    <td>
      <input type="text" autocomplete="off" size="" list="remark" v-model="sidRecord.REMARK1" :ref="'ramark1_' + index" @keyup.enter="moveToNextField('ramark1_' + index)">
      <datalist id="remark">
      <option v-for="(remark, index) in master.Remarks" :key="index">{{ remark.name }}</option>
      </datalist>
    </td>
    <td>
      <input type="text" autocomplete="off" size="" list="remark" v-model="sidRecord.REMARK2" :ref="'ramark2_' + index" @keyup.enter="moveToNextField('ramark2_' + index)">
    </td>
    </tr>
    <tr>
    <td colspan=8 ></td>
    <td><input type="text" autocomplete="off" class="showSmall" disabled name="" v-model="wariai"></td>
    <td colspan=4></td>
    </tr>
  </table>

  <pre>　</pre>

  <div class="tv">
    <div class="title">続き</div>
    <div class="value">
    <input type="radio" name="r3" value="1" v-model="sihRecord.CONTINUED_SHEET" :ref="'continuedSheet0'" @keyup.enter="moveToNextField('continuedSheet0')">有
    <input type="radio" name="r3" value="2" v-model="sihRecord.CONTINUED_SHEET" :ref="'continuedSheet1'" @keyup.enter="moveToNextField('continuedSheet1')">無
    <input type="number" autocomplete="off" class="right w40 delspinner" size="1" name="" v-model="sihRecord.CURRENT_SHEET" :ref="'currentSheet'" @keyup.enter="moveToNextField('currentSheet')">枚目
    <input type="number" autocomplete="off" class="right w40 delspinner" size="1" name="" v-model="sihRecord.ALL_SHEET" :ref="'allSheet'" @keyup.enter="moveToNextField('allSheet')">枚中
    割合<input type="text" disabled name="" v-model="wariai">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title">送り状記事</div>
    <div class="value">
    <input type="text" autocomplete="off" size="120" placeholder="送り状に記事がある場合はここに入力" v-model="sihRecord.INVOICE_NOTE" :ref="'invoiceNote'" @keyup.enter="moveToNextField('invoiceNote')">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title">納品書記事</div>
    <div class="value">
    <input type="text" autocomplete="off" size="120" placeholder="納品書に記事がある場合はここに入力" v-model="sihRecord.DELIVERY_NOTE" :ref="'deliveryNote'" @keyup.enter="moveToNextField('deliveryNote')">
    </div>
  </div>

  <br />

  <div class="tv">
    <div class="title">付箋</div>
    <div class="value">
    <input type="text" autocomplete="off" size="120" placeholder="ここに何か入力すると付箋になります。" v-model="sihRecord.TAG_NOTE" :ref="'tagNote'" @keyup.enter="moveToNextField('tagNote')">
    </div>
  </div>
  </div>
  <!-- 得意先 -->
  <CustomerSearchDialog  v-if="showDialog.CustomerSearch"          :officeCode="this.officeCode"           :hCode="String(sihRecord.HCODE)"                         @close="closeDialog('CustomerSearch')"  @select="selectCustomerDialog"  ></CustomerSearchDialog>
  <!-- 納入先 -->
  <DeliverySearchDialog  v-if="showDialog.DeliverySearchDelivery"  :officeCode="this.officeCode"           :hCode="String(sihRecord.HCODE)" :customerCode="sihRecord.CUSTOMER_CODE" @close="closeDialog('DeliverySearchDelivery')"  @select="selectDeliveryDialog"  ></DeliverySearchDialog>
  <!-- 倉庫 -->
  <WarehouseSearchDialog v-if="showDialog.WarehouseSearchDelivery" :officeCode="this.getOfficeOtherCode()" :hCode="String(sihRecord.HCODE)"                  @close="closeDialog('WarehouseSearchDelivery')" @select="selectDeliveryDialog" ></WarehouseSearchDialog>

  <!-- 仕入先 -->
  <SupplierSearchDialog  v-if="showDialog.SupplierSearch"          :officeCode="this.getOfficeOtherCode()" :hCode="String(sihRecord.HCODE)"                      @close="closeDialog('SupplierSearch')"  @select="selectSupplierDialog"  ></SupplierSearchDialog>
  <!-- 倉庫 -->
  <WarehouseSearchDialog v-if="showDialog.WarehouseSearch"         :officeCode="this.getOfficeOtherCode()" :hCode="String(sihRecord.HCODE)"                      @close="closeDialog('WarehouseSearch')" @select="selectWarehouseDialog" ></WarehouseSearchDialog>
  <!-- 運転手 -->
  <DriverSearchDialog    v-if="showDialog.DriverSearch"            :officeCode="this.officeCode" :officeOtherCode="this.getOfficeOtherCode()" :hCode="String(sihRecord.HCODE)"     @close="closeDialog('DriverSearch')"  @select="selectDriverDialog"  ></DriverSearchDialog>

  <!-- 商品 -->
  <ItemSearchDialog      v-if="showDialog.ItemSearch"    :searchHcode="String(sihRecord.HCODE)" :searchCustomerCode="sihRecord.CUSTOMER_CODE" :searchDeliveryCode="sihRecord.DELIVERY_CODE" :searchSupplierCode="sihRecord.SUPPLIER_CODE" @close="closeDialog('ItemSearch')"    @select="selectItemDialog"    ></ItemSearchDialog>

  <!-- 営業所 -->
  <OfficeSearchDialog    v-if="showDialog.OfficeSearch"                                                       @close="closeDialog('OfficeSearch')"  @select="selectOfficeDialog"  ></OfficeSearchDialog>

  <!-- 複写 -->
  <InputShippingDialog   v-if="showDialog.InputShippingCp" @close="closeDialog('InputShippingCp')" @complete="copyDetail"  :mode="'copy'"  :hCode="String(sihRecord.HCODE)" :baseSihId="sihRecord.SIH_ID" ></InputShippingDialog>

</div>
</template>
<script>
import axios from 'axios';
import router from './../router'
import store from "./../store"
export default {
  data() {
    return {
      // 画面ロック
      inert: false,   // 初期値の設定

      // ダイアログ表示フラグ
      showDialog: {
        'CustomerSearch': false,								// 得意先検索ダイアログの表示・非表示管理フラグ
        'DeliverySearchDelivery': false,				// 納入先検索ダイアログの表示・非表示管理フラグ(納／倉)
        'WarehouseSearchDelivery': false,				// 倉庫検索ダイアログの表示・非表示管理フラグ(納／倉)
        'SupplierSearch': false,								// 仕入先検索ダイアログの表示・非表示管理フラグ
        'WarehouseSearch': false,								// 倉庫検索ダイアログの表示・非表示管理フラグ
        'DriverSearch': false,									// 運転手検索ダイアログの表示・非表示管理フラグ
        'ItemSearch': false,										// 商品検索ダイアログの表示・非表示管理フラグ
        'ItemSearchIndex': -1,									// 商品検索ダイアログの検索結果格納先Index(明細が複数存在している為)
        'OfficeSearch': false,									// 営業所検索ダイアログの表示・非表示管理フラグ
        'InputShippingCp': false,								// 複写ダイアログの表示・非表示管理フラグ
      },

      // ドロップダウン元ネタ
      master: {
        'Users':[],
        'HCodesD': [],
        'Places': [],
        'Remarks': [],
      },

      // 営業所コード
      officeCode:"",
      // // 相手営業所コード
      // officeOtherCode:"",

      // ヘッダーとボディデータ
      sihRecord: {
        'STATUS': 0
      },
      sidRecords: [],

      //一時保存値
      origin: {
        'OfficeOtherCode': '',
        'CustomerCode': '',
        'DeliveryCode': '',
        'SupplierCode': '',
        'WarehouseCode': '',
        'DriverCode': '',
        'ItemCode': [],
      },

      // 新規or更新
      isNew : true,
    }
  },
  methods: {

    //-------------------------------
    // 初期処理
    //-------------------------------
    init: async function(sihId, orderNo, hCode, shipDate, userCode, sihIdBase){

      var URL = "";
      if (sihId != "" && orderNo != "" && hCode != "" && shipDate != "" && userCode != "" && sihIdBase) {
        URL = "/api/shippingDetail/" + sihId + "/" + orderNo + "/" + hCode + "/" + shipDate + "/" + userCode + "/" + sihIdBase;
      } else if (sihId != "" && orderNo != "" && hCode != "" && shipDate != "" && userCode != "") {
        URL = "/api/shippingDetail/" + sihId + "/" + orderNo + "/" + hCode + "/" + shipDate + "/" + userCode;
      } else if (sihId != "") {
        URL = "/api/shippingDetail/" + sihId;
      }

      await axios.get(URL, {})
      .then(response =>{
        //---------------------------------------------------------------------
        // 表示するデータの確定
        //---------------------------------------------------------------------
        this.isNew      = response.data.isNew;
        this.sihRecord    = response.data.sihRecord;
        this.sidRecords     = response.data.sidRecords;
        this.officeCode     = response.data.officeCode;
      })

      //画面名称の設定
      document.title="出荷指示: " + this.sihRecord.ORDER_NO;

      //初期得意先の設定
      this.origin = {
        'OfficeOtherCode': this.sihRecord.OFFICE_OTHER_CODE,
        'CustomerCode': this.sihRecord.CUSTOMER_CODE,
        'DeliveryCode': this.sihRecord.DELIVERY_CODE,
        'SupplierCode': this.sihRecord.SUPPLIER_CODE,
        'WarehouseCode': this.sihRecord.WAREHOUSE_CODE,
        'DriverCode': this.sihRecord.DRIVER_CODE,
        'ItemCode': [],
        'PlaceCode': [],
      }
      for (var i = 0; i < this.sidRecords.length; i++) {
        this.origin.ItemCode.push(this.sidRecords[i].ITEM_CODE);
        this.origin.PlaceCode.push(this.sidRecords[i].LOADING_PLACE_CODE);
      }

      // // 相手営業所がない場合は、自営業所を格納する。
      // if (this.sihRecord.OFFICE_OTHER_CODE == null) { 
      //   this.sihRecord.OFFICE_OTHER_CODE = this.officeCode;
      //   this.origin.OfficeOtherCode = this.officeCode;
      // }

      //画面表示時にコンマ表示を行う
      this.sihRecord.FEE=this.comma(this.sihRecord.FEE);
      this.sihRecord.ADD_FEE=this.comma(this.sihRecord.ADD_FEE);
      this.sihRecord.HIGHWAY_FEE=this.comma(this.sihRecord.HIGHWAY_FEE);

      //背景色の変更
      // 仮
      if (this.sihRecord.KARI == 1) {
        // 仮
        document.body.style.background = 'rgb(223, 255, 223)' // 緑
      } else {
        if (this.sihRecord.STATUS == 0) {
          // 通常
          document.body.style.background = 'rgb(223, 255, 255)' // 青
        } else if (this.sihRecord.STATUS == 1) {
          // 入力確定
          document.body.style.background = 'rgb(255, 255, 223)' // 黄
        } else if (this.sihRecord.STATUS == 3){
          // 端数完了
          document.body.style.background = 'rgb(255, 223, 159)' // 橙
        } else if (this.sihRecord.STATUS == 2) {
          // 出荷完了
          document.body.style.background = 'rgb(255, 223, 223)' // 赤
        }
      }
      
      // 読込回数が多いのでまとめて取得できないか？
      await axios.post("/api/master/detail", {
      'HCODE'  : this.sihRecord.HCODE,
      })
      .then(response => {
        var data = response.data;
        this.master = {
          'Users': data.users,
          'HCodesD': data.hcodesD,
          'Places': data.places,
          'Remarks': data.remarks,
        }
      });

      await this.officeOtherC2N();
      await this.officeOtherBlur();
      await this.deliveryC2N();
      await this.deliveryBlur();
      await this.supplierC2N();
      await this.supplierBlur();

      // 初期フォーカスの設定
      this.setNextField();
      this.$nextTick(() => this.moveToNextField('deliveryTime'));
      // this.$nextTick(() => $("#orderDate").focus());

    },

    //-------------------------------------------------------------------------
    // 画面上部ボタンイベント
    //-------------------------------------------------------------------------
    
    // 戻る
    back: function(){
      // 検索条件保持したまま戻りたいので、その方法を検討
      // ローカルストレージかなぁ・・・
      if (this.sihRecord.STATUS == 99) {
        if (confirm("未保存データです。削除しますか？")) {
          router.push("/?isBack=true")
        }
      } else {
        router.push("/?isBack=true")
      }
    },

    // 複写
    copy: function(){
      this.opneDialog('InputShippingCp');
    },
    copyDetail: function(sihId, hCode, shipDate, userCode, sihIdBase){
      this.closeDialog('InputShippingCp');
      router.push({ path: "/detail/" + sihId + "_" + hCode + "_" + shipDate + "_" + userCode + "_" + sihIdBase });
    },

    // 一時保存
    susp: async function(){
      // IDと受注番号は登録時に最新を取り直す。
      if (confirm("一時保存します。よろしいですか？")) {
        await axios.post("/api/shipping/susp", {
          'isNew'   : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords,
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("保存しました。" + "\r\n" + "受注No：" + orderNo);
          this.$nextTick(() => {
            this.init(sihId, orderNo, "", "", "", "");
          });
        });
      }
    },

    // 入力確定
    conf: async function() {
      if (confirm("入力確定をします。よろしいですか？")) {
        await axios.post("/api/shipping/conf", {
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords,
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("確定しました。" + "\r\n" + "受注No：" + orderNo);
          this.$nextTick(() => {
            this.init(sihId, orderNo, "", "", "", "");
            // router.push("/?isBack=true");
          });
        });
      }
    },

    // 出荷完了
    comp: async function() {
      if (confirm("出荷完了をします。よろしいですか？")) {
        await axios.post("/api/shipping/comp", {
          'isNew'   : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords,
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("完了しました。" + "\r\n" + "受注No：" + orderNo);
          this.$nextTick(() => {
            this.init(sihId, orderNo, "", "", "", "");
            // router.push("/?isBack=true");
          });
        });
      }
    },

    // 削除
    del: async function(){
      if (confirm("本当に削除してもよろしいですか？")){
        await axios.delete("/api/shipping/", {
          data : { 'sihId': this.sihRecord["SIH_ID"] }
        }).then(response => {
          alert("削除しました。");
          this.$nextTick(() => {
            router.push("/?isBack=true");
          });
        });
      }
    },

    // 指示書入力
    instructionPrint: async function(){
      await axios.post("/api/shipping/inst", {
        'isNew'     : this.isNew,
        'sihRecord' : this.sihRecord,
        'sidRecords': this.sidRecords,
      })
      .then(response => {
        var sihId = response.data.SIH_ID;
        var orderNo = response.data.ORDER_NO;
        const printWindow = window.open("/shipping/instructionPrint/" + sihId);
        // 再描画のタイミングズレの吸収
        this.$nextTick(() => {
          this.init(sihId, orderNo, "", "", "", "");
          // router.push("/?isBack=true");
        });
      });
    },

    // 伝票印刷
    slipPrint: async function(){
      await axios.post("/api/shipping/vouc", {
        'isNew'     : this.isNew,
        'sihRecord' : this.sihRecord,
        'sidRecords': this.sidRecords,
      })
      .then(response => {
        var sihId = response.data.SIH_ID;
        var orderNo = response.data.ORDER_NO;
        const printWindow = window.open("/shipping/slipPrint/" + sihId);
        // 再描画のタイミングズレの吸収
        this.$nextTick(() => {
          this.init(sihId, orderNo, "", "", "", "");
          // router.push("/?isBack=true");
        });
      });
    },

    // 日時フォーマット
    toDateTimeComp: function(dateObj){
      if (dateObj == null){ return ""; }
      var dateValue = dateObj.substr(0,16).split("-").join("/");
      return dateValue;
    },

    // 在庫照会
    openStocksDetail: function(itemCode){
      if (store.state.stocksDetailURL == null || store.state.stocksDetailURL == ""){
        alert("在庫詳細のURLが設定されていません");
        return;
      }
      var linkURL = store.state.stocksDetailURL;
      linkURL += "?sub=1";
      linkURL += "&ITEM_CODE=" + encodeURIComponent(itemCode);
      linkURL += "&WAREHOUSE_CODE=" + ((this.sihRecord.WAREHOUSE_CODE==null||this.sihRecord.WAREHOUSE_CODE=="")?"":encodeURI(this.sihRecord.WAREHOUSE_CODE));
      linkURL += "&user_code=Nologin";
      window.open(linkURL,'sub','width=600,height=400,scrollbars=yes');
    },

    //-------------------------------------------------------------------------
    // ダイアログのオープンクローズ
    //-------------------------------------------------------------------------
    setInert:function(value) { this.inert = value; },
    opneDialog:function (dialog) {
      this.setInert(true);
      this.showDialog[dialog] = true;
    },
    closeDialog:function (dialog)   {
      this.setInert(false);
      this.showDialog[dialog] = false;
    },
    //-------------------------------------------------------------------------
    // ダイアログのオープンクローズ
    //-------------------------------------------------------------------------
    showInformation : function(event){
      $(event.currentTarget).find("div.information").show();
    },
    hideInformation: function(event){
      $(event.currentTarget).find("div.information").hide();
    },
    //-------------------------------------------------------------------------
    // ダイアログで選択した値を反映
    //-------------------------------------------------------------------------
    // 営業所ダイアログで選択した営業所を格納してダイアログを閉じる
    selectOfficeDialog: function(officeCode){
      this.sihRecord.OFFICE_OTHER_CODE = officeCode;
      this.closeDialog('OfficeSearch');
      this.officeOtherBlur();
      this.officeOtherC2N();
      this.$nextTick(() => this.moveToNextField('officesOtherCode'));
    },
    // 得意先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectCustomerDialog: function(customerCode){
      this.sihRecord.CUSTOMER_CODE = customerCode;
      this.closeDialog('CustomerSearch');
      this.customerBlur();
      this.customerC2N();
      this.$nextTick(() => this.moveToNextField('customerCode'));
    },
    // 納入先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectDeliveryDialog: function(deliveryCode){
      this.sihRecord.DELIVERY_CODE = deliveryCode;
      this.closeDialog('DeliverySearchDelivery');
      this.closeDialog('WarehouseSearchDelivery');
      this.deliveryBlur();
      this.deliveryC2N();
      this.$nextTick(() => this.moveToNextField('deliveryCodeDelivery'));
    },
    // 仕入先ダイアログで選択した仕入先を格納してダイアログを閉じる
    selectSupplierDialog: function(supplierCode){
      this.sihRecord.SUPPLIER_CODE = supplierCode;
      this.closeDialog('SupplierSearch');
      this.supplierBlur();
      this.supplierC2N();
      this.$nextTick(() => this.moveToNextField('supplierCode'));
    },
    // 倉庫ダイアログで選択した倉庫を格納してダイアログを閉じる
    selectWarehouseDialog: function(warehouseCode){
      this.sihRecord.WAREHOUSE_CODE = warehouseCode;
      this.closeDialog('WarehouseSearch');
      this.warehouseBlur();
      this.warehouseC2N();
      this.$nextTick(() => this.moveToNextField('warehouseCode'));
    },
    // 運転手ダイアログで選択した運転手を格納してダイアログを閉じる
    selectDriverDialog: function(driverCode, truckerCode, companyCode){
      this.sihRecord.TRUCKER_CODE = truckerCode;
      this.sihRecord.DRIVER_CODE = driverCode;
      this.closeDialog('DriverSearch');
      this.driverBlur();
      this.driverC2N();
      this.$nextTick(() => this.moveToNextField('driverCode'));
    },
    // 商品ダイアログで選択した商品を格納してダイアログを閉じる
    selectItemDialog: function(item){
      var index = this.showDialog.ItemSearchIndex;
      this.sidRecords[index].ITEM_CODE = item.CODE;
      // this.sidRecords[index]["items_rel"] = item;
      this.closeDialog('ItemSearch');
      // this.itemUpdate(index);
      this.itemBlur(index);
      this.itemC2N(index);
      this.$nextTick(() => this.moveToNextField('itemCode_' + index));
    },

    //-------------------------------------------------------------------------
    // マスタ検索
    //-------------------------------------------------------------------------
    // 営業所
    getOfficeName: async function (officeCode){
      var result = "";
      await axios.post("/api/master/getOfficeName", { 'code': officeCode }).then(response => { result = response.data; });
      return result;
    },
    // 得意先
    getCustomerName: async function (customerCode){
      var result = "";
      await axios.post("/api/master/getCustomerName", { 'code': customerCode }).then(response => { result = response.data; });
      return result;
    },
    // 納入先
    getDeliverieName: async function (deliverieCode, customerCode){
      var result = "";
      await axios.post("/api/master/getDeliverieName", { 'code': deliverieCode, 'customerCode': customerCode }).then(response => { result = response.data; });
      return result;
    },
    // 仕入先
    getSupplierName: async function (supplierCode){
      var result = "";
      await axios.post("/api/master/getSupplierName", { 'code': supplierCode }).then(response => { result = response.data; });
      return result;
    },
    // 倉庫
    getWarehouseName: async function (warehouseCode){
      var result = "";
      await axios.post("/api/master/getWarehouseName", { 'code': warehouseCode }).then(response => { result = response.data; });
      return result;
    },
    // 運送会社
    getTruckerName: async function (truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getTruckerName", { 'code': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },
    // 運転手
    getDriverName: async function (driverCode, truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getDriverName", { 'code': driverCode, 'truckerCode': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },
    // 特殊処理、運転手コードから運送会社コードを取得
    getDriverTrucker: async function (driverCode, truckerCode, companyCode){
      var result = "";
      await axios.post("/api/master/getDriverTrucker", { 'code': driverCode, 'truckerCode': truckerCode, 'companyCode': companyCode }).then(response => { result = response.data; });
      return result;
    },
    // 商品情報
    getItemData: async function (itemCode, hCode, customerCode, deliveryCode, supplierCode){
      var result = "";
      await axios.post("/api/master/getItemData", { 
        'code': itemCode,
        'hCode': hCode,
        'customerCode': customerCode,
        'deliveryCode': deliveryCode,
        'supplierCode': supplierCode,
      }).then(response => { result = response.data; });
      return result;
    },
    // 置場
    getPlaceName: async function (placeCode){
      var result = "";
      await axios.post("/api/master/getPlaceName", { 'code': placeCode }).then(response => { result = response.data; });
      return result;
    },

    //-------------------------------------------------------------------------
    // 相手営業所取得
    //-------------------------------------------------------------------------
    getOfficeOtherCode: function (){
      return (this.sihRecord.OFFICE_OTHER_CODE??this.officeCode);
    },

    //-------------------------------------------------------------------------
    // 相手営業所関連
    //-------------------------------------------------------------------------
    // キー入力
    officeOtherC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.OFFICE_OTHER_CODE??"").length < 3) { this.sihRecord.OFFICE_OTHER_NAME = ""; return; }
      // 変更がある場合のみ処理
      if (this.origin.OfficeOtherCode == this.sihRecord.OFFICE_OTHER_CODE) return;
      // 変更値を格納
      this.origin.OfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE;
      // 名称取得
      this.sihRecord.OFFICE_OTHER_NAME = await this.getOfficeName(this.sihRecord.OFFICE_OTHER_CODE);
    },
    // フォーカスアウト
    officeOtherBlur: async function(){
      // 変更がある場合のみ処理
      if (this.origin.OfficeOtherCode == this.sihRecord.OFFICE_OTHER_CODE) return;
      // 仕入先/倉庫/運転手をクリアする。
      this.sihRecord.SUPPLIER_CODE = "";
      this.sihRecord.SUPPLIER_NAME = "";
      this.sihRecord.WAREHOUSE_CODE = "";
      this.sihRecord.WAREHOUSE_NAME = "";
      this.sihRecord.DRIVER_CODE = "";
      this.sihRecord.DRIVER_NAME = "";
      this.sihRecord.TRUCKER_CODE = "";
      this.sihRecord.TRUCKER_NAME = "";
      // 名称取得
      this.sihRecord.OFFICE_OTHER_NAME = await this.getOfficeName(this.sihRecord.OFFICE_OTHER_CODE)
      // 変更値を格納
      this.origin.OfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE;
      // 
      this.officeOtherC2N();
    },

    //-------------------------------------------------------------------------
    // 得意先関連
    //-------------------------------------------------------------------------
    // キー入力
    customerC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.CUSTOMER_CODE??"").length < 7) { this.sihRecord.CUSTOMER_NAME = ""; return; }
      // 変更がある場合のみ処理
      if (this.origin.CustomerCode == this.sihRecord.CUSTOMER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.CustomerCode = this.sihRecord.CUSTOMER_CODE;
      // 名称取得
      this.sihRecord.CUSTOMER_NAME = await this.getCustomerName(this.sihRecord.CUSTOMER_CODE);
    },
    // フォーカスアウト
    customerBlur: async function(){

      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecord.CUSTOMER_CODE??"").length && (this.sihRecord.CUSTOMER_CODE??"").length <= 4){
        this.sihRecord.CUSTOMER_CODE = this.officeCode + this.sihRecord.CUSTOMER_CODE.padStart(4, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.CustomerCode == this.sihRecord.CUSTOMER_CODE) return;
      // 関連する項目のリセット
      this.sihRecord.DELIVERY_CODE   = null;
      this.sihRecord.DELIVERY_NAME   = null;
      this.sihRecord.CONTINUED_SHEET = null
      this.sihRecord.CURRENT_SHEET   = null
      this.sihRecord.ALL_SHEET       = null
      this.sihRecord.INVOICE_NOTE    = null
      this.sihRecord.DELIVERY_NOTE   = null
      this.sihRecord.TAG_NOTE        = null
      for (var i = 0; i < this.sidRecords.length; i++){
        this.sidRecords[i].HCODE       = null;
        this.sidRecords[i].ITEM_CODE   = null;
        this.sidRecords[i].ITEM_NAME   = null;
        this.sidRecords[i].QTY_PER_CTN = null;
        this.sidRecords[i].QTY_CTN     = null;
        this.sidRecords[i].QTY         = null;
        this.sidRecords[i].QTY_CTN2    = null;
        this.sidRecords[i].QTY2        = null;
        this.sidRecords[i].LOADING_PLACE_CODE = null;
        this.sidRecords[i].LOADING_PLACE_NAME = null;
        this.sidRecords[i].REMARK1     = null;
        this.sidRecords[i].REMARK2     = null;
      }
      // 名称取得
      this.sihRecord.CUSTOMER_NAME = await this.getCustomerName(this.sihRecord.CUSTOMER_CODE);
      // 元値を新しい値に変更する
      this.origin.CustomerCode = this.sihRecord.CUSTOMER_CODE;
      // 
      this.customerC2N();
    },

    //-------------------------------------------------------------------------
    // 納入先関連
    //-------------------------------------------------------------------------
    // キー入力
    deliveryC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.DELIVERY_CODE??"").length < 7) { this.sihRecord.DELIVERY_NAME = ""; return; }
      // 変更がある場合のみ処理
      if (this.origin.DeliveryCode == this.sihRecord.DELIVERY_CODE) return;
      // 元値を新しい値に変更する
      this.origin.DeliveryCode = this.sihRecord.DELIVERY_CODE;
      // 名称取得
      // 取区が通常の場合
      if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4){
        this.sihRecord.DELIVERY_NAME = await this.getDeliverieName(this.sihRecord.DELIVERY_CODE, this.sihRecord.CUSTOMER_CODE);
      }
      // 取区が仕入・融通の場合
      if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4){
        this.sihRecord.DELIVERY_NAME = await this.getWarehouseName(this.sihRecord.DELIVERY_CODE);
      }
    },
    // フォーカスアウト
    deliveryBlur: async function(){

      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecord.DELIVERY_CODE??"").length && (this.sihRecord.DELIVERY_CODE??"").length <= 4){
        this.sihRecord.DELIVERY_CODE = this.officeCode + this.sihRecord.DELIVERY_CODE.padStart(4, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.DeliveryCode == this.sihRecord.DELIVERY_CODE) return;
      // 関連する項目のリセット
      this.sihRecord.CONTINUED_SHEET = null
      this.sihRecord.CURRENT_SHEET   = null
      this.sihRecord.ALL_SHEET       = null
      this.sihRecord.INVOICE_NOTE    = null
      this.sihRecord.DELIVERY_NOTE   = null
      this.sihRecord.TAG_NOTE        = null
      for (var i = 0; i < this.sidRecords.length; i++){
        this.sidRecords[i].HCODE       = null;
        this.sidRecords[i].ITEM_CODE   = null;
        this.sidRecords[i].ITEM_NAME   = null;
        this.sidRecords[i].QTY_PER_CTN = null;
        this.sidRecords[i].QTY_CTN     = null;
        this.sidRecords[i].QTY         = null;
        this.sidRecords[i].QTY_CTN2    = null;
        this.sidRecords[i].QTY2        = null;
        this.sidRecords[i].LOADING_PLACE_CODE = null;
        this.sidRecords[i].LOADING_PLACE_NAME = null;
        this.sidRecords[i].REMARK1     = null;
        this.sidRecords[i].REMARK2     = null;
      }
      // 名称取得
      // 取区が通常の場合
      if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4){
        this.sihRecord.DELIVERY_NAME = await this.getDeliverieName(this.sihRecord.DELIVERY_CODE, this.sihRecord.CUSTOMER_CODE);
      }
      // 取区が仕入・融通の場合
      if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4){
        this.sihRecord.DELIVERY_NAME = await this.getWarehouseName(this.sihRecord.DELIVERY_CODE);
      }
      // 元値を新しい値に変更する
      this.origin.DeliveryCode = this.sihRecord.DELIVERY_CODE;
      //
      this.deliveryC2N();
    },

    //-------------------------------------------------------------------------
    // 仕入先関連
    //-------------------------------------------------------------------------
    // キー入力
    supplierC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.SUPPLIER_CODE??"").length < 7) { this.sihRecord.SUPPLIER_NAME = ""; return; }
      // 変更がある場合のみ処理
      if (this.origin.SupplierCode == this.sihRecord.SUPPLIER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.SupplierCode = this.sihRecord.SUPPLIER_CODE;
      // 名称取得
      this.sihRecord.SUPPLIER_NAME = await this.getSupplierName(this.sihRecord.SUPPLIER_CODE);
    },
    // フォーカスアウト
    supplierBlur: async function(){

      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecord.SUPPLIER_CODE??"").length && (this.sihRecord.SUPPLIER_CODE??"").length <= 4){
        this.sihRecord.SUPPLIER_CODE = this.officeCode + this.sihRecord.SUPPLIER_CODE.padStart(4, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.SupplierCode == this.sihRecord.SUPPLIER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.SupplierCode = this.sihRecord.SUPPLIER_CODE;
      // 名称取得
      this.sihRecord.SUPPLIER_NAME = await this.getSupplierName(this.sihRecord.SUPPLIER_CODE);
      // 
      this.supplierC2N();
    },

    //-------------------------------------------------------------------------
    // 倉庫関連
    //-------------------------------------------------------------------------
    // キー入力
    warehouseC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.WAREHOUSE_CODE??"").length < 7) { this.sihRecord.WAREHOUSE_NAME = ""; return; }
      // 変更がある場合のみ処理
      if (this.origin.WarehouseCode == this.sihRecord.WAREHOUSE_CODE) return;
      // 元値を新しい値に変更する
      this.origin.WarehouseCode=this.sihRecord.WAREHOUSE_CODE;
      // 名称取得
      this.sihRecord.WAREHOUSE_NAME = await this.getWarehouseName(this.sihRecord.WAREHOUSE_CODE);
    },
    // フォーカスアウト
    warehouseBlur: async function(){
      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecord.WAREHOUSE_CODE??"").length && (this.sihRecord.WAREHOUSE_CODE??"").length <= 4){
        this.sihRecord.WAREHOUSE_CODE = this.officeCode + this.sihRecord.WAREHOUSE_CODE.padStart(4, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.WarehouseCode == this.sihRecord.WAREHOUSE_CODE) return;
      // 元値を新しい値に変更する
      this.origin.WarehouseCode=this.sihRecord.WAREHOUSE_CODE;
      // 名称取得
      this.sihRecord.WAREHOUSE_NAME = await this.getWarehouseName(this.sihRecord.WAREHOUSE_CODE);
      // 
      this.warehouseC2N();
    },

    //-------------------------------------------------------------------------
    // 運転手関連
    //-------------------------------------------------------------------------
    // キー入力
    driverC2N: async function (){
      // 桁数が一定以下を処理しない(DBへの通信回数を減らす)
      if ((this.sihRecord.DRIVER_CODE??"").length < 6) { 
        this.sihRecord.DRIVER_NAME = "";
        this.sihRecord.TRUCKER_CODE = "";
        this.sihRecord.TRUCKER_NAME = "";
        return;
      }
      // 変更がある場合のみ処理
      if (this.origin.DriverCode == this.sihRecord.DRIVER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.DriverCode = this.sihRecord.DRIVER_CODE;
      // 名称取得
      this.sihRecord.DRIVER_NAME = await this.getDriverName(this.sihRecord.DRIVER_CODE, this.sihRecord.TRUCKER_CODE, this.officeCode);
      this.sihRecord.TRUCKER_CODE = await this.getDriverTrucker(this.sihRecord.DRIVER_CODE, this.sihRecord.TRUCKER_CODE, this.officeCode);
      this.sihRecord.TRUCKER_NAME = await this.getTruckerName(this.sihRecord.TRUCKER_CODE, this.officeCode);
    },
    // フォーカスアウト
    driverBlur: async function(){
      // 営業所コードがない場合は付け足す
      if (1 <= (this.sihRecord.DRIVER_CODE??"").length && (this.sihRecord.DRIVER_CODE??"").length <= 6){
        this.sihRecord.DRIVER_CODE = this.sihRecord.DRIVER_CODE.padStart(6, '0');
      }
      // 変更がある場合のみ処理
      if (this.origin.DriverCode == this.sihRecord.DRIVER_CODE) return;
      // 元値を新しい値に変更する
      this.origin.DriverCode = this.sihRecord.DRIVER_CODE;
      // 名称取得
      this.sihRecord.DRIVER_NAME = await this.getDriverName(this.sihRecord.DRIVER_CODE, this.sihRecord.TRUCKER_CODE, this.officeCode);
      this.sihRecord.TRUCKER_CODE = await this.getDriverTrucker(this.sihRecord.DRIVER_CODE, this.sihRecord.TRUCKER_CODE, this.officeCode);
      this.sihRecord.TRUCKER_NAME = await this.getTruckerName(this.sihRecord.TRUCKER_CODE, this.officeCode);
      // 
      this.driverC2N();
    },

    //-------------------------------------------------------------------------
    // 商品関連
    //-------------------------------------------------------------------------
    // キー入力
    itemC2N: async function (index){
      // 商品は桁数が一定ではないので、ここでは処理しない。
    },
    // フォーカスアウト
    itemBlur: async function(index){
      // 変更がある場合のみ処理
      if (this.origin.ItemCode[index] == this.sidRecords[index].ITEM_CODE) return;
      // 名称,入数,袋数,数量
      var itemData = await this.getItemData(this.sidRecords[index].ITEM_CODE, this.sihRecord.HCODE, this.sihRecord.CUSTOMER_CODE, this.sihRecord.DELIVERY_CODE, this.sihRecord.SUPPLIER_CODE);
      this.sidRecords[index]["items_rel"] = itemData;

      if (this.sidRecords[index]["items_rel"] != null && this.sidRecords[index]["items_rel"] != "") {
        this.sidRecords[index].ITEM_NAME    = this.sidRecords[index]["items_rel"].NAME;
        this.sidRecords[index].QTY_PER_CTN  = this.sidRecords[index]["items_rel"].QTY_PER_CTN;
        this.sidRecords[index].QTY_CTN      = 1;
        // this.sidRecords[index].QTY          = (this.sidRecords[index].QTY_PER_CTN * this.sidRecords[index].QTY_CTN);
        if (this.sihRecord.LOADING_RATE == "1"){
          this.sidRecords[index].QTY_CTN2   = this.sidRecords[index]["items_rel"].RATE1;
        } else if (this.sihRecord.LOADING_RATE == "2"){
          this.sidRecords[index].QTY_CTN2   = this.sidRecords[index]["items_rel"].RATE2;
        } else if (this.sihRecord.LOADING_RATE == "3"){
          this.sidRecords[index].QTY_CTN2   = this.sidRecords[index]["items_rel"].RATE3;
        }
        // this.sidRecords[index].QTY2         = (this.sidRecords[index].QTY_PER_CTN * this.sidRecords[index].QTY2);
      } else {
        this.sidRecords[index].ITEM_NAME    = null;
        this.sidRecords[index].QTY_PER_CTN  = null;
        this.sidRecords[index].QTY_CTN      = null;
        this.sidRecords[index].QTY          = null;
        this.sidRecords[index].QTY_CTN2     = null;
        this.sidRecords[index].QTY2         = null;
      }
      // 元値を新しい値に変更する
      this.origin.ItemCode[index] = this.sidRecords[index].ITEM_CODE;
      // 
      this.itemC2N();
    },

    //-------------------------------------------------------------------------
    // 積込場所(置場)
    //-------------------------------------------------------------------------
    // フォーカスアウト
    placeBlur: async function(index) {
      // 変更がある場合のみ処理
      if (this.origin.PlaceCode[index] == this.sidRecords[index].LOADING_PLACE_CODE) return;
      // 名称取得
      this.sidRecords[index].LOADING_PLACE_NAME = await this.getPlaceName(this.sidRecords[index].LOADING_PLACE_CODE);
      // 元値を新しい値に変更する
      this.origin.PlaceCode[index]=this.sidRecords[index].LOADING_PLACE_CODE;
      // // 
      // this.placeC2N();
    },

    //-------------------------------------------------------------------------
    // 行操作
    //-------------------------------------------------------------------------
    // 上下入れ替え
    sidRowSwap: function(index, mode){
      if (index == 0 && mode == "up"){ return; }
      if (index == 7 && mode == "down"){ return; }

      if (mode == "down"){
        var baseRow = JSON.parse(JSON.stringify(this.sidRecords[index]));
        var targetRow = JSON.parse(JSON.stringify(this.sidRecords[index + 1]));
        this.sidRecords.splice(index, 1, targetRow);
        this.sidRecords.splice(index + 1, 1, baseRow);

        var baseRowItem = JSON.parse(JSON.stringify(this.origin.ItemCode[index]));
        var targetRowItem = JSON.parse(JSON.stringify(this.origin.ItemCode[index + 1]));
        this.origin.ItemCode.splice(index, 1, targetRowItem);
        this.origin.ItemCode.splice(index + 1, 1, baseRowItem);

        var baseRowPlace = JSON.parse(JSON.stringify(this.origin.PlaceCode[index]));
        var targetRowPlace = JSON.parse(JSON.stringify(this.origin.PlaceCode[index + 1]));
        this.origin.PlaceCode.splice(index, 1, targetRowPlace);
        this.origin.PlaceCode.splice(index + 1, 1, baseRowPlace);
      }
      if (mode == "up"){
        var baseRow = JSON.parse(JSON.stringify(this.sidRecords[index]));
        var targetRow = JSON.parse(JSON.stringify(this.sidRecords[index - 1]));
        this.sidRecords.splice(index,1,targetRow);
        this.sidRecords.splice(index - 1,1,baseRow);

        var baseRowItem = JSON.parse(JSON.stringify(this.origin.ItemCode[index]));
        var targetRowItem = JSON.parse(JSON.stringify(this.origin.ItemCode[index - 1]));
        this.origin.ItemCode.splice(index, 1, targetRowItem);
        this.origin.ItemCode.splice(index - 1, 1, baseRowItem);

        var baseRowPlace = JSON.parse(JSON.stringify(this.origin.PlaceCode[index]));
        var targetRowPlace = JSON.parse(JSON.stringify(this.origin.PlaceCode[index - 1]));
        this.origin.PlaceCode.splice(index, 1, targetRowPlace);
        this.origin.PlaceCode.splice(index - 1, 1, baseRowPlace);
      }
    },
    // 行の内容を削除
    sidRowDel: function(index){
      for (let key in this.sidRecords[index]) {
        if (key != 'ORDER_NO' && key != 'RNO') {
          this.sidRecords[index][key] = null;
        }
      }
      this.origin.ItemCode[index] = null;
      this.origin.PlaceCode[index] = null;
    },

    //-------------------------------------------------------------------------
    // 明細行の警告
    //-------------------------------------------------------------------------
    // 商品コードがデータリストに無い場合の警告
    itemWarning: function(index){
      if (this.sidRecords[index].ITEM_CODE == null || this.sidRecords[index].ITEM_CODE == "") {
        return false;
      }
      if (this.sidRecords[index]["items_rel"] != null && this.sidRecords[index]["items_rel"] != "") {
        return false;
      }
      return true;
    },

    // 商品コードがデータリストに無い場合の警告
    qtyPerCtnWarning: function(index){
      if (this.sidRecords[index].ITEM_CODE == null || this.sidRecords[index].ITEM_CODE == "") {
        return false;
      }
      if (this.sidRecords[index]["items_rel"] == null || this.sidRecords[index]["items_rel"] == "") {
        return false;
      }
      if (this.sidRecords[index]["items_rel"].QTY_PER_CTN == this.sidRecords[index].QTY_PER_CTN){
        return false;
      }
      return true;
    },

    //コンマ表示関連
    //コンマ表示
    comma:function(value){
      if (!value) return ''
      return value.toString().replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    },
    //コンマ除去
    delcomma:function(value){
      if (!value) return ''
      return value.toString().replace(/,/g, '');
    },

    //---------------------------------------------------------------------
    // タブキーorEnterキー
    //---------------------------------------------------------------------
    onFunctionKeys(event) {

      // Typescriptコンパイラに型を伝えるためのおまじない
      if (!(event.target instanceof HTMLElement)) {
        return; 
      }

      // Typescriptコンパイラに型を伝えるためのおまじない
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
          var record = this.nextFields.find(field => field.id === 'conf');
          if (!record.disabled) { this.conf();}
          break;
        case 'F12':
          // 
          event.preventDefault();
          break;
      }
    },
    setNextField() {

      // Enter移動の設定をする
      this.nextFields = []

      this.nextFields.push({ 'id':'back',       'disabled': false, });
      this.nextFields.push({ 'id':'copy',       'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==2)), });
      this.nextFields.push({ 'id':'susp',       'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==0||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'conf',       'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==1||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'comp',       'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==1||this.sihRecord.STATUS==3||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'del',        'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });
      this.nextFields.push({ 'id':'instructionPrint', 'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });
      this.nextFields.push({ 'id':'slipPrint',    'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });

      this.nextFields.push({ 'id':'orderDate',     'disabled': false, });
      this.nextFields.push({ 'id':'orderTime',     'disabled': false, });
      this.nextFields.push({ 'id':'orderUser',     'disabled': false, });
      this.nextFields.push({ 'id':'kari',        'disabled': false, });
      this.nextFields.push({ 'id':'orderUser2',    'disabled': false, });
      this.nextFields.push({ 'id':'shipDate',      'disabled': false, });
      this.nextFields.push({ 'id':'deliveryDate',    'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn0',   'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn1',   'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn2',   'disabled': false, });
      this.nextFields.push({ 'id':'deliveryTime',    'disabled': !(this.sihRecord.DELIVERY_AMPM==1||this.sihRecord.DELIVERY_AMPM==2), });

      this.nextFields.push({ 'id':'officesOtherCode',   'disabled': !(this.sihRecord.HCODE==4||this.sihRecord.HCODE==5||this.sihRecord.HCODE==6), });
      this.nextFields.push({ 'id':'customerCode',     'disabled': !(this.sihRecord.HCODE==1||this.sihRecord.HCODE==4), });
      this.nextFields.push({ 'id':'deliveryCodeDelivery', 'disabled': !(this.sihRecord.HCODE==1||this.sihRecord.HCODE==4), });
      this.nextFields.push({ 'id':'deliveryCodeWarehouse','disabled': !(this.sihRecord.HCODE!=1 && this.sihRecord.HCODE!=4), });
      this.nextFields.push({ 'id':'supplierCode',    'disabled': false, });
      this.nextFields.push({ 'id':'warehouseCode',     'disabled': false, });
      this.nextFields.push({ 'id':'driverCode',      'disabled': false, });
      this.nextFields.push({ 'id':'flights',        'disabled': false, });
      this.nextFields.push({ 'id':'fee',          'disabled': false, });
      this.nextFields.push({ 'id':'addFee',         'disabled': false, });
      this.nextFields.push({ 'id':'highwayFee',       'disabled': false, });
      this.nextFields.push({ 'id':'feeClass0',      'disabled': false, });
      this.nextFields.push({ 'id':'feeClass1',      'disabled': false, });

      for (var i = 0; i < this.sidRecords.length; i++) {
        this.nextFields.push({ 'id':'hcode_' + i,       'disabled': false, });
        this.nextFields.push({ 'id':'itemCode_' + i,      'disabled': false, });
        this.nextFields.push({ 'id':'qtyPerCtn_' + i,     'disabled': false, });
        this.nextFields.push({ 'id':'qtyCtn_' + i,      'disabled': false, });
        this.nextFields.push({ 'id':'loadingPlaceCode_' + i,  'disabled': false, });
        this.nextFields.push({ 'id':'loadingPlaceName_' + i,  'disabled': false, });
        this.nextFields.push({ 'id':'ramark1_' + i,       'disabled': false, });
        this.nextFields.push({ 'id':'ramark2_' + i,       'disabled': false, });
      }

      this.nextFields.push({ 'id':'continuedSheet0',  'disabled': false, });
      this.nextFields.push({ 'id':'continuedSheet1',  'disabled': false, });
      this.nextFields.push({ 'id':'currentSheet',     'disabled': false, });
      this.nextFields.push({ 'id':'allSheet',       'disabled': false, });
      this.nextFields.push({ 'id':'invoiceNote',    'disabled': false, });
      this.nextFields.push({ 'id':'deliveryNote',     'disabled': false, });
      this.nextFields.push({ 'id':'tagNote',      'disabled': false, });

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

  //---------------------------------------------------------------------------
  //
  // 画面ロード時処理
  //
  //---------------------------------------------------------------------------
  mounted: async function(){
    // 簡易ログインチェック
    if (store.state.userCode==null){ router.push({ path: "/sso" }); }
  },
  watch:{
    $route: {
      handler (){

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

      if (target != null){
        var targetSplit = target.split("_");
        if (targetSplit.length == 1) {
        // 修正
        sihId     = targetSplit[0];
        } else if (targetSplit.length == 5) {
        // 新規
        sihId     = targetSplit[0];
        orderNo   = targetSplit[1];
        hCode     = targetSplit[2];
        shipDate  = targetSplit[3];
        userCode  = targetSplit[4];
        } else if (targetSplit.length == 6) {
        // 複写
        sihId     = targetSplit[0];
        orderNo   = targetSplit[1];
        hCode     = targetSplit[2];
        shipDate  = targetSplit[3];
        userCode  = targetSplit[4];
        sihIdBase   = targetSplit[5];
        }

        //-------------------------------------------
        // 初期データ取得
        //-------------------------------------------
        this.init(sihId, orderNo, hCode, shipDate, userCode, sihIdBase);
      }

      },
      immediate: true
    },
  },
  
  computed: {
    wariai: function(){
      var wariai = 0;
      for (var count = 0 ; count < this.sidRecords.length ; count++){
        var sidRecord = this.sidRecords[count];
        wariai = wariai + sidRecord.QTY2;
      }
      return wariai.toFixed(1)
    },
  },

  beforeRouteUpdate(to, from, next){
    this.closeDialog('InputShippingCp');
    next();
    // this.load();
  },

  filters:{
    decimalFormat:function(value) {
      if (!value) return ''
      if(value == 0) return ''
      return Number(value).toFixed(1);
    },
    decimalFormatZero:function(value) {
      if (!value) return 0
      if (value == '' || value == null) return 0
      return Number(value).toFixed(0);
    },
    upperCase:function(value) {
      if (!value) return ''
      return value.toUpperCase();
    },
    comma:function(value){
      if (!value) return ''
      return value.toString().replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    },
  },
};

</script>
<style scoped>
  td.warning {
  background-color: yellow;
  }

  div.information {
  position: absolute;
  width: 240px;
  bottom: 30px;
  text-align: left;
  background-color: #ffffff;
  border: 1px solid #000000;
  border-radius: 3px;
  padding: 5px;
  box-sizing: border-box;
  font-size: 14px;
  min-height: 28px;
  display: none;
  }

  .showSmall{
  width:25px;
  font-size:13px;
  }

  .delspinner::-webkit-outer-spin-button,
  .delspinner::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
  }

  .delspinner{
  -moz-appearance:textfield;
  }

  .awake {
  background-color: #ffff00;
  border-color: blue;
  border-radius: 3px;
  border-width: 2px;
  }
  .awake:hover{
  background-color: #e6e600;
  }
</style>