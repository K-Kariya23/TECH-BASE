<?php

class ConnectPDO{
    private const table='bbs_data';
    public function PDO(){
        // DB接続設定
        $dsn = "データベース名";
        $user = "ユーザー名";
        $password = "パスワード";
        try{
            $pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }catch(Exception $e){
          echo 'error' .$e->getMesseage;
          die();
        }
        //エラーを表示してくれる。
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $pdo;
    }
    
    public function ShowDataBases(){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        $sql = 'show create table bbs_data';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo $row[1];
        }
    }
    
    public function GetDataLen(){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // テーブルの名前を取得
        $table_name = self::table;
        // 入力されたテーブルから長さを取得する
        $sql = "SELECT COUNT(*) FROM ".$table_name;
        $res = $pdo->query($sql);
        $count = $res->fetchColumn();
        return $count;
    }
    
    public function GetAllData(){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // テーブルの名前を取得
        $table_name = self::table;
        // データの習得
        $sql = "SELECT id, name, comment, created FROM ".$table_name;
        $res = $pdo->query($sql);
        $data = $res->fetchAll();
        return $data;
    }
    
    public function GetPassFromID(int $id){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // テーブルの名前を取得
        $table_name = self::table;
        // データの習得
        $sql = $pdo->prepare("SELECT password FROM ".$table_name." WHERE id = :id");
        $sql -> bindParam(':id', $id, PDO::PARAM_INT);
        $sql -> execute();
        $data = $sql->fetch();
        return $data;
    }
    
    public function DELDataFromID(int $id){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // テーブルの名前を取得
        $table_name = self::table;
        // データの習得
        $sql = $pdo->prepare("DELETE FROM ".$table_name." WHERE id = :id");
        $sql -> bindParam(':id', $id, PDO::PARAM_INT);
        // $sql -> bindParam(':table', $table_name, PDO::PARAM_STR);
        $sql -> execute();
    }
    
    public function UpDataFromID(int $id, string $comment){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // テーブルの名前を取得
        $table_name = self::table;
        $sql = $pdo->prepare("UPDATE ".$table_name." SET comment=:comment WHERE id=:id");
        // 各変数にセット
        echo $comment;
        $sql -> bindParam(':comment', $comment);
        $sql -> bindParam(':id', $id);
        // SQLの実行
        $sql -> execute();
    }
    
    public function mkData($name, $comment, $password){
        // メソッドを呼び出したインスタンスに対してPDO関数を適用
        $pdo = $this->PDO();
        // SQL文を用意
        $sql = $pdo -> prepare("INSERT INTO bbs_data (name, comment, created, password) VALUES (:name, :comment, :created, :password)");
        // 各変数にセット
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':created', $time_now);
        $sql -> bindParam(':password', $password);
        // SQLの実行
        $time_now=date("Y/m/d H:i:s");
        $sql -> execute();
    }

}

?>