<!DOCTYPE html>
<html lang="ja">
<head>
  <link href="css/k_form.css" rel="stylesheet"> 
  <meta charset="UTF-8">
  <title>編集</title> 
</head>
<body>

<?php
  require_once('funcs.php');
  // URLの?以降で渡されるIDをキャッチ
$id = $_GET['id'];

if (empty($id)) {
    header("Location: k_form.php");
    exit;
}

//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','root');
  } catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
  }

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT *  FROM gs_bm_table WHERE id = $id");
$status = $stmt->execute();


// 結果が1行取得できたら
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $rows[] = $result;
    }

    foreach($rows as $row){
 ?>

<div class=mainarea1>
<p class=d>修正しますか？</p>
<form method="post" action="k_fix.php" >
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >

    書籍名<br>
    <input type="text" name="name" id="title" style="width:500px;height:50px;" 
    value=<?php echo $row['書籍名']; ?>><br>

    書籍URL<br>
    <input type="text" name="url" id="content" style="width:500px;height:100px;" 
    value=<?php echo $row['書籍URL']; ?> wrap="soft"><br>

    コメント<br>
    <input type="text" name="naiyou" id="content" style="width:500px;height:100px;" 
    value=<?php echo $row['書籍コメント']; ?>><br>

    登録日<br>
    <input type="text" name="date" id="content" style="width:500px;height:50px;" 
    value=<?php echo $row['登録日']; ?>><br>
 
    <input id="get" type="submit" value="修正">
</form>
</div>

<?php
    }
    ?>
  <div class=d>
    <a href="k_form.php" >一覧へ戻る</a>
  </div>
</body>
</html>