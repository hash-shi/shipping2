<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\DBUtility;
use App\Libs\Masters;
use App\Libs\ProjectCommon;
use App\Models\calendar;
use App\Models\configures;
use App\Models\items;
use App\Models\phResult;
use App\Models\pdResult;
use App\Models\qrResult;
use App\Http\Controllers\api\MasterController;

use milon\barcode;
use mikehaertl\wkhtmlto\Pdf;
use DB;

session_start();//セッションスタート

class QrprintController extends Controller
{
    // private $method_action_key = 'method_action_key';
    
    //---------------------------------------------------------------------
    // 画面初期表示
    //---------------------------------------------------------------------
    public function qrPrintInit(Request $request){

        //本日日付の取得
        $printDate = date("Y-m-d");

        //印刷枚数の取得
        // $query = configures::query();
        // $query->where('ID', 'QR_NUMBER');
        // $numSheet = $query->value('VALUE');
        $numSheet = "";

        //営業所コード定数の取得
        $query = configures::query();
        $query->where('ID', 'OFFICE_CODE');
        $officeCode = $query->value('VALUE');

        //画面更新間隔の取得
        $query = configures::query();
        $query->where('ID', 'SCREEN_REDRAW_INTERVAL');
        $screenRedrawInterval = $query->value('VALUE');

        //連番の取得
        $lotSeq="";
        $lotSeq = $this->getserialNumber($printDate);

        return array(
            "printDate"             => $printDate,
            "numSheet"              => $numSheet,
            "lotSeq"                => $lotSeq,
            "officeCode"            => $officeCode,
            "screenRedrawInterval"  => $screenRedrawInterval,
            "pattern"               => "A",
        );
    }

    //---------------------------------------------------------------------
    // 年月日変更、最新連番取得
    //---------------------------------------------------------------------
    public function serialNumberChange(Request $request){
        $printDate  = $request->input("printDate");
        $lotSeq     = $this->getserialNumber($printDate);
        return array(
            "lotSeq" =>  $lotSeq,
        );
    }

    //---------------------------------------------------------------------
    // 当日の連番取得
    //---------------------------------------------------------------------
    public function getserialNumber($printDate){

        $lotSeq = 1;

        $query = calendar::query();
        $query->where('CDATE', $printDate);
        $record = $query->first();
        if ($record != null) {
            if ($record["LOTSEQ"] != null && $record["LOTSEQ"] != "") {
                $lotSeq = $record["LOTSEQ"];
            }
        }
        
        return $lotSeq;
    }

    //---------------------------------------------------------------------
    // 発行履歴の検索・取得
    //---------------------------------------------------------------------
    public function search(Request $request){

        //---------------------------------------------------------------------
        // リクエスト取得
        //---------------------------------------------------------------------
        $printDate      = $request->input("printDate");
        $supplierCode   = $request->input("supplierCode");
        $warehouseCode  = $request->input("warehouseCode");
        $itemCode       = $request->input("itemCode");

        $query = qrResult::query();

        // 年月日
        if ($printDate != null && $printDate != "") {
            $query->where('PRINT_DATE', $printDate);
        }

        // 仕入先コード
        if ($supplierCode != null && $supplierCode != "") {
            $query->where('SUPPLIER_CODE', $supplierCode);
        }

        // 倉庫コード
        if ($warehouseCode != null && $warehouseCode != "") {
            $query->where('WAREHOUSE_CODE', $warehouseCode);
        }

        // 商品コード
        if ($itemCode != null && $itemCode != "") {
            $query->where('ITEM_CODE', $itemCode);
        }

        // 並び順
        $query->orderBy('PRINT_DATE', 'desc');
        $query->orderBy('LOTSEQ', 'desc');

        // 
        $query->select(DB::raw('\'false\' as PRINT_FLG'), 'ID', 'PRINT_DATE', 'LOTSEQ', 'SUPPLIER_CODE', 'WAREHOUSE_CODE', 'ITEM_CODE', 'QTY_PER', 'PATTERN', 'INS_DATE', DB::raw('\'\' as SW_CODE, \'\' as SW_NAME'));

        $result = ProjectCommon::syncRelation('\App\Models\qrResult', ProjectCommon::getRelation('App\Models\qrResult', $query)->get());

        foreach($result as $re) {
            $re['PRINT_FLG'] = false;

            if ($re['SUPPLIER_CODE'] != null) {
                $re['SW_CODE'] = $re['SUPPLIER_CODE'];
                $re['SW_NAME'] = $re['SUPPLIER_NAME'];
            } else {
                $re['SW_CODE'] = $re['WAREHOUSE_CODE'];
                $re['SW_NAME'] = $re['WAREHOUSE_NAME'];
            }
        }

        if (count($result) == 0) {
            $result = [];
        }

        return $result;
    }

    //---------------------------------------------------------------------
    // 発行情報の登録
    //---------------------------------------------------------------------
    public function regist(Request $request){

        //---------------------------------------------------------------------
        // リクエスト取得
        //---------------------------------------------------------------------
        $printDate      = $request->input("printDate");
        $lotseq         = $request->input("lotseq");
        $supplierCode   = $request->input("supplierCode");
        $warehouseCode  = $request->input("warehouseCode");
        $itemCode       = $request->input("itemCode");
        $qtyPer         = $request->input("qtyPer");
        $pattern        = $request->input("pattern");
        $numSheet       = $request->input("numSheet");
        $startNum       = $request->input("startNum");
        $insDate        = date("Y-m-d H:i:s");

        // 数値に直す
        $lotseq         = intval($lotseq);
        $qtyPer         = intval($qtyPer);
        $startNum       = intval($startNum);
        $numSheet       = intval($numSheet);

        $ID_YMDHIS      = date("YmdHis");

        // 印刷履歴のID
        $P_ID = mb_substr($ID_YMDHIS, 2, 12);
        // QR発行履歴のID
        $Q_IDS = [];

        //---------------------------------------------------------------------
        // トランザクション開始
        //---------------------------------------------------------------------
        DB::beginTransaction();

        try {

            // 日付連番の更新
            // 第一引数(key)がテーブルにない場合は登録、ある場合は更新をしてくれる。
            DB::table('CALENDAR')->updateOrInsert(
                ['CDATE' => $printDate],
                ['LOTSEQ' => ($lotseq + $numSheet)],
            );

            // 繰り返し回数は減らしたいがソースの見易さ重視

            // QR発行履歴IDの作成
            for ($i = 0; $i < $numSheet; $i++) {
                // IDの作成
                $IDYMD = str_replace('-', '', $printDate);
                $IDYMD = mb_substr($IDYMD, 2, 6);
                $IDLOT = str_pad(($lotseq + $i), 6, 0, STR_PAD_LEFT);
                $Q_IDS[] = $IDYMD . $IDLOT;
            }

            // QR発行履歴の登録
            $count = count($Q_IDS);
            for ($i = 0; $i < $count; $i++) {
                DB::table('QR_RESULT')->insert([
                    'ID'             => $Q_IDS[$i],
                    'PRINT_DATE'     => $printDate,
                    'LOTSEQ'         => ($lotseq + $i),
                    'SUPPLIER_CODE'  => $supplierCode,
                    'WAREHOUSE_CODE' => $warehouseCode,
                    'ITEM_CODE'      => $itemCode,
                    'QTY_PER'        => $qtyPer,
                    'PATTERN'        => $pattern,
                    'INS_DATE'       => $insDate,
                ]);
            }

            // 印刷履歴鑑
            DB::table('PH_RESULT')->insert([
                'ID'                => $P_ID,
                'START_POSITION'    => $startNum,
                'INS_DATE'          => $insDate,
            ]);

            // 印刷履歴明細
            $count = count($Q_IDS);
            for ($i = 0; $i < $count; $i++) {
                DB::table('PD_RESULT')->insert([
                    'ID'            => $P_ID,
                    'SEQ'           => ($i + 1),
                    'QR_ID'         => $Q_IDS[$i],
                ]);
            }

            //---------------------------------------------------------------------
            // コミット
            //---------------------------------------------------------------------
            DB::commit();

        } catch(Exception $e) {
            //---------------------------------------------------------------------
            // トランザクションロールバック
            //---------------------------------------------------------------------
            DB::rollback();
        }

        return array(
            "printResultID" => $P_ID,
        );
    }

    public function rePrint(Request $request){

        //---------------------------------------------------------------------
        // リクエスト取得
        //---------------------------------------------------------------------
        $startNum       = $request->input("startNum");
        $rePrintIds     = $request->input("rePrintIds");
        $insDate        = date("Y-m-d H:i:s");

        // 数値に直す
        $startNum       = intval($startNum);

        $ID_YMDHIS      = date("YmdHis");

        // 印刷履歴IDの準備
        $P_ID = mb_substr($ID_YMDHIS, 2, 12);

        //---------------------------------------------------------------------
        // トランザクション開始
        //---------------------------------------------------------------------
        DB::beginTransaction();

        try {

            // 再発行、正確には印刷履歴マスタに新しい印刷構成を登録する。
            // なので連番の更新とQR履歴の登録はいらない。

            // 印刷履歴鑑
            DB::table('PH_RESULT')->insert([
                'ID'                => $P_ID,
                'START_POSITION'    => $startNum,
                'INS_DATE'          => $insDate,
            ]);

            for ($i = 0; $i < count($rePrintIds); $i++) {

                // 印刷履歴明細
                DB::table('PD_RESULT')->insert([
                    'ID'            => $P_ID,
                    'SEQ'           => ($i + 1),
                    'QR_ID'         => $rePrintIds[$i],
                ]);
            }

            //---------------------------------------------------------------------
            // コミット
            //---------------------------------------------------------------------
            DB::commit();

        } catch(Exception $e) {
            //---------------------------------------------------------------------
            // トランザクションロールバック
            //---------------------------------------------------------------------
            DB::rollback();
        }

        return array(
            "printResultID" => $P_ID,
        );
    }

    public function resetSession(Request $request){
        $_SESSION['printcheck'] = 0;//セッション変数に登録
        return;
    }

    public function qrPrint(Request $request, $printResultID){

        // $printResultIDを基準に印刷するQRデータを取得する。
        $query = phResult::query();

        $query->from('PH_RESULT as PH');
        $query->join('PD_RESULT as PD', function($join) {
            $join->on('PH.ID', 'PD.ID');
        });
        $query->join('QR_RESULT as QR', function($join) {
            $join->on('PD.QR_ID', 'QR.ID');
        });
        $query->join('ITEMS as IT', function($join) {
            $join->on('QR.ITEM_CODE', 'IT.CODE');
        });

        // 条件
        $query->where('PH.ID', $printResultID);
        // 並び順
        $query->OrderBy('PH.ID', 'asc');
        $query->OrderBy('PD.SEQ', 'asc');
        // 項目
        $query->select('PH.ID', 'PH.START_POSITION', 'PD.SEQ', 'QR.PRINT_DATE', 'QR.LOTSEQ', 'QR.SUPPLIER_CODE', 'QR.WAREHOUSE_CODE', 'QR.ITEM_CODE', 'QR.QTY_PER', 'QR.PATTERN', 'IT.NAME as ITEM_NAME');
        // 取得
        $records = $query->get();

        if (0 == count($records)) { return; }

        // PDF作成
        $pdf = new Pdf([
            // エンコード形式
            'encoding'      => 'utf-8',
            'margin-top'    => 21.2,
            'margin-left'   => 18,
            'no-outline',
            'disable-smart-shrinking',
            'page-size'     => 'A4',        // 用紙:A4
            'orientation'   => 'portrait',  // 縦向き
        ]);

        // ファイル名
        $fileName = "";
        $fileName = $fileName . "QR" . "_" . $printResultID . ".pdf";

        // 一行目取得(開始位置用)
        $head = $records[0];

        // 開始位置
        $startNum = ($head['START_POSITION'] - 1);
        // 枚数
        $numSheet = (count($records) + $startNum);

        //意図しない印刷連番の変更が行われないようにする（ブラウザからadobeReaderに出力した際に、処理が繰り替えされてしまっていたため対応）
        if ($_SESSION['printcheck'] ==0) {

            $html="<script>document.title=\"". $fileName ."\"; </script>";

            // 印刷枚数分、繰り返す。
            $recordsCont = count($records);
            for ($count = 0; $count < ($recordsCont + $startNum); $count++) {

                // 空の配列を用意する。
                // ↓で色々使うので予め用意しておく
                $SNO = "";
                $QTY = "";
                $Code1 = "";
                $Code2 = "";
                $QRCode = "";
                $SupplierCode = "";
                $ItemCode = "";
                $ItemName = "";

                // 開始位置より前の部分は型だけ作成して非表示にする。
                $visual = "";
                if ($count < $startNum) { 
                    $visual = "visibility:hidden;";
                } else {

                    // レコードの取得
                    $record = $records[($count - $startNum)];
                    // 日付 yyMMdd
                    $YYMMDD = mb_substr(str_replace('-', '', $record['PRINT_DATE']), 2, 6);
                    // 連番 6桁0埋め
                    $SNO = str_pad($record['LOTSEQ'], 6, 0, STR_PAD_LEFT);
                    // 入数
                    $QTY = $record['QTY_PER'];
                    // 仕入先/倉庫
                    if ($record['SUPPLIER_CODE'] != null) {
                        $SupplierCode = $record['SUPPLIER_CODE'];
                    } else {
                        $SupplierCode = $record['WAREHOUSE_CODE'];
                    }
                    // 商品
                    $ItemCode = $record['ITEM_CODE'];
                    // 商品
                    $ItemName = $record['ITEM_NAME'];
                    // 形式
                    $PATTERN = $record['PATTERN'];
                    // 日付 + 連番
                    $Code1 = $YYMMDD . $SNO;
                    // 日付 + 連番 + 形式 + 入数(10桁0埋め)
                    $Code2 = $Code1 . $PATTERN . str_pad($QTY, 10, 0, STR_PAD_LEFT);;
                    // QRコード = 仕入先 + 商品コード + 日付 + 連番 + 形態 + 入数
                    $QRCode = $SupplierCode . str_pad($ItemCode, 25) . $Code2;
                    $QRCode = \DNS2D::getBarcodePNG($QRCode, 'QRCODE', 4, 4);
                }

                $html=$html."<table style=\"width:86.4mm;height:42.3mm;float:left;" . $visual . "\">";
                $html=$html."   <tr style=\"height:5mm;font-size:10px;\">";
                $html=$html."       <td rowspan=4 style=\"width:30mm;\">";
                $html=$html."           <img src=\"data:image/png;base64," . $QRCode . "\"/>";
                $html=$html."       </td>";
                $html=$html."       <td>". $SupplierCode ."</td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:5mm;font-size:10px;\">";
                $html=$html."       <td>" . $Code2 . "</td>";
                $html=$html."       <td width=50px></td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:10mm;font-size:25px;\">";
                $html=$html."       <td>". $ItemCode ."</td>";
                $html=$html."       <td>". $QTY ."</td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:10mm;font-size:10px;\">";
                $html=$html."       <td style=\"font-size:25px;\">" . $Code1 . "</td>";
                $html=$html."   </tr>";
                $html=$html."   <td style=\"font-size:20px;\" colspan=5>" . $ItemName . "</td>";
                $html=$html."</table>";

                // 12枚で改ページ
                if (($count + 1) %12 == 0) {
                    $pdf->addPage($html);
                    $html="";
                }
            }

            $_SESSION['printcheck'] = 1;//セッション変数を1に変更
        } else {

            $html="<script>document.title=\"". $fileName ."\"; </script>";

            // 印刷枚数分、繰り返す。
            $recordsCont = count($records);
            for ($count = 0; $count < ($recordsCont + $startNum); $count++) {

                // 空の配列を用意する。
                // ↓で色々使うので予め用意しておく
                $SNO = "";
                $QTY = "";
                $Code1 = "";
                $Code2 = "";
                $QRCode = "";
                $SupplierCode = "";
                $ItemCode = "";
                $ItemName = "";

                // 開始位置より前の部分は型だけ作成して非表示にする。
                $visual = "";
                if ($count < $startNum) { 
                    $visual = "visibility:hidden;";
                } else {

                    // レコードの取得
                    $record = $records[($count - $startNum)];
                    // 日付 yyMMdd
                    $YYMMDD = mb_substr(str_replace('-', '', $record['PRINT_DATE']), 2, 6);
                    // 連番 6桁0埋め
                    $SNO = str_pad($record['LOTSEQ'], 6, 0, STR_PAD_LEFT);
                    // 入数
                    $QTY = $record['QTY_PER'];
                    // 仕入先/倉庫
                    if ($record['SUPPLIER_CODE'] != null) {
                        $SupplierCode = $record['SUPPLIER_CODE'];
                    } else {
                        $SupplierCode = $record['WAREHOUSE_CODE'];
                    }
                    // 商品
                    $ItemCode = $record['ITEM_CODE'];
                    // 商品
                    $ItemName = $record['ITEM_NAME'];
                    // 形式
                    $PATTERN = $record['PATTERN'];
                    // 日付 + 連番
                    $Code1 = $YYMMDD . $SNO;
                    // 日付 + 連番 + 形式 + 入数(10桁0埋め)
                    $Code2 = $Code1 . $PATTERN . str_pad($QTY, 10, 0, STR_PAD_LEFT);;
                    // QRコード = 仕入先 + 商品コード + 日付 + 連番 + 形態 + 入数
                    $QRCode = $SupplierCode . str_pad($ItemCode, 25) . $Code2;
                    $QRCode = \DNS2D::getBarcodePNG($QRCode, 'QRCODE', 4, 4);
                }

                $html=$html."<table style=\"width:86.4mm;height:42.3mm;float:left;" . $visual . "\">";
                $html=$html."   <tr style=\"height:5mm;font-size:10px;\">";
                $html=$html."       <td rowspan=4 style=\"width:30mm;\">";
                $html=$html."           <img src=\"data:image/png;base64," . $QRCode . "\"/>";
                $html=$html."       </td>";
                $html=$html."       <td>". $SupplierCode ."</td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:5mm;font-size:10px;\">";
                $html=$html."       <td>" . $Code2 . "</td>";
                $html=$html."       <td width=50px></td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:10mm;font-size:25px;\">";
                $html=$html."       <td>". $ItemCode ."</td>";
                $html=$html."       <td>". $QTY ."</td>";
                $html=$html."   </tr>";
                $html=$html."   <tr style=\"height:10mm;font-size:10px;\">";
                $html=$html."       <td style=\"font-size:25px;\">" . $Code1 . "</td>";
                $html=$html."   </tr>";
                $html=$html."   <td style=\"font-size:20px;\" colspan=5>" . $ItemName . "</td>";
                $html=$html."</table>";

                // 12枚で改ページ
                if (($count + 1) %12 == 0) {
                    $pdf->addPage($html);
                    $html="";
                }
            }
        }

        // 端数ページが存在していた場合に追加
        if($numSheet % 12 != 0){
            $pdf->addPage($html);
        }

        //PDF化実行
        //        $pdf->send(); ダウンロードファイル名をの仮テスト

        // 保存先の指定
        $PdfPath = public_path() . "/pdf";

        if (!file_exists($PdfPath)) {
            mkdir($PdfPath, 0777);
        }

        $pdf->saveAs($PdfPath . "/" . $fileName);
        $pdf->send($fileName);

    }
}