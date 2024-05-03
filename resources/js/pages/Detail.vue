<template>
<div v-if="sihRecord!=null">
  <div :inert="inert" @keydown="onFunctionKeys">
    <input type="button" value="メイン画面" :ref="'back'"  v-on:click="back">

    <input v-bind:disabled="(isNew&&!(sihRecord.STATUS==1||sihRecord.STATUS==2))" type="button" value="複写" v-on:click="copy" :ref="'copy'" @keyup.enter="copy">
    <input v-bind:disabled="!(sihRecord.STATUS==0||sihRecord.STATUS==0||sihRecord.STATUS==99)" type="button" value="一時保存" v-on:click="susp" :ref="'susp'" @keyup.enter="susp">
    <input v-bind:disabled="!(sihRecord.STATUS==0||sihRecord.STATUS==1||sihRecord.STATUS==99)" type="button" class="awake" value="F10:入力確定" v-on:click="conf" :ref="'conf'" @keyup.enter="conf">
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
          <option v-for="user in mstUsers" :key="user.CODE" :value="user.CODE">{{ user.CODE }}:{{ user.NAME }}</option>
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
          <option v-for="user in mstUsers" :key="user.CODE" :value="user.CODE">{{ user.CODE }}:{{ user.NAME }}</option>
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
        <input type="text" autocomplete="off" size="6" list="suppliers" id="suppliersCode" v-model="sihRecord.SUPPLIER_CODE" v-on:keyup="supplierC2N()" v-on:blur="supplierBlur()" :ref="'suppliersCode'" @keyup.enter="moveToNextField('suppliersCode')">
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
        <input type="text" autocomplete="off" size="6" list="warehouses" id="warehousesCode" v-model="sihRecord.WAREHOUSE_CODE" v-on:keyup="warehouseC2N()" v-on:blur="warehouseBlur()" :ref="'warehousesCode'" @keyup.enter="moveToNextField('warehousesCode')">
        <font-awesome-icon icon="times" v-on:click="sihRecord.WAREHOUSE_CODE='';warehouseC2N();warehouseBlur();" style="cursor:pointer;" />
        <font-awesome-icon icon="search" v-on:click="opneDialog('WarehouseSearch')" style="cursor:pointer;" />
        <input type="text" autocomplete="off" size="50" disabled v-model="sihRecord.WAREHOUSE_NAME">
      </div>
    </div>

    <br />

    <div class="tv">
      <div class="title">運転手</div>
      <div class="value">
        <input type="text" autocomplete="off" size="6" list="drivers" id="driversCode" v-model="sihRecord.DRIVER_CODE" v-on:keyup="driverC2N()" v-on:blur="driverBlur()" :ref="'driversCode'" @keyup.enter="moveToNextField('driversCode')">
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
            <option v-for="hcodeD in mstHCodesD" :key="hcodeD.CODE" :value="hcodeD.CODE">{{ hcodeD.CODE }} {{ hcodeD.NAME }}</option>
          </datalist>
          <!--
          <select style="width:40px;" v-model="sidRecord.HCODE">
            <option v-for="hcodeD in mstHCodesD" :key="hcodeD.CODE" :value="hcodeD.CODE">{{ hcodeD.CODE }} {{ hcodeD.NAME }}</option>
          </select>
          -->
        </td>
        <td v-bind:class="{warning:itemWarning(index)}">
          <input type="text" autocomplete="off" size="16" list="items_rel" :value="sidRecord.ITEM_CODE | upperCase" @input.lazy="sidRecord.ITEM_CODE = ($event.target.value).toUpperCase()" v-on:blur="itemBlur(index);" :ref="'itemCode_' + index" @keyup.enter="moveToNextField('itemCode_' + index)">
          <font-awesome-icon icon="times" v-on:click="sidRecord.ITEM_CODE='';itemBlur(index);" style="cursor:pointer;" />
          <font-awesome-icon icon="search" style="cursor:pointer;" v-on:click="showDialog.ItemSearchIndex=index;opneDialog('ItemSearch')" />
        </td>
        <td>
          <font-awesome-icon icon="arrow-up"    style="cursor:pointer;" v-on:click="sidRowSwap(index, 'up')" />
          <font-awesome-icon icon="arrow-down"  style="cursor:pointer;" v-on:click="sidRowSwap(index, 'down')" />
          <font-awesome-icon icon="trash"       style="cursor:pointer;" v-on:click="sidRowDel(index)" />
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
          <select style="width:40px;" v-model="sidRecord.LOADING_PLACE_CODE" v-on:change="loadingPlacBlur(index)" :ref="'loadingPlaceCode_' + index" @keyup.enter="moveToNextField('loadingPlaceCode_' + index)">
            <option v-for="place in mstPlaces" :key="place.CODE" :value="place.CODE">{{ place.CODE }} {{ place.NAME }}</option>
          </select>
        </td>
        <td>
          <input type="text" autocomplete="off" size="10" v-model="sidRecord.LOADING_PLACE_NAME" :ref="'loadingPlaceName_' + index" @keyup.enter="moveToNextField('loadingPlaceName_' + index)">
        </td>
        <td>
          <input type="text" autocomplete="off" size="" list="remark" v-model="sidRecord.REMARK1" :ref="'ramark1_' + index" @keyup.enter="moveToNextField('ramark1_' + index)">
          <datalist id="remark">
            <option v-for="(remark, index) in mstRemarks" :key="index">{{ remark.name }}</option>
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
  <CustomerSearchDialog    v-if="showDialog.CustomerSearch"    :officeCode="this.officeCode" :hCode="sihRecord.HCODE"                                                 @close="closeDialog('CustomerSearch')"  @select="selectCustomerDialog"  ></CustomerSearchDialog>
  <!-- 納入先 -->
  <DeliverySearchDialog    v-if="showDialog.DeliverySearchDelivery"    :officeCode="this.officeCode" :hCode="sihRecord.HCODE" :customerCode="sihRecord.CUSTOMER_CODE" @close="closeDialog('DeliverySearchDelivery')"  @select="selectDeliveryDialog"  ></DeliverySearchDialog>
  <!-- 倉庫 -->
  <WarehouseSearchDialog   v-if="showDialog.WarehouseSearchDelivery"   :officeCode="this.officeOtherCode" :hCode="sihRecord.HCODE"                                    @close="closeDialog('WarehouseSearchDelivery')" @select="selectDeliveryDialog" ></WarehouseSearchDialog>

  <!-- 仕入先 -->
  <SupplierSearchDialog    v-if="showDialog.SupplierSearch"    :officeCode="this.officeOtherCode" :hCode="sihRecord.HCODE"                                            @close="closeDialog('SupplierSearch')"  @select="selectSupplierDialog"  ></SupplierSearchDialog>
  <!-- 倉庫 -->
  <WarehouseSearchDialog   v-if="showDialog.WarehouseSearch"   :officeCode="this.officeOtherCode" :hCode="sihRecord.HCODE"                                            @close="closeDialog('WarehouseSearch')" @select="selectWarehouseDialog" ></WarehouseSearchDialog>
  <!-- 運転手 -->
  <DriverSearchDialog      v-if="showDialog.DriverSearch"      :officeCode="this.officeCode" :officeOtherCode="this.officeOtherCode" :hCode="sihRecord.HCODE"         @close="closeDialog('DriverSearch')"    @select="selectDriverDialog"    ></DriverSearchDialog>

  <!-- 商品 -->
  <ItemSearchDialog        v-if="showDialog.ItemSearch"        :searchHcode="sihRecord.HCODE" :searchCustomerCode="sihRecord.CUSTOMER_CODE" :searchDeliveryCode="sihRecord.DELIVERY_CODE" :searchSupplierCode="sihRecord.SUPPLIER_CODE" @close="closeDialog('ItemSearch')"      @select="selectItemDialog"      ></ItemSearchDialog>

  <!-- 営業所 -->
  <OfficeSearchDialog      v-if="showDialog.OfficeSearch"                                                                                                             @close="closeDialog('OfficeSearch')"    @select="selectOfficeDialog"    ></OfficeSearchDialog>

  <!-- 複写 -->
  <InputShippingDialog     v-if="showDialog.InputShippingCp" @close="closeDialog('InputShippingCp')" @complete="copyDetail"  :mode="'copy'"  :hCode="sihRecord.HCODE" :baseSihId="sihRecord.SIH_ID" ></InputShippingDialog>

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
        mstUsers: [],
        mstCustomers: [],
        mstDeliveries:[],
        mstSuppliers: [],
        mstWarehouses: [],
        mstDrivers:[],

        mstHCodesD:[],
        mstPlaces:[],
        mstRemarks:[],
        mstItems:[],
        mstOffices:[],

        // 営業所コード
        officeCode:"",
        // 相手営業所コード
        officeOtherCode:"",

        // ヘッダーとボディデータ
        sihRecord: {
          'STATUS': 0
        },
        sidRecords: [],

        //一時保存値
        orgOfficeOtherCode:"",
        orgCustomerCode:"",
        orgDeliveryCode:"",
        orgSuppliersCode:"",
        orgWarehousesCode:"",
        orgDriversCode:"",

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
        this.isNew            = response.data.isNew;
        this.sihRecord        = response.data.sihRecord;
        this.sidRecords       = response.data.sidRecords;
        this.officeCode       = response.data.officeCode;
      })

      //画面名称の設定
      document.title="出荷指示: " + this.sihRecord.ORDER_NO;

      //初期得意先の設定
      this.orgOfficeOtherCode = this.sihRecord.OFFICE_OTHER_CODE;
      this.orgCustomerCode = this.sihRecord.CUSTOMER_CODE;
      this.orgDeliveryCode = this.sihRecord.DELIVERY_CODE;
      this.orgSuppliersCode = this.sihRecord.SUPPLIER_CODE;
      this.orgWarehousesCode = this.sihRecord.WAREHOUSE_CODE;
      this.orgDriversCode = this.sihRecord.DRIVER_CODE;

      // 相手営業所がない場合は、自営業所を格納する。
      if (this.sihRecord.OFFICE_OTHER_CODE == null) { 
        this.officeOtherCode = this.officeCode;
        this.orgOfficeOtherCode = "";
      }

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
        this.mstUsers = data.users;
        this.mstCustomers = data.customers;
        this.mstDeliveries = data.deliveries;
        this.mstSuppliers = data.suppliers;
        this.mstWarehouses = data.warehouses;
        this.mstDrivers = data.drivers;
        this.mstHCodesD = data.hcodesD;
        this.mstPlaces = data.places;
        this.mstRemarks = data.remarks;
        this.mstOffices = data.offices;
      });

      this.officeOtherC2N();
      this.officeOtherBlur();
      this.deliveryC2N();
      this.deliveryBlur();
      this.supplierC2N();
      this.supplierBlur();

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
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords,
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("保存しました。" + "\r\n" + "受注No：" + orderNo);
          this.init(sihId, orderNo, "", "", "", "");
        });
      }
    },

    // 入力確定
    conf: async function() {
      if (confirm("入力確定をします。よろしいですか？")) {
        await axios.post("/api/shipping/conf", {
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("確定しました。" + "\r\n" + "受注No：" + orderNo);
          // this.init(sihId, orderNo, "", "", "", "");
          router.push("/?isBack=true");
        });
      }
    },

    // 出荷完了
    comp: async function() {
      if (confirm("出荷完了をします。よろしいですか？")) {
        await axios.post("/api/shipping/comp", {
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords
        }).then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          alert("完了しました。" + "\r\n" + "受注No：" + orderNo);
          // this.init(sihId, orderNo, "", "", "", "");
          router.push("/?isBack=true");
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
          router.push("/?isBack=true");
        });
      }
    },

    // 指示書入力
    instructionPrint: async function(){
      await axios.post("/api/shipping/conf", {
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords
        })
        .then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          window.open("/shipping/instructionPrint/" + sihId);
          // this.init(sihId, orderNo, "", "", "", "");
          router.push("/?isBack=true");
      });
    },

    // 伝票印刷
    slipPrint: async function(){
      await axios.post("/api/shipping/conf", {
          'isNew'     : this.isNew,
          'sihRecord' : this.sihRecord,
          'sidRecords': this.sidRecords
        })
        .then(response => {
          var sihId = response.data.SIH_ID;
          var orderNo = response.data.ORDER_NO;
          window.open("/shipping/slipPrint/" + sihId);
          // this.init(sihId, orderNo, "", "", "", "");
          router.push("/?isBack=true");
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
    // Code2Name
    //-------------------------------------------------------------------------

    // 相手営業所
    officeOtherC2N: function (){
      var that = this;
      var targetOffices = this.mstOffices.filter(function(row){ 
        return row.CODE==that.sihRecord.OFFICE_OTHER_CODE?true:false;
      });
      if (targetOffices.length > 0){
        // 営業所コードを格納(仕入先/倉庫/運転手で使用する。)
        this.officeOtherCode = targetOffices[0].CODE;
        this.sihRecord.OFFICE_OTHER_NAME = targetOffices[0].NAME;
      } else {
        // デフォルト(自分自身)に戻す。
        this.officeOtherCode = this.officeCode;
        this.sihRecord.OFFICE_OTHER_NAME = "";
      }
    },

    // 得意先
    customerC2N: function (){
      var that = this;
      var targetCustomers = this.mstCustomers.filter(function(row){ return row.CODE==that.sihRecord.CUSTOMER_CODE?true:false; });
      if (targetCustomers.length > 0){
        this.sihRecord.CUSTOMER_NAME = targetCustomers[0].NAME;
      } else {
        this.sihRecord.CUSTOMER_NAME = "";
      }
    },

    // 納入先
    deliveryC2N: function (){
      //this.sihRecord.DELIVERY_CODE !=null ?this.sihRecord.DELIVERY_CODE.replace( /[^0-9]/g ,"" ):"";

      var that = this;
      var targetDeliveries = null;

      // 取区が通常の場合
      if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4){
        targetDeliveries = this.mstDeliveries.filter(function(row){ return row.CODE==that.sihRecord.DELIVERY_CODE?true:false; });
      }

      // 取区が仕入・融通の場合
      if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4){
        targetDeliveries = this.mstWarehouses.filter(function(row){ return row.CODE==that.sihRecord.DELIVERY_CODE?true:false; });
      }

      if (targetDeliveries != null && targetDeliveries.length > 0){
        this.sihRecord.DELIVERY_NAME = targetDeliveries[0].NAME;
      } else {
        this.sihRecord.DELIVERY_NAME = "";
      }

    },

    // 仕入先
    supplierC2N: function (){
      var that = this;
      var targetSuppliers = this.mstSuppliers.filter(function(row){ 
        return row.CODE==that.sihRecord.SUPPLIER_CODE?true:false; 
      });
      if (targetSuppliers.length > 0){
        this.sihRecord.SUPPLIER_NAME = targetSuppliers[0].NAME;
      } else {
        this.sihRecord.SUPPLIER_NAME = "";
      }
    },

    // 倉庫
    warehouseC2N: function (){
      var that = this;
      var targetWarehouses = this.mstWarehouses.filter(function(row){ 
        return row.CODE==that.sihRecord.WAREHOUSE_CODE?true:false; 
      });
      if (targetWarehouses.length > 0){
        this.sihRecord.WAREHOUSE_NAME = targetWarehouses[0].NAME;
      } else {
        this.sihRecord.WAREHOUSE_NAME = "";
      }
    },

    // 運転手
    driverC2N: function (){
      var that = this;
      var targetDrivers = this.mstDrivers.filter(function(row){ 
        return ((row.COMPANY_CODE==that.officeCode&&row.CODE==that.sihRecord.DRIVER_CODE)?true:false); 
        });
      if (targetDrivers.length > 0){
        this.sihRecord.DRIVER_NAME = targetDrivers[0].NAME;
        this.sihRecord.TRUCKER_CODE = targetDrivers[0].TRUCKER_CODE;
        this.sihRecord.TRUCKER_NAME = targetDrivers[0].TRUCKER_NAME;
      } else {
        this.sihRecord.DRIVER_NAME = "";
        this.sihRecord.TRUCKER_CODE = "";
        this.sihRecord.TRUCKER_NAME = "";
      }
    },

    //-------------------------------------------------------------------------
    // 商品の表示反映
    //-------------------------------------------------------------------------
    itemUpdate: function (index){
      for (var count = 0 ; count < this.sidRecords.length ; count++){
        if (index != undefined){
          if (index != count){ continue; }
        }
        if (this.sidRecords[count]["items_rel"] != null){
          this.sidRecords[count].ITEM_NAME    = this.sidRecords[count]["items_rel"].NAME;
          if (index != undefined){
            this.sidRecords[count].QTY_PER_CTN  = this.sidRecords[count]["items_rel"].QTY_PER_CTN;
          }
          if (this.sihRecord.LOADING_RATE == "1"){
            this.sidRecords[count].QTY_CTN2     = this.sidRecords[count]["items_rel"].RATE1;
          } else if (this.sihRecord.LOADING_RATE == "2"){
            this.sidRecords[count].QTY_CTN2     = this.sidRecords[count]["items_rel"].RATE2;
          } else if (this.sihRecord.LOADING_RATE == "3"){
            this.sidRecords[count].QTY_CTN2     = this.sidRecords[count]["items_rel"].RATE3;
          }
        } else {
          this.sidRecords[count].ITEM_NAME    = null;
          this.sidRecords[count].QTY_PER_CTN  = null;
          this.sidRecords[count].QTY_CTN2     = null;
        }
      }
    },

    //-------------------------------------------------------------------------
    // フォーカス外れ時イベント(4桁チェックなど)
    //-------------------------------------------------------------------------

    // 相手営業所(フォーカス外れ時イベント)
    officeOtherBlur: function(){
      if (this.sihRecord.OFFICE_OTHER_CODE == null){ 
        // デフォルト(自分自身)に戻す。
        this.officeOtherCode = this.officeCode;
        return;
      }
      
      // 元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if (this.orgOfficeOtherCode != null) {
        if (this.sihRecord.OFFICE_OTHER_CODE != this.orgOfficeOtherCode) {
          // 仕入先/倉庫/運転手をクリアする。
          this.sihRecord.SUPPLIER_CODE = "";
          this.sihRecord.SUPPLIER_NAME = "";
          this.sihRecord.WAREHOUSE_CODE = "";
          this.sihRecord.WAREHOUSE_NAME = "";
          this.sihRecord.DRIVER_CODE = "";
          this.sihRecord.DRIVER_NAME = "";
          this.sihRecord.TRUCKER_CODE = "";
          this.sihRecord.TRUCKER_NAME = "";

          //元値を新しい値に変更する
          this.orgOfficeOtherCode=this.sihRecord.OFFICE_OTHER_CODE;

          // 存在確認
          var that = this;
          var targetOffices = this.mstOffices.filter(function(row){ 
            return row.CODE==that.sihRecord.OFFICE_OTHER_CODE?true:false;
          });
          if (targetOffices.length == 0){
            alert("営業所コードが登録されていません。");
            officesOtherCode.focus();
            return;
          }
        }
      }

      //元値を新しい値に変更する
      this.orgOfficeOtherCode=this.sihRecord.OFFICE_OTHER_CODE;

      this.officeOtherC2N();
    },

    // 得意先(フォーカス外れ時イベント)
    customerBlur: function(){
      if (this.sihRecord.CUSTOMER_CODE == null){ return; }

      //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if(this.orgCustomerCode != null){

        // 桁数を揃える
        if (1 <= this.sihRecord.CUSTOMER_CODE.length && this.sihRecord.CUSTOMER_CODE.length <= 4){
          this.sihRecord.CUSTOMER_CODE = this.officeCode + this.sihRecord.CUSTOMER_CODE.padStart(4, '0');
        }

        // 変更されているか確認
        if(this.sihRecord.CUSTOMER_CODE  != this.orgCustomerCode){
          this.sihRecord.DELIVERY_CODE="";
          this.sihRecord.DELIVERY_NAME="";
          
          for (var count = 0 ; count < this.sidRecords.length ; count++){
            this.sidRecords[count].HCODE         = null;
            this.sidRecords[count].ITEM_CODE     = null;
            this.sidRecords[count].ITEM_NAME     = null;
            this.sidRecords[count].QTY_PER_CTN   = null;
            this.sidRecords[count].QTY_CTN       = null;
            this.sidRecords[count].QTY           = null;
            this.sidRecords[count].QTY_CTN2      = null;
            this.sidRecords[count].QTY2          = null;
            // 20220720_hash-shi_明細クリア_str------------
            // this.sidRecords[count].LOADING_PLACE = null;
            this.sidRecords[count].LOADING_PLACE_CODE = null;
            this.sidRecords[count].LOADING_PLACE_NAME = null;
            // 20220720_hash-shi_明細クリア_end------------
            this.sidRecords[count].REMARK1       = null;
            this.sidRecords[count].REMARK2       = null;
          }
          // 20220720_hash-shi_明細クリア_str------------
          this.sihRecord.CONTINUED_SHEET         = null
          this.sihRecord.CURRENT_SHEET           = null
          this.sihRecord.ALL_SHEET               = null
          this.sihRecord.INVOICE_NOTE            = null
          this.sihRecord.DELIVERY_NOTE           = null
          this.sihRecord.TAG_NOTE                = null
          // 20220720_hash-shi_明細クリア_end------------

          // 元値を新しい値に変更する
          this.orgCustomerCode=this.sihRecord.CUSTOMER_CODE;

          // 得意先コードに含まれているかをチェックする。
          // あんまりチェックする意義が無いが一応追加する。
          var that = this;
          var targetCustomers = this.mstCustomers.filter(function(row){ return row.CODE==that.sihRecord.CUSTOMER_CODE?true:false; });
          if (targetCustomers.length == 0){
            alert("得意先コードが登録されていません。");
            customerCode.focus();
            return;
          }
        }
      }

      // 元値を新しい値に変更する
      this.orgCustomerCode=this.sihRecord.CUSTOMER_CODE;

      this.customerC2N();
    },

    // 納入先(フォーカス外れ時イベント)
    deliveryBlur: function(){
      if (this.sihRecord.DELIVERY_CODE == null){ return; }
      // 20220706_hash-shi_納入先変更で明細クリア_str------------
      // 元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if (this.orgDeliveryCode != null) {

        // 桁揃え
        if (1 <= this.sihRecord.DELIVERY_CODE.length && this.sihRecord.DELIVERY_CODE.length <= 4){
          this.sihRecord.DELIVERY_CODE = this.officeCode + this.sihRecord.DELIVERY_CODE.padStart(4, '0');
        }

        if (this.sihRecord.DELIVERY_CODE != this.orgDeliveryCode) {
          for (var count = 0 ; count < this.sidRecords.length ; count++){
            this.sidRecords[count].HCODE         = null;
            this.sidRecords[count].ITEM_CODE     = null;
            this.sidRecords[count].ITEM_NAME     = null;
            this.sidRecords[count].QTY_PER_CTN   = null;
            this.sidRecords[count].QTY_CTN       = null;
            this.sidRecords[count].QTY           = null;
            this.sidRecords[count].QTY_CTN2      = null;
            this.sidRecords[count].QTY2          = null;
            // 20220720_hash-shi_明細クリア_str------------
            // this.sidRecords[count].LOADING_PLACE = null;
            this.sidRecords[count].LOADING_PLACE_CODE = null;
            this.sidRecords[count].LOADING_PLACE_NAME = null;
            // 20220720_hash-shi_明細クリア_end------------
            this.sidRecords[count].REMARK1       = null;
            this.sidRecords[count].REMARK2       = null;
          }
          // 20220720_hash-shi_明細クリア_str------------
          this.sihRecord.CONTINUED_SHEET         = null
          this.sihRecord.CURRENT_SHEET           = null
          this.sihRecord.ALL_SHEET               = null
          this.sihRecord.INVOICE_NOTE            = null
          this.sihRecord.DELIVERY_NOTE           = null
          this.sihRecord.TAG_NOTE                = null
          // 20220720_hash-shi_明細クリア_end------------

          //元値を新しい値に変更する
          this.orgDeliveryCode=this.sihRecord.DELIVERY_CODE;

          // コードの存在確認
          var that = this;
          var targetDeliveries = null;
          // 取区が通常の場合
          if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4){
            targetDeliveries = this.mstDeliveries.filter(function(row){ return row.CODE==that.sihRecord.DELIVERY_CODE?true:false; });
          }
          // 取区が仕入・融通の場合
          if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4){
            targetDeliveries = this.mstWarehouses.filter(function(row){ return row.CODE==that.sihRecord.DELIVERY_CODE?true:false; });
          }
          if (targetDeliveries.length == 0){
            alert("納入先コードが登録されていません。");
            deliveryCode.focus();
            return;
          }
        }
      }

      //元値を新しい値に変更する
      this.orgDeliveryCode=this.sihRecord.DELIVERY_CODE;

      this.deliveryC2N();
      // 20220706_hash-shi_納入先変更で明細クリア_end------------
    },

    // 仕入先(フォーカス外れ時イベント)
    supplierBlur: function(){
      if (this.sihRecord.SUPPLIER_CODE == null){ return; }

      //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if(this.orgSuppliersCode != null){
        // 桁数を揃える
        if (1 <= this.sihRecord.SUPPLIER_CODE.length && this.sihRecord.SUPPLIER_CODE.length <= 4){
          this.sihRecord.SUPPLIER_CODE = this.officeOtherCode + this.sihRecord.SUPPLIER_CODE.padStart(4, '0');
        }
        // 変更されているか確認
        if(this.sihRecord.SUPPLIER_CODE  != this.orgSuppliersCode){
          // 元値を新しい値に変更する
          this.orgSuppliersCode=this.sihRecord.SUPPLIER_CODE;
          // 存在確認
          var that = this;
          var targetSuppliers = this.mstSuppliers.filter(function(row){ 
            return row.CODE==that.sihRecord.SUPPLIER_CODE?true:false; 
          });
          if (targetSuppliers.length == 0){
            alert("仕入先コードが登録されていません。");
            suppliersCode.focus();
            return;
          }
        }
      }

      // 元値を新しい値に変更する
      this.orgSuppliersCode=this.sihRecord.SUPPLIER_CODE;
      this.supplierC2N();
    },

    // 倉庫(フォーカス外れ時イベント)
    warehouseBlur: function(){
      if (this.sihRecord.WAREHOUSE_CODE == null){ return; }

      //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if(this.orgWarehousesCode != null){
        // 桁数を揃える
        if (1 <= this.sihRecord.WAREHOUSE_CODE.length && this.sihRecord.WAREHOUSE_CODE.length <= 4){
          this.sihRecord.WAREHOUSE_CODE = this.officeOtherCode + this.sihRecord.WAREHOUSE_CODE.padStart(4, '0');
        }
        // 変更されているか確認
        if(this.sihRecord.WAREHOUSE_CODE  != this.orgWarehousesCode){
          // 元値を新しい値に変更する
          this.orgWarehousesCode=this.sihRecord.WAREHOUSE_CODE;
          // 存在確認
          var that = this;
          var targetWarehouses = this.mstWarehouses.filter(function(row){ 
            return row.CODE==that.sihRecord.WAREHOUSE_CODE?true:false; 
          });
          if (targetWarehouses.length == 0){
            alert("倉庫コードが登録されていません。");
            suppliersCode.focus();
            return;
          }
        }
      }

      // 元値を新しい値に変更する
      this.orgWarehousesCode=this.sihRecord.WAREHOUSE_CODE;
      this.warehouseC2N();
    },

    // 運転手(フォーカス外れ時イベント)
    driverBlur: function(){
      if (this.sihRecord.DRIVER_CODE == null){ return; }

      //元値がnullでないもので且つ、元値と入力値が異なっていた場合のみ値の削除を行う。
      if(this.orgDriversCode != null){
        // 桁数を揃える
        if (this.sihRecord.DRIVER_CODE.length <= 6){
          this.sihRecord.DRIVER_CODE = this.sihRecord.DRIVER_CODE.padStart(6, '0');
        }
        // 変更されているか確認
        if(this.sihRecord.DRIVER_CODE  != this.orgDriversCode){
          // 元値を新しい値に変更する
          this.orgDriversCode=this.sihRecord.DRIVER_CODE;
          // 存在確認
          var that = this;
          var targetDrivers = this.mstDrivers.filter(function(row){ 
            return ((row.COMPANY_CODE==that.officeCode&&row.CODE==that.sihRecord.DRIVER_CODE)?true:false); 
          });
          if (targetDrivers.length == 0){
            alert("運転手コードが登録されていません。");
            driversCode.focus();
            return;
          }
        }
      }

      // 元値を新しい値に変更する
      this.orgDriversCode=this.sihRecord.DRIVER_CODE;
      this.driverC2N();
    },

    // 商品(フォーカス外れ時イベント)
    itemBlur: async function(index){
      if (this.sidRecords[index].ITEM_CODE == null || this.sidRecords[index].ITEM_CODE == ""){
        this.sidRecords[index]["items_rel"] = null;
        this.itemUpdate(index);
        return;
      }
      await axios.post("/api/master/items", {
        'searchItemCode'        : this.sidRecords[index].ITEM_CODE,
        'searchItemName'        : null,
        'searchType'            : 1,
      })
      .then(response => {
        if (response.data.length > 0){
          this.sidRecords[index]["items_rel"] = response.data[0];
        } else {
          this.sidRecords[index]["items_rel"] = null;
        }
        this.itemUpdate(index);
      });
    },
    // 20220720_hash-shi_積込場所名_str------------
    loadingPlacBlur: async function(index) {

      // 選択したコードの積込場所名を表示する。
      for (var count = 0; count < this.mstPlaces.length; count++) {
        var places = this.mstPlaces[count];
        if (places["CODE"] === this.sidRecords[index].LOADING_PLACE_CODE) {
          this.sidRecords[index].LOADING_PLACE_NAME = places["NAME"];
        }
      }
    },
    // 20220720_hash-shi_積込場所名_end------------

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
    // 仕入先ダイアログで選択した得意先を格納してダイアログを閉じる
    selectSupplierDialog: function(supplierCode){
      this.sihRecord.SUPPLIER_CODE = supplierCode;
      this.closeDialog('SupplierSearch');
      this.supplierC2N();
      this.$nextTick(() => this.moveToNextField('suppliersCode'));
    },
    // 倉庫ダイアログで選択した得意先を格納してダイアログを閉じる
    selectWarehouseDialog: function(warehouseCode){
      this.sihRecord.WAREHOUSE_CODE = warehouseCode;
      this.closeDialog('WarehouseSearch');
      this.warehouseC2N();
      this.$nextTick(() => this.moveToNextField('warehousesCode'));
    },
    // 運転手ダイアログで選択した得意先を格納してダイアログを閉じる
    selectDriverDialog: function(companyCode, driverCode){
      this.sihRecord.DRIVER_CODE = driverCode;
      this.closeDialog('DriverSearch');
      this.driverC2N();
      this.$nextTick(() => this.moveToNextField('driversCode'));
    },
    // 商品ダイアログで選択した得意先を格納してダイアログを閉じる
    selectItemDialog: function(item){
      var index = this.showDialog.ItemSearchIndex;
      this.sidRecords[index].ITEM_CODE = item.CODE;
      this.sidRecords[index]["items_rel"] = item;
      this.closeDialog('ItemSearch');
      this.itemUpdate(index);
      this.$nextTick(() => this.moveToNextField('itemCode_' + index));
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
        this.sidRecords.splice(index,1,targetRow);
        this.sidRecords.splice(index + 1,1,baseRow);
      }
      if (mode == "up"){
        var baseRow = JSON.parse(JSON.stringify(this.sidRecords[index]));
        var targetRow = JSON.parse(JSON.stringify(this.sidRecords[index - 1]));
        this.sidRecords.splice(index,1,targetRow);
        this.sidRecords.splice(index - 1,1,baseRow);
      }
    },
    // 行の内容を削除
    sidRowDel: function(index){
      for (let key in this.sidRecords[index]) {
        if (key != 'ORDER_NO' && key != 'RNO') {
          this.sidRecords[index][key] = null;
        }
      }
    },

    getItems: async function(){
      // 取区によって商品候補一覧の取得元が異なる為、判定
      if (this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4){
        // 「通常」の場合
        if (this.sihRecord.CUSTOMER_CODE == null || this.sihRecord.CUSTOMER_CODE == "") { this.mstItems = []; return; }
        
        await axios.post('/api/master/items', {
          'searchHcode'        : this.sihRecord.HCODE,
          'searchCustomerCode' : this.sihRecord.CUSTOMER_CODE,
          'searchDeliveryCode' : this.sihRecord.DELIVERY_CODE,
        })
        .then(response => {
          this.mstItems = response.data;
        });

      } else if (this.sihRecord.HCODE != 1 && this.sihRecord.HCODE != 4){
        // 「仕入」の場合
        if (this.sihRecord.SUPPLIER_CODE == null || this.sihRecord.SUPPLIER_CODE == "") { this.mstItems = []; return; }

        await axios.post('/api/master/items', {
          'searchHcode'        : this.sihRecord.HCODE,
          'searchSupplierCode' : this.sihRecord.SUPPLIER_CODE,
        })
        .then(response => {
          this.mstItems = response.data;
        });


      } else {
        // それ意外はありえないが変な値が入ってもいやなので、空に初期化する
        this.mstItems = [];
      }
    },

    //-------------------------------------------------------------------------
    // 明細行の警告
    //-------------------------------------------------------------------------
    // 商品コードがデータリストに無い場合の警告
    itemWarning: function(index){
      var itemCode = this.sidRecords[index].ITEM_CODE;
      if (itemCode == null){ return false; }
      if (itemCode == "")  { return false; }
      if (this.mstItems.filter(function(row){ return (row.CODE==itemCode); }).length > 0){
        return false;
      }
      return true;
    },

    // 商品コードがデータリストに無い場合の警告
    qtyPerCtnWarning: function(index){
      var qtyPerCtn = this.sidRecords[index].QTY_PER_CTN;
      if (qtyPerCtn == null){ return false; }
      if (qtyPerCtn == "")  { return false; }
      if (this.sidRecords[index]["items_rel"]==null){ return false; }
      if (this.sidRecords[index]["items_rel"].QTY_PER_CTN == qtyPerCtn){ return false; }
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

      this.nextFields.push({ 'id':'back',             'disabled': false, });
      this.nextFields.push({ 'id':'copy',             'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==2)), });
      this.nextFields.push({ 'id':'susp',             'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==0||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'conf',             'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==1||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'comp',             'disabled': !(this.sihRecord.STATUS==0||this.sihRecord.STATUS==1||this.sihRecord.STATUS==3||this.sihRecord.STATUS==99), });
      this.nextFields.push({ 'id':'del',              'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });
      this.nextFields.push({ 'id':'instructionPrint', 'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });
      this.nextFields.push({ 'id':'slipPrint',        'disabled': (this.isNew&&!(this.sihRecord.STATUS==1||this.sihRecord.STATUS==3)), });

      this.nextFields.push({ 'id':'orderDate',         'disabled': false, });
      this.nextFields.push({ 'id':'orderTime',         'disabled': false, });
      this.nextFields.push({ 'id':'orderUser',         'disabled': false, });
      this.nextFields.push({ 'id':'kari',              'disabled': false, });
      this.nextFields.push({ 'id':'orderUser2',        'disabled': false, });
      this.nextFields.push({ 'id':'shipDate',          'disabled': false, });
      this.nextFields.push({ 'id':'deliveryDate',      'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn0',     'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn1',     'disabled': false, });
      this.nextFields.push({ 'id':'deliveryAmpn2',     'disabled': false, });
      this.nextFields.push({ 'id':'deliveryTime',      'disabled': !(this.sihRecord.DELIVERY_AMPM==1||this.sihRecord.DELIVERY_AMPM==2), });

      this.nextFields.push({ 'id':'officesOtherCode',     'disabled': !(this.sihRecord.HCODE==4||this.sihRecord.HCODE==5||this.sihRecord.HCODE==6), });
      this.nextFields.push({ 'id':'customerCode',         'disabled': !(this.sihRecord.HCODE==1||this.sihRecord.HCODE==4), });
      this.nextFields.push({ 'id':'deliveryCodeDelivery', 'disabled': !(this.sihRecord.HCODE==1||this.sihRecord.HCODE==4), });
      this.nextFields.push({ 'id':'deliveryCodeWarehouse','disabled': !(this.sihRecord.HCODE!=1 && this.sihRecord.HCODE!=4), });
      this.nextFields.push({ 'id':'suppliersCode',        'disabled': false, });
      this.nextFields.push({ 'id':'warehousesCode',       'disabled': false, });
      this.nextFields.push({ 'id':'driversCode',          'disabled': false, });
      this.nextFields.push({ 'id':'flights',              'disabled': false, });
      this.nextFields.push({ 'id':'fee',                  'disabled': false, });
      this.nextFields.push({ 'id':'addFee',               'disabled': false, });
      this.nextFields.push({ 'id':'highwayFee',           'disabled': false, });
      this.nextFields.push({ 'id':'feeClass0',            'disabled': false, });
      this.nextFields.push({ 'id':'feeClass1',            'disabled': false, });

      for (var i = 0; i < this.sidRecords.length; i++) {
        this.nextFields.push({ 'id':'hcode_' + i,             'disabled': false, });
        this.nextFields.push({ 'id':'itemCode_' + i,          'disabled': false, });
        this.nextFields.push({ 'id':'qtyPerCtn_' + i,         'disabled': false, });
        this.nextFields.push({ 'id':'qtyCtn_' + i,            'disabled': false, });
        this.nextFields.push({ 'id':'loadingPlaceCode_' + i,  'disabled': false, });
        this.nextFields.push({ 'id':'loadingPlaceName_' + i,  'disabled': false, });
        this.nextFields.push({ 'id':'ramark1_' + i,           'disabled': false, });
        this.nextFields.push({ 'id':'ramark2_' + i,           'disabled': false, });
      }

      this.nextFields.push({ 'id':'continuedSheet0',    'disabled': false, });
      this.nextFields.push({ 'id':'continuedSheet1',    'disabled': false, });
      this.nextFields.push({ 'id':'currentSheet',       'disabled': false, });
      this.nextFields.push({ 'id':'allSheet',           'disabled': false, });
      this.nextFields.push({ 'id':'invoiceNote',        'disabled': false, });
      this.nextFields.push({ 'id':'deliveryNote',       'disabled': false, });
      this.nextFields.push({ 'id':'tagNote',            'disabled': false, });

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

    // //得意先の絞込
    // if(this.sihRecord.HCODE == 1){
    //   this.mstCustomers=this.mstCustomers.filter(function(row){ return (row.CODE>1480000)});
    //   this.mstCustomers=this.mstCustomers.filter(function(row){ return (row.CODE<1489999)});
    // }

    // //仕入先の絞込
    // if(this.sihRecord.HCODE != 4){
    //   this.mstSuppliers=this.mstSuppliers.filter(function(row){ return (row.CODE>1480000)});
    //   this.mstSuppliers=this.mstSuppliers.filter(function(row){ return (row.CODE<1489999)});
    // }
    
    // //取区によるリストの絞込
    // if(this.sihRecord.HCODE == 1 || this.sihRecord.HCODE == 4) {
    //   // 通常売上
    //   var codes = ["11","12","15","16","35","38","45"];
    //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
    // } else if(this.sihRecord.HCODE == 2 || this.sihRecord.HCODE == 5) {
    //   // 通常仕入
    //   var codes = ["10","13","14","31","34","36","37","41","44"];
    //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
    // } else if(this.sihRecord.HCODE == 3 || this.sihRecord.HCODE == 6) {
    //   // 通常移動
    //   var codes = ["51"];
    //   this.mstHCodesD=this.mstHCodesD.filter(function(row){ return (codes.includes(row.CODE))});
    // }
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
            sihId       = targetSplit[0];
          } else if (targetSplit.length == 5) {
            // 新規
            sihId       = targetSplit[0];
            orderNo     = targetSplit[1];
            hCode       = targetSplit[2];
            shipDate    = targetSplit[3];
            userCode    = targetSplit[4];
          } else if (targetSplit.length == 6) {
            // 複写
            sihId       = targetSplit[0];
            orderNo     = targetSplit[1];
            hCode       = targetSplit[2];
            shipDate    = targetSplit[3];
            userCode    = targetSplit[4];
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

    'sihRecord.CUSTOMER_CODE': async function(code){
      // 得意先変更で納入先変更
      await axios.post('/api/master/deliveries', { 'searchCustomerCode' : code })
      .then(response => {
        this.mstDeliveries = response.data;
      });
      await this.getItems();
    },
    'sihRecord.DELIVERY_CODE': async function(code){
      await this.getItems();
    },
    'sihRecord.SUPPLIER_CODE': async function(code){
      await this.getItems();
    },
    'sihRecord.LOADING_RATE': async function(){
      this.itemUpdate();
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