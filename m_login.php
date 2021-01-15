<?php

//1. POSTデータ取得
$lid  = $_POST["lid"];
$password = $_POST["password"];


//2. DB接続します
//*** function化する！  *****************
session_start();

try {
    $db_name = "gs_db";    //データベース名
    $db_id   = "root";      //アカウント名
    $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
    $db_host = "localhost"; //DBホスト
    $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);

$stmt = $pdo->prepare('select * from gs_user_table where lid = ?');
$stmt->execute([$_POST['lid']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);


} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    }

//emailがDB内に存在しているか確認
    if (!isset($row['lid'])) {
        echo 'IDかパスワードが間違っています。<br />';
        echo '<a href="m_signUp.php">ログイン画面に戻る</a>';

        
        return false;
    } 
    else
        if (password_verify($_POST["password"],$row['lpw'])){
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['lid'] = $row['lid'];
            header('Location:k_form.php');
             }
    else {
        echo 'IDかパスワードが間違っています。<br />';
        echo '<a href="m_signUp.php">ログイン画面に戻る</a>';
        return false;
               }
               



?>

