<?php

  $s = range(6, 24);
  $k = range(1, 5);
  $time = array_merge($s,$k);
  $time2 = range(0,24);
  //sとkの配列を組み合わせる
  //スーパーグローバル変数$_POST
if($_SERVER['REQUEST_METHOD']=='POST') {
  //送信（POST）されているか
  //var_dump($_POST);
  //送信されたvalueを受け取る
}
$youbi = array(0, 0, 0, 0, 0, 0, 0 );
for($b=0 ;$b < 7; $b++) {
  if(isset($_POST['c'.($b+1)]) ) {
    $youbi[$b] = 1;
  }
}

$file = "file.dat";
$contents = $_POST["person"]."　".$_POST["start"]."　".$_POST["end"]."　";

$count =count($youbi);
for($y=0; $y <= $count;$y++ ){
  //contentsにyoubiをふくめたい
  //countで７回回る宣言
  //７回youbiの配列から値をとりだして、ファイルに保存するデータを作る
  //ファイルにデータを保存したい
  $contents = $contents.$youbi[$y];
}
if(is_writable($file)) {
  if(!$fp = fopen($file, "a")){
    echo "could not open";
    exit;
  }
  if(fwrite($fp, $contents."\n") === false){
    echo "could not write";
    exit;
  }
  fclose($fp);

} else  {
  echo "not writable";
  exit;
}
?>

<!DOCTYPE html>
<html lang ='ja'>
<head>
  <meta charaset = 'UTF-8'>
  <title>希望シフトを入力しよう</title>
  <link rel="stylesheet" href="shift.css">
</head>
<body>
  <h1>希望の基本シフトを入力してください</h1>
  <table>
    <?php for($b = 0; $b<8 ;$b++): ?>
      <tr>
        <?php
         for($i = 0; $i<25; $i++): ?>
          <td>
          <?php
          if ($i == 0 && $b == 0 ){
            echo '　';
          } elseif ($i < 20  && $b == 0) {
            echo $s[$i - 1];
            //[i-1]がsの配列の添え字
            //s配列のi-1番目を抽出
          } elseif ($b == 0) {
            echo $k[$i - 20];
          } elseif ($i == 0 && $b == 1) {
            echo '月';
          } elseif ($i == 0 && $b == 2) {
            echo '火';
          } elseif ($i == 0 && $b == 3) {
            echo '水';
          } elseif ($i == 0 && $b == 4) {
            echo '木';
          } elseif ($i == 0 && $b == 5) {
            echo '金';
          } elseif ($i == 0 && $b == 6) {
            echo '土';
          } elseif ($i == 0 && $b == 7) {
            echo '日';
          } else {
            echo '　';
          }

          for ($j = 0; $j < 25; $j++) {
            //スタートでポストされた値がtimeの何番目位置番号を保存する
            //スタートでポストされた値がtime配列のjの位置に保存されていますか？
            //timeの添字がj（time配列のj番目）
            //timeのj番目のことをsatarttimeに保存します
            if ( $time[$j] == $_POST['start'] ) {
            //右のものを左に入れる
              $starttime = $j;
            }
            if ($time[$j] == $_POST['end'] ) {
              $endtime = $j;
            }
          }
          //変化する値を左側におく
          if( $i - 1 >= $starttime && $i - 1 <= $endtime  && $b == $_POST['c'.$b] && $b > 0) {
            echo '◯';
          }

           ?> </tb>

        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
  <form action='' method='post'>
  <!-- valueを送信 (POSTする)-->
  氏名：<input type='text' name='person' />
  <p>
    希望の曜日は？
      <p>
        <input type='checkbox' name='c1' value='1'>Mon
        <input type='checkbox' name='c2' value='2'>Tue
        <input type='checkbox' name='c3' value='3'>Wed
        <input type='checkbox' name='c4' value='4'>Tur
        <input type='checkbox' name='c5' value='5'>Fri
        <input type='checkbox' name='c6' value='6'>Sat
        <input type='checkbox' name='c7' value='7'>Sun
      </p>
    何時から働きますか？
    <select name='start'>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
      <option value='11'>11</option>
      <option value='12'>12</option>
      <option value='13'>13</option>
      <option value='14'>14</option>
      <option value='15'>15</option>
      <option value='16'>16</option>
      <option value='17'>17</option>
      <option value='18'>18</option>
      <option value='19'>19</option>
      <option value='20'>20</option>
      <option value='21'>21</option>
      <option value='22'>22</option>
      <option value='23'>23</option>
      <option value='24'>24</option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
    </select>
    何時まで働きますか？
    <select name='end'>
      <option value='6'>6</option>
      <option value='7'>7</option>
      <option value='8'>8</option>
      <option value='9'>9</option>
      <option value='10'>10</option>
      <option value='11'>11</option>
      <option value='12'>12</option>
      <option value='13'>13</option>
      <option value='14'>14</option>
      <option value='15'>15</option>
      <option value='16'>16</option>
      <option value='17'>17</option>
      <option value='18'>18</option>
      <option value='19'>19</option>
      <option value='20'>20</option>
      <option value='21'>21</option>
      <option value='22'>22</option>
      <option value='23'>23</option>
      <option value='24'>24</option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
    </select>
  </p>

  <p><input type='submit' value='作成する'></p>

</form>

</body>
</html>
