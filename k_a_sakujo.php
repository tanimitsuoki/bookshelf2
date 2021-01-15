<html>
<body>
<?
//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','root');
  } catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
  }

// DELETE文を実行
$stmt = $pdo->prepare("delete from gs_bm_table ");
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:".$error[2]);
  }else{
    //５．k_form.phpへリダイレクト
  
    header('Location:k_form.php');
  }

?>
</body>
</html>