<?php

require_once('Functions.php');
require_once('ClassPDO.php');
$pdo = new ConnectPDO()

?>

<html>
    <head>
        <title>Hello Tech-Base</title>
    </head>
    <body>
        <h1>TEAC-BASE 掲示板</h1>
        <!-- 投稿用フォーム -->
        <h3>投稿用フォーム</h3>
        <form method="POST" Action="#">
            <p>名前：<input type="text" name="name"></p>
            <p>コメント：<input type="text" name="comment"></p>
            <p>パスワード：<input type="text" name="password"></p>
            <p><input type="submit" value="送信する"></p>
        </form>
        <?php if(array_key_exists("name", $_POST)): ?>
            <?php $pdo -> mkData($_POST['name'],$_POST['comment'],$_POST['password']) ?>
        <?php endif ?>

        <!-- 編集用フォーム -->
        <h3>編集用フォーム</h3>
        <form method="POST" Action="#">
            <p>編集したい番号：<input type="number" name="edit-id"></p>
            <p><input type="submit" value="編集"></p>
        </form>
        <!-- 編集ボタンが押されたときの処理 -->
        <?php if(array_key_exists("edit-id", $_POST)): ?>
            <p>編集が選択されました</p>
            <!-- 番号が存在するかどうかを関数で確認 -->
            <!-- 存在しない場合(id>function)は新規投稿する -->
            <?php if($_POST["edit-id"] > $pdo->GetDataLen()): ?>
                <p>番号が存在しないため新規投稿モードに切り替えます</p>
                <form method="POST" Action="#">
                    <p>名前：<input type="text" name="name"></p>
                    <p>コメント：<input type="text" name="comment"></p>
                    <p>パスワード：<input type="text" name="password"></p>
                    <p><input type="submit" value="送信する"></p>
                </form>
            <?php elseif(GETPassword($_POST["edit-id"]) == ""): ?>
                <p>パスワードが存在しないため編集できません</p>
            <!-- 存在する場合(id<function)は編集する -->
            <?php elseif($_POST["edit-id"] <= $pdo->GetDataLen()): ?>
                <p>番号が存在したため編集を開始します</p>
                <form method="POST" Action="#">
                    <p>編集する番号：<input type="number" name="edit_id" value="<?php echo $_POST['edit-id'] ?>"></p>
                    <p>コメント：<input type="text" name="edit_comment"></p>
                    <p>パスワード：<input type="text" name="edit_password"></p>
                    <p><input type="submit" value="送信する"></p>
                </form>
            <?php endif ?>
        <?php endif ?>
        <?php if(array_key_exists("edit_comment", $_POST)): ?>
            <?php 
            $judge=CEHCKPassword($_POST['edit_id'], $_POST['edit_password']);
            if($judge==1){
                $True_id=GETTrueID($_POST['edit_id']);
                echo '指定した番号'.$_POST['edit_id'];
                //echo '編集しようとしているid: '.$True_id;
                $pdo->UpDataFromID($True_id, $_POST['edit_comment']);
                echo '編集を実行しました';
            }else{
                echo 'パスワードが間違っています';
            }
            ?>
        <?php endif ?>
        
        <!-- 削除用フォーム -->
        <h3>削除用フォーム</h3>
        <form method="POST" Action="#">
            <p>削除したい番号：<input type="number" name="del-id"></p>
            <p>パスワード：<input type="text" name="del-password"></p>
            <p><input type="submit" value="削除する"></p>
        </form>
        <?php if(array_key_exists("del-id", $_POST)): ?>
            <?php if(GETPassword($_POST["del-id"]) == ""): ?>
                <p>パスワードが存在しないため削除できません</p>
            <?php else:?>
                <?php
                $judge=CEHCKPassword($_POST['del-id'], $_POST['del-password']);
                if($judge==1){
                    $True_id=GETTrueID($_POST['del-id']);
                    // echo '指定した番号'.$_POST['del-id'];
                    // echo '削除しようとしているid: '.$True_id;
                    $pdo->DELDataFromID($True_id);
                    echo '削除を実行しました';
                }else{
                    echo 'パスワードが間違っています';
                }
                ?>
            <?php endif ?>
        <?php endif ?>

        <!-- コメント -->
        <h3>コメント</h3>
        <?php GETAllData() ?>
    </body>
</html>
