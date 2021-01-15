<?php
require_once('funcs.php');

//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','root');
  } catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
  }
  

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
   //引数のPDO::FETCH_ASSOCは、列名を記述し配列で取り出す設定をしている。配列の最後まで下記を実行し続ける
  //fetch:取り出す。Assoc:Associationで、連想する
  //この例は1列だけだが、今後複数になるため連想配列を使う
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
   $view .= '<p>' . h($result['id']) . ' / '.h($result['書籍名']) . ' / ' . h($result['書籍URL']) . ' / ' . h($result['書籍コメント']) . ' / ' .h($result['登録日']) . ' / ' .'</p>';
  }
}

?>


<table>
         <tr id=li>
            <th>id</th>
            <th>書籍名</th>
            <th>書籍URL</th>
            <th>書籍コメント</th>
            <th>登録日</th>
        </tr>

      </table>

<div>

    <div class="container jumbotron"><?= $view ?></div>
</div>
