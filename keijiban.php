

<?php

echo"hello world";
echo"<br>";
echo"もう一行！";
$box1 = "takaken";
$box2 = 2015 - 1991;
echo $box1;
echo"<br>";
echo $box2;
echo"<br>";
echo $box1.$box2;
?>
<html>
<form actin = "keijiban.php" method = "GET">
  <textarea name = "contents">
  </textarea>
  <input type = "submit" value = "ツイート">
</form>

<?php
$catch = $_GET["contents"];
$len = mb_strlen($catch,"UTF-8");

echo $catch;
if( $len == 0 ) {
  echo "未入力です";
} elseif($len < 140) {
  echo "入力できました";
}
 ?>

</html>
