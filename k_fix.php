<?php
require_once('funcs.php');

//1.  DB接続します
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','root');//MAMPIDPassが「root」になっている
  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

  $id=$_POST['id'];
  $name=$_POST['name'];
  $url=$_POST['url'];
  $naiyou=$_POST['naiyou'];
  $date=$_POST['date'];

  echo $id;
  echo $name;
  echo $url;
  echo $naiyou;
  echo $date;

  //２．データ取得SQL作成
$stmt = $pdo->prepare("UPDATE gs_bm_table SET 書籍名 = '$name',
書籍URL = '$url',書籍コメント = '$naiyou',登録日 = '$date' WHERE id = $id");
$status = $stmt->execute();

var_dump($status);

if($stmt==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:".$error[2]);
  }else{
    //５．k_form.phpへリダイレクト

    header('Location:k_form.php');
    
  }






?>