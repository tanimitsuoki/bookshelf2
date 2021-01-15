<?php
require_once('funcs.php');

 ?>

<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>Login</title>
 </head>
 <body>
   <h1>ようこそ、ログインしてください。</h1>
   <form  action="m_login.php" method="post">
     <label for="text">id</label>
     <input type="text" name="lid">
     <label for="password">password</label>
     <input type="password" name="password">
     <button type="submit">Sign In!</button>
   </form>
  
   </form>
   <h1>管理者画面</h1>
   <form action="m_login_kanri.php" method="post">
     <label for="text">id</label>
     <input type="text" name="lid">
     <label for="password">password</label>
     <input type="password" name="password">
     <button type="submit">Sign In!</button>
   </form>


 </body>
</html>