<?php
//それぞれのれつで取りうる値を規定する
// B:0-15
// I:16-30
// N:31-45 真ん中はなし
// G:46-60
// 0:61-75
$bingo = array();
//bingoは配列の要素になる

for ($i=0; $i<5; $i++) {
  //for文i<5になるまで繰り返す
  $numbers = range($i*15+1, $i*15+15);
  //range(左側の引数の数から右側の引数の数までの配列を返す)
  //iは0から15の値
  shuffle($numbers);
  $bingo[$i] = array_slice($numbers, 0, 5);
}

//var_dump($bingo);
$s = "" ;

for ($j=0; $j<5; $j++) {
  //var_dump($s);
  $s = $s . "<tr>";
  //.= 連結＄Sと<tr>をつなげる
  // "" と<tr>をつなげている
  var_dump($s);
  for ($k=0; $k<5; $k++) {
    $s = ($j == 2 && $k == 2) ? $s . "<td></td>" : $s . sprintf("<td>%s</td>", $bingo[$k][$j]);
    //三項演算子　条件(条件式)　？　正 : 誤 ;
    //%sで文字フォーマットを指定

  }
  $s = $s . "</tr>";
}

var_dump($s);

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title>BINGOつくってみよう</title>
  </head>
  <style>
    td, th {
        width: 50px;
        border: 1px blue outset;
        text-align:center;
        }
  </style>
  <body>
    <h1>PHPの練習</h1>
    <table>
      <tr><th>B</th><th>I</th><th>N</th><th>G</th><th>O</th></tr>
      <?php echo $s; ?>
   </table>
  </body>
</html>
