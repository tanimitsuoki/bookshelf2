<?php
require_once('funcs.php');

//1. DB接続します
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

//1. POSTデータ取得
$id   = $_POST["id"];
$name   = $_POST["name"];
$lid  = $_POST["lid"];
$password = $_POST["lpw"];
$kanri_flg    = $_POST["kanri_flg"]; 
$life_flg    = $_POST["life_flg"]; 

echo $id;
echo $name;
echo $lid;
echo $password;
echo $kanri_flg;
echo $life_flg;

if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,100}+\z/i', $_POST['lpw'])) {
    $password = password_hash($_POST['lpw'], PASSWORD_DEFAULT);
  } else {
    echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。<br />';
    echo '<a href="m_kanri.php">管理画面に戻る</a>';
    return false;
  }

//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_user_table SET name = '$name',
lid = '$lid',lpw = '$password',kanri_flg = '$kanri_flg',life_flg = '$life_flg'  WHERE id = $id");

$stmt->bindValue(':name', $name, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':password', $password, PDO::PARAM_STR);        //Integer（数値の場合 PDO::PARAM_INT)

$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_STR);        //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':life_flg', $life_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
    //*** function化する！*****************
    header('Location:m_kanri.php');
    exit();
}
?>