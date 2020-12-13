<?php
session_start();

// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
  header("Location: logout.php");
  exit;
}

?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Sirop ダッシュボード</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <body>    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="">
            <img src="img/sirop.png" width="100" height="40" alt="">
        </a>
    </nav><div class="container"><br>
  <!-- ユーザIDにHTMLタグが含まれても良いようにエスケープする -->
  <p><?=htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?> さん でログイン中</p>
  <ul>
  <li><a href="logout.php">ログアウト</a></li>
  </ul>
</div></body>
</html>