<?php

require_once('ClassPDO.php');

function GETAllData(){
    // クラスの呼び出し
    $obj=new ConnectPDO();
    $obj->PDO();
    $Arr = $obj->GetAllData();
    // 見かけ上のidを付与する(内部データではidがなくなることはない)
    $count = 1;
    foreach ($Arr as $keys=> $arr){
        echo (string) $count.'<br>';
        // echo $arr['id'].'<br>';
        echo $arr['name'].'<br>';
        echo $arr['comment'].'<br>';
        echo $arr['created'].'<br>';
        // countの値を更新
        $count++;
    }
}

function GETTrueID($input_id){
    // クラスの呼び出し
    $obj=new ConnectPDO();
    $obj->PDO();
    $Arr = $obj->GetAllData();
    // 見かけ上のidを付与する(内部データではidがなくなることはない)
    $count = 1;
    foreach ($Arr as $keys=> $arr){
        if ($input_id == $count){
            //echo $arr['id'];
            return $arr['id'];
        }
        // countの値を更新
        $count+=1;
    }
}

function CEHCKPassword($id,$pass){
    // クラスの呼び出し
    $obj=new ConnectPDO();
    $obj->PDO();
    // 見かけ上のidと入力されたpassからパスワードが一致しているか判断する関数
    // 真のidを取得
    $True_id = GETTrueID($id);
    // 真のpassを取得
    $True_pass = $obj->GetPassFromID($True_id);
    if ($pass==$True_pass[0]){
        return 1;
    }else{
        return 0;
    }
}

function GETPassword($id){
    // クラスの呼び出し
    $obj=new ConnectPDO();
    $obj->PDO();
    // 見かけ上のidと入力されたpassからパスワードが一致しているか判断する関数
    // 真のidを取得
    $True_id = GETTrueID($id);
    // 真のpassを取得
    $True_pass = $obj->GetPassFromID($True_id);
    return $True_pass[0];
}

?>