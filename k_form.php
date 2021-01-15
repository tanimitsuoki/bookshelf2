
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>本棚</title>
  <link href="css/k_form.css" rel="stylesheet">
</head>
<body>

<?php
require_once('funcs.php');

session_start();
if(!isset($_SESSION["lid"])) {
  $no_login_url = "m_signUp.php";
  header("Location: {$no_login_url}");
  exit;
}


//1.  DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','root');
  } catch (PDOException $e) {
    exit('DBConnectError'.$e->getMessage());
  }
  


//３．データ表示
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();



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


<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand"> g's Bookshelf</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->

  <!-- 削除＿モーダル部分 -->
  <div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
        <p>本当に消去しますか？</p>
        <div class="modal__btnarea">
          <button class="js-modal-on btn">続ける</button>
          <button class="js-modal-close btn">キャンセル</button>
        </div>
    </div>
  </div>

<div class="mainarea">

  <p class="main_explanation">保存したい情報を入力下さい</p>

  <form method="post" action="k_check.php" class=inputarea onsubmit="return chk1(this)">
   
          <input type="text" name="name" id="name" placeholder="書籍名を入力">
          <input type="text" name="url" id="url" placeholder="書籍URLを入力">
          <textarea id="amount" name="naiyou"placeholder="詳細を入力"></textarea>
          <input id="get" type="submit" value="新規登録">
   </form>
       
</div>

 <!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    function chk1(frm){
        if(frm.elements["name"].value==""||frm.elements["url"].value==""||frm.elements["naiyou"].value==""){
            alert("テキストボックスに入力してください");
            /* FALSEを返してフォームは送信しない */
            return false;
        }else{
            /* TRUEを返してフォーム送信 */
            return true;
        }
    }
</script>

<?php
      echo "<form action=k_a_sakujo.php method=post id=saku1 name=form1>";
      echo "<input type=hidden  name=id value=" . $row["id"] . ">";
      echo "<td><input type=submit value=全件削除 id=btn  ></td>";
      echo "</form>";
?>

<script type="text/javascript">

  // デフォルトのイベントをキャンセル
  const button1 = document.getElementById('btn');
  button1.addEventListener('click', (e) => {
  e.preventDefault();
  
  $(function() {
  var preventEvent = true;
  if(preventEvent) {
  //モーダル画面にして消去を確認
    $('.js-modal').fadeIn();
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
      });
    $(".js-modal-on").on("click",function(){
      document.form1.submit();
      document.myform.action = "k_a_sakujo.php";
    });
      } else {
        return false;
      }
  });

});
 </script>


   <div id=b>
    <form method="post" action="k_sakujo.php" id=saku name=form2>
    <table>
            <tr>
                <th id=a>選択</th>
                <th id=a>id</th>
                <th>書籍名</th>
                <th>書籍URL</th>
                <th>書籍コメント</th>
                <th id=c>登録日</th>
                <th id=c>編集</th>
            </tr>

    <?php
            $stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
            $status = $stmt->execute();

            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
              $rows[] = $result;
            }      
            foreach($rows as $row){
    ?>
      <tr>
          <td><input name="id[<?php echo$row['id']?>]" type="checkbox" value="1"></td>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['書籍名']; ?></td>
          <td>
          <a href="<?php echo $row['書籍URL']; ?>" target="_blank" ><?php echo $row['書籍URL']; ?></a>
          </td>
          <td ><?php echo $row['書籍コメント']; ?></td>
          <td ><?php echo $row['登録日']; ?></td>
          <td><a href="k_edit.php?id=<?= $row['id']; ?>">更新</a></td>
        </tr> 

    <?php
    }
    ?>
          </table>
          <?php
          echo '<input type="submit" id=btn1 name="delete" value="選択削除" />';
          echo '</form>';

          echo '<a href="m_logout.php">ログアウト</a>';

          ?>

<script type="text/javascript">
// デフォルトのイベントをキャンセル

const button2 = document.getElementById('btn1');
button2.addEventListener('click', (e) => {
e.preventDefault();

$(function() {
var preventEvent1 = true;
if(preventEvent1) {
//モーダル画面にして消去を確認
  $('.js-modal').fadeIn();


  $('.js-modal-close').on('click',function(){
      $('.js-modal').fadeOut();
      return false;
    });
  $(".js-modal-on").on("click",function(){
    document.form2.submit();
    document.myform.action = "k_sakujo.php";
  });
    } else {
      return false;
    }
});

});
</script>



    </div>

<!-- Main[End] -->

<!-- 配列の中身を表示 -->
<!-- var_dump($rows); -->

</body>
</html>