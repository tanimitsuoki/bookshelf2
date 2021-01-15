<!DOCTYPE html>
<html lang="ja">
<head>
  <link href="css/k_kanri.css" rel="stylesheet"> 
  <meta charset="UTF-8">
  <title>編集</title> 
</head>
<body>

<?php
  require_once('funcs.php');
  // URLの?以降で渡されるIDをキャッチ
$id = $_GET['id'];

if (empty($id)) {
    header("Location: m_kanri.php");
    exit;
}

//1.  DB接続します
try {
    $db_name = "gs_db";    //データベース名
    $db_id   = "root";      //アカウント名
    $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
    $db_host = "localhost"; //DBホスト
    $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT *  FROM gs_user_table WHERE id = $id");
$status = $stmt->execute();

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    }


// 結果が1行取得できたら
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $rows[] = $result;
    }
  
    foreach($rows as $row){

 ?>

<div class=mainarea1>
<p class=d>修正しますか？</p>
<form method="post" action="m_fix.php" >
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >

    なまえ<br>
    <input type="text" name="name" id="title" style="width:500px;height:50px;" 
    value=<?php echo $row['name']; ?>><br>

    ID<br>
    <input type="text" name="lid" id="content" style="width:500px;height:100px;" 
    value=<?php echo $row['lid']; ?> wrap="soft"><br>

    パスワード<br>
    <input type="text" name="lpw" id="content" style="width:500px;height:100px;" 
    value=<?php echo $row['lpw']; ?>><br>



    <select name='kanri_flg'value=<?php echo $row['kanri_flg']; ?>>
     <option selected value="<?php echo $row['kanri_flg']; ?>"><?php echo $row['kanri_flg']; ?></option>;
     <option value='1'>管理者</option>
     <option value='0'>一般</option>
     </select>
     <p>管理者＝1 一般＝0</p>

    <select name='life_flg'value=<?php echo $row['life_flg']; ?>>
    <option selected value="<?php echo $row['life_flg']; ?>"><?php echo $row['life_flg']; ?></option>;
    <option value='1'>在籍</option>
    <option value='0'>退職済</option>
    </select>
    <p>在籍＝1 退職済＝0</p> 
    <input id="get" type="submit" value="修正">

</form>
</div>

<?php
    }
    ?>
  <div class=d>
      <a href="m_kanri.php" >一覧へ戻る</a>
  </div>
</body>
</html>