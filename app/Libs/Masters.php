<?php
namespace App\Libs;

class Masters {
    public static function StatusMaster(){
        $master = array();
        
        $master[] = array(
            'id' => 0,
            'name' => "未確定",
        );
        
        $master[] = array(
            'id' => 1,
            'name' => "入力確定",
        );
        
        $master[] = array(
            'id' => 2,
            'name' => "出荷完了",
        );
        
        return $master;
    }
}
