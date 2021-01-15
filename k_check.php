
<?php
$name = $_POST['name'];
$url = $_POST['url'];
$naiyou = $_POST['naiyou'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>本棚_確認</title>
  <link href="css/k_form.css" rel="stylesheet">
</head>
<body>

<div class="mainarea">
 <p>下記内容で登録しますか？</p>

 <form method="post" action="k_insert.php">
    <div class="element_wrap">
     <table>
        <tr>
            <th>書籍名</th>
            <th>書籍URL</th>
            <th>詳細</th>
        </tr>
        <tr>
            <td><?php echo $_POST['name']; ?></td>
            <td><?php echo $_POST['url']; ?></td>
            <td><?php echo $_POST['naiyou']; ?></td>
        </tr> 
     </table>
        　<input type="hidden" name="name" value="<?php echo $name; ?>">
        　<input type="hidden" name="url" value="<?php echo $url; ?>">
        　<input type="hidden" name="naiyou" value="<?php echo $naiyou; ?>">
        　<input type="submit" value="登録する" id=btn>
    </div>
  </form>
</div>

<div class="element_wrap">
    <form action="k_form.php">
     <input type="submit" id=btn3 name="mo" value="戻る" />
    </form>
</div>

