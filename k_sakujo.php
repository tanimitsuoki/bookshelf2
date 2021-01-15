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



$id=$_POST['id'];
$delete=$_POST['delete'];

echo $id;


var_dump($id);
var_dump($delete);

var_dump($id);

if (!empty($_POST['delete']) && !empty($_POST['id'])) {
    foreach ($_POST['id'] as $no => $val) {
    echo $no .'<br />'; // ←こいつを削除
    }
}
// DELETE文を変数に格納
$sql = "DELETE FROM gs_bm_table WHERE id = :id";
// 削除するレコードのIDは空のまま、SQL実行の準備をする
$stmt = $pdo->prepare($sql);
$params = $id;

// foreachで削除するレコードを1件ずつループ処理
foreach ($params as $no => $val) {
    
// 配列の値を :id にセットし、executeでSQLを実行
    $stmt->execute(array(':id' => $no));
}



//４．データ登録処理後
if($stmt==false){
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