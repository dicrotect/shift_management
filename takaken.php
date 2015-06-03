<?php
 function h($s) {
   return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
 }

$quizulist = array(
  array(
    "q" => "おでんの具材で一番うれているのは",
    "a" => array("だいこん", "たまご", "しらたき", "牛すじ")
    //連想配列この問題の時はこの答えの選択肢がひもづけ
  ),
  array(
    "q" => "おにぎりで一番うれているのは",
    "a" => array("つなまよ", "紅しゃけ", "梅", "筋子")
  ),
  array(
    "q" => "FF商品で一番うれているのは",
    "a" => array("からあげぼう", "揚げ鳥", "ビックフランク", "鳥唐揚げ")
  ),
  array(
    "q" => "弁当で一番うれているのは",
    "a" => array("豚焼肉", "ネギ塩豚カルビ", "幕内", "のり弁当")
  )
);
//var_dump($quizulist);

$qnum = mt_rand(0, count($quizulist) - 1 );
$quizu = $quizulist[$qnum];
shuffle($quizu['a']);

?>


<!DOCTYPE html>
<html lang = "ja">
<head>
  <meta_charaset "UFT-8">
    <tittle>簡単クイズ</titlle>
</head>
<body>
  <p>Q. <?php  echo h($quizu['q']); ?> </p>
  <?php foreach ($quizu['a'] as $answer) :
    //foreach は配列の数文繰り返す
    //quizu[a]の中身をanswerとして出力する?>
    <form action="" method="post">
      <!--form action subimitが押された時に飛んで行く先-->
      <input type="submit" name="answer" value=<?php echo h($answer); ?>>

    </form>
  <?php endforeach; ?>
</body>
</html>
