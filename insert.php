<html>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <head>
    <title>Sirop ログインAPI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <body><div class="container">
<?php
require 'password.php';
$link = mysql_connect('mysql1.php.xdomain.ne.jp', 'yutolab_root', 'yagi1120');
if (!$link) {
    die('接続失敗です。'.mysql_error());
}

$db_selected = mysql_select_db('yutolab_sirop', $link);
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}

mysql_set_charset('utf8');

$result = mysql_query('SELECT name,password FROM login');
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysql_error());
}

$name = $_POST['name'];
$password = $_POST['password'];
$hashpass = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO login (name, password) VALUES ('$name','$hashpass')";
$result_flag = mysql_query($sql);

if (!$result_flag) {
    die('<br>申し訳ありません。既に同じユーザー名が登録されています。お手数ですが もう一度お試しください。<br><br><a href="add.html">登録ページに戻る</a>');
}

print('<br><p>' . $name . ' さん を登録しました。</p>');

$close_flag = mysql_close($link);

?>
  <a href="login.php">ログインページへ移動</a>
</div></body>
</html>