<?php
//1. POSTデータ取得
$name   = $_POST["name"];
$id  = $_GET["id"];
$password = $_POST["password"];
$kanri_flg    = $_POST["kanri_flg"]; 
$life_flg    = $_POST["life_flg"]; 


//追加されています


//2. DB接続します
//*** function化する！  *****************
try {
    $db_name = "gs_db";    //データベース名
    $db_id   = "root";      //アカウント名
    $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
    $db_host = "localhost"; //DBホスト
    $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
}

$stmt = $pdo->prepare("DELETE FROM gs_user_table WHERE id = :id");

//  2. バインド変数を用意
$stmt->bindValue(':id', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:".$error[2]);
  }else{
    //５．k_form.phpへリダイレクト
  
    header('Location:m_kanri.php');
  }

?>
