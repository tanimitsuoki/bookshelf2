
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面</title>
  <link href="css/k_kanri.css" rel="stylesheet">
</head>
<body>



<a href="m_signUP.php">ログイン画面に戻る</a>
<a href="m_logout.php">ログアウト</a>

<h1>新規登録</h1>
   <form action="m_set.php" method="post">

     <label for="name">名前</label>
     <input type="text" name="name">

     <label for="lid">ID</label>
     <input type="text" name="id">

     <label for="password">password</label>
     <input type="password" name="password">

     <select name='kanri_flg'>
     <option value='1'>管理者</option>
     <option value='0'>一般</option>
     </select>

     <select name='life_flg'>
     <option value='1'>在籍</option>
     <option value='0'>退職済</option>
     </select>

     <button type="submit">Sign Up!</button>
     <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、5文字以上で設定してください。</p>
   </form>

<?php
require_once('funcs.php');




//1. POSTデータ取得
$lid  = $_POST["lid"];
$password = $_POST["password"];


//2. DB接続します
//*** function化する！  *****************
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



?>

    <div id=b>
    <form method="post" action="k_sakujo.php" id=saku name=form2>
    <table>
            <tr>
                <th id=c>名前</th>
                <th id=c>ID</th>
                <th>パスワード</th>
                <th id=a>管理者フラグ</th>
                <th id=a>在籍フラグ</th>
                <th id=a>更新</th>
                <th id=a>削除</th>
            </tr>

    <?php
            $stmt = $pdo->prepare("SELECT * FROM gs_user_table");
            $status = $stmt->execute();

            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
              $rows[] = $result;
            }      
            foreach($rows as $row){
    ?>
      <tr>
          <td><?php echo $row['name']; ?></td>
          <td ><?php echo $row['lid']; ?></td>
          <td ><?php echo $row['lpw']; ?></td>
          <td ><?php echo $row['kanri_flg']; ?></td>
          <td ><?php echo $row['life_flg']; ?></td>

          <td><a href="m_edit.php?id=<?= $row['id']; ?>">更新</a></td>
          <td><a href="m_sakujo.php?id=<?= $row['id']; ?>">削除</a></td>

        </tr> 

    <?php
    }
   

    session_start();
    if(!isset($_SESSION["kanri_flg"])) {
      $no_login_url = "m_signUp.php";
      header("Location: {$no_login_url}");
      exit;
    }
      else
          if($_SESSION["kanri_flg"]==0){
          $no_login_url = "m_signUp.php";
          header("Location: {$no_login_url}");
          exit;
          }

    ?>
          </table>



    </form>
    </div>
