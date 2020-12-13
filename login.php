<?php
require 'password.php';
// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // １．ユーザIDの入力チェック
  if (empty($_POST["userid"])) {
    $errorMessage = "ユーザIDが未入力です。";
  } else if (empty($_POST["password"])) {
    $errorMessage = "パスワードが未入力です。";
  } 

  // ２．ユーザIDとパスワードが入力されていたら認証する
  if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
    // mysqlへの接続
    $mysqli = new mysqli('mysql1.php.xdomain.ne.jp', 'yutolab_root', 'yagi1120');
    if ($mysqli->connect_errno) {
      print('<p>データベースへの接続に失敗しました。</p>' . $mysqli->connect_error);
      exit();
    }

    // データベースの選択
    $mysqli->select_db('yutolab_sirop');

    // 入力値のサニタイズ
    $userid = $mysqli->real_escape_string($_POST["userid"]);

    // クエリの実行
    $query = "SELECT * FROM login WHERE name = '" . $userid . "'";
    $result = $mysqli->query($query);
    if (!$result) {
      print('クエリーが失敗しました。' . $mysqli->error);
      $mysqli->close();
      exit();
    }

    while ($row = $result->fetch_assoc()) {
      // パスワード(暗号化済み）の取り出し
      $db_hashed_pwd = $row['password'];
    }

    // データベースの切断
    $mysqli->close();

    // ３．画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較します。
    //if ($_POST["password"] == $pw) {
    if (password_verify($_POST["password"], $db_hashed_pwd)) {
      // ４．認証成功なら、セッションIDを新規に発行する
      session_regenerate_id(true);
      $_SESSION["USERID"] = $_POST["userid"];
      header("Location: main.php");
      exit;
    } 
    else {
      // 認証失敗
      $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
    } 
  } else {
    // 未入力なら何もしない
  } 
} 
 
?>
<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Sirop ログイン</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style>
        input[type="text"],input[type="password"],input[type="submit"] {
	        width:259px;
            height:50px;
        }
        </style>
</head>
  <body>
    <!-- Just an image -->
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="">
    <img src="img/sirop.png" width="100" height="40" alt="">
  </a>
</nav>
<div class="container"><br>

  <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
  <!--<form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">-->
  <form id="loginForm" name="loginForm" action="" method="POST">
  <fieldset>
  <legend><center><b>お帰りなさい！</b></center></legend>
  <center>Siropアカウントでログインしてください。</center>
 <center><div><?php echo $errorMessage ?></div></center>
<br>
    <center><input placeholder="ユーザーID" type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>"></center><br>
    <center><input placeholder="パスワード" type="password" id="password" name="password" value=""></center>
    <br><br><center><input class="btn btn-outline-primary" type="submit" id="login" name="login" value="ログイン"></center>

  </fieldset>
  </form>
  <br><center><a href="add.html">新規登録</a></center>
</div></body>
</html>

