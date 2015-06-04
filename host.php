<?php

$s = range(6, 24);
$k = range(1, 5);
$time = array_merge($s,$k);
  //sとkの配列を組み合わせる


  //スーパーグローバル変数$_POST
if($_SERVER['REQUEST_METHOD']=='POST') {
  //送信（POST）されているか
  //var_dump($_POST);
  //送信されたvalueを受け取る
}

$file = "file.dat";
$contents = file($file);
//var_dump($contents);
//コンテンツが存在するだけpersndataの配列をつくりたい
//$persondata配列contentsと同じ文の配列の数
$count =count($contents);
for($y=0; $y < $count; $y++ ) {
  $persondata[] = explode("　", $contents[$y]);
}
//var_dump($persondata[0]);
?>
<!DOCTYPE html>
<html lang ='ja'>
<head>
  <meta charaset = 'UTF-8'>
  <title>シフトが出来上がったよ</title>
  <link rel="stylesheet" href="host.css">
</head>
<body>
  <h1>完成したシフト表はこちら</h1>
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
          //$worker = array("たかけん", "いのうえ", "ふじた", "おりまー");
          $pic = array("たかけん" => "./takakura.png","いのうえ"　=> "./inoue.jpeg","ふじた" =>"./huzita.jpeg","おりまー" => "./olimer.jpeg");
          for ($j = 0; $j < $count; $j++) {
            //スタートでポストされた値がtimeの何番目位置番号を保存する
            //スタートでポストされた値がtime配列のjの位置に保存されていますか？
            //timeの添字がj（time配列のj番目）
            //timeのj番目のことをsatarttimeに保存します
            for($p = 0; $p < 25; $p++) {
              if ( $time[$p] == $persondata[$j][1] ) {
                //右のものを左に入れる
                $starttime = $p;
              }
              if ($time[$p] == $persondata[$j][2] ) {
                $endtime = $p;
              }
            }
            //変化する値を左側におく
            if( $i - 1 >= $starttime && $i - 1 < $endtime  && $persondata[$j][3][$b-1] == 1 && $b > 0) {
              print <img src=$pic[$persondata[$j][0]]>"\n";
              // if($persondata[$j][0] == $worker[0]) {
              //   echo "<img src='$pic[0]'>\n";
              // } elseif ($persondata[$j][0] == $worker[1]) {
              //   echo "<img src='$pic[1]'>\n";
              // } elseif ($persondata[$j][0] == $worker[2]) {
              //   echo "<img src='$pic[2]'>\n";
              // } elseif ($persondata[$j][0] == $worker[3]) {
              //   echo "<img src='$pic[3]'>\n";
              // } else {
              //   echo "◯";
              // }
            //echo "<img src ='./takakura.png'>";
            //echo $pic[$j];
            //echo $j."\n";
          }
          }
          ?>
          </td>
        <?php
        //$cost = ( $endtime - $starttime) * 720;
        //echo $cost;
        ?>

        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>
</html>
