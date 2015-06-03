<?php
$birthday = $_POST['birthday']
//$_post inputの情報がpostに入る
//
$youbi = date("l", strtotime($birthday));

?>
<!DOCTYPE html>
<html lang ="ja">
<head>
  <meta charaset="UTF-8" />
  <title>PHPの練習</title>
</head>
<body>
  <h1>PHPの練習</h1>
  <p> <?php echo $youbi;?></p>
