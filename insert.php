<html>
  <meta charset="UTF-8">
  <head>
    <title>ログインユーザー追加ページ</title>
  </head>
  <body>
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
    die('INSERTクエリーが失敗しました。すでに同じNAMEが登録されている可能性があります。<br><a href="add.html">戻る</a>');
}

print('<p>' . $name . 'ユーザーを登録しました。</p>');

$close_flag = mysql_close($link);

?>
  <a href="add.html">戻る</a>
  </body>
</html>