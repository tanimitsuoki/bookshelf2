<?php
//1. POSTデータ取得
$name   = $_POST["name"];
$lid  = $_POST["id"];
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

if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。<br />';
  echo '<a href="m_kanri.php">管理画面に戻る</a>';
  return false;
}

$stmt = $pdo->prepare("SELECT *  FROM  gs_user_table WHERE lpw = $password");
$status = $stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(count($row)!=0){
  echo "すでにパスワードは登録済みです。もう一度別のパスワードで登録してください。<br>";
}
else{

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_user_table(name,lid,lpw,kanri_flg,life_flg)VALUES(:name,:lid,:password,:kanri_flg,:life_flg)");
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
    header("Location:m_kanri.php");
    exit();
}
}
?>
