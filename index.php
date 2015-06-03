<?php
$omikuzi = array('大吉', '凶', '吉');
$result = $omikuzi[mt_rand(0, 2)];
// echo "takaken";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>おみくじ</title>
<head>
<body>
  <h1>おみくじ</h1>
  <p>今日の運勢は「<?php echo $result; ?>」です</p>
  <p><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">もう一度！</a></p>
</body>
</html>
