<?php

  $times = array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 1, 2, 3, 4, 5);

  $hours = 24;
  $oneWeekDays = 7;
  //表に表示する曜日
  $weekJpNames = array("月", "火", "水", "木", "金", "土", "日");
  $pic = array(
    "たかけん" => "./takakura.png",
    "いのうえ"=> "./inoue.jpeg",
    "ふじた" =>"./huzita.jpeg",
    "おりまー" => "./olimer.jpeg"
  );

  $youbi = array(0, 0, 0, 0, 0, 0, 0 );
  for($i=0 ;$i < 7; $i++) {
    if(isset($_POST['c'.($i+1)]) ) {
      $youbi[$i] = 1;
    }
  }

  $contents = $_POST["person"].",".$_POST["start"].",".$_POST["end"].",";
  $count =count($youbi);

  for($i=0; $i <= $count; $i++ ){
    $contents = $contents.$youbi[$i];
  }


  $contents = file("shift.dat");
  $person = $_POST["person"];
  //var_dump($contents);
  //コンテンツが存在するだけpersndataの配列をつくりたい
  //$persondata配列contentsと同じ文の配列の数
  for ($i = 0; $i < $count; $i++){
    if (strstr($contents[$i], $person) != false){
      unset($contents[$i]);
    }
  }

  $contents = array_merge($contents);
  $count = count($contents);

  for($i=0; $i < $count; $i++ ) {
    $persondata[] = explode(",", $contents[$i]);
  }

  if(is_writable("shift.dat")){
    if(!$fp = fopen("shift.dat", "w")){
      echo "could not open";
      exit;
    }
    for($i = 0; $i < $count; $i++ ){
      if(fwrite($fp, $contents[$i]) === false){
        echo "could not write";
        exit;
      }
    }
    fclose($fp);
  } else {
    echo "not writable";
    exit;
  }

?>

<!DOCTYPE html>
<html lang ='ja'>
<head>
  <meta charaset = 'UTF-8'>
  <title>シフトを確認して調整しましょう</title>
  <link rel="stylesheet" href="owner.css">
</head>
<body>
  <h1>シフトのチェックができます</h1>
  <table>
    <?php for($i = 0; $i <= $oneWeekDays ;$i++): ?>
      <tr>
        <?php
         for($j = 0; $j < $hours; $j++): ?>
          <td>
          <?php
          if ($j > 0 && $i == 0) {
            echo $times[$j-1];
          } elseif ($j == 0 && $i > 0) {
            echo $weekJpNames[$i-1];
          } else {
            echo '　';
          }

          for ($k = 0; $k < $count; $k++) {
            //スタートでポストされた値がtimeの何番目位置番号を保存する
            //スタートでポストされた値がtime配列のjの位置に保存されていますか？
            //timeの添字がj（time配列のj番目）
            //timeのj番目のことをsatarttimeに保存します
            for($l = 0; $l < 25; $l++) {
              if ( $times[$l] == $persondata[$k][1]) {
                //右のものを左に入れる
                $starttime = $l;
              }
              if ($times[$l] == $persondata[$k][2]) {
                $endtime = $l;
              }
            }
            //変化する値を左側におく
            if( $j - 1 >= $starttime && $j - 1 < $endtime  && $persondata[$k][3][$i-1] == 1 && $i > 0) {
               echo "<img src='{$pic[$persondata[$k][0]]}'>\n";
            }
          }


           ?> </tb>

        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
  <form action='' method='post' enctype="multipart/form-data">
  <!-- valueを送信 (POSTする)-->
  <!-- 氏名：<input type='text' name='person' /> -->
  シフトを変更したい従業員を選択してください
  <br>
  <select name='person'>
    <option value="従業員一覧">従業員</option>
    <option value='たかけん'>たかけん</option>
    <option value='いのうえ'>いのうえ</option>
    <option value='ふじた'>ふじた</option>
    <option value='おりまー'>おりまー</option>
  </select>
  <br>
  <p1><input type='submit' value='シフトを削除する'></p1>
  <br>
  <br>
  追加したい従業員を登録できます。
  <br>
  <p2><input type='text' value='ここに名前を入力' name='new'></p2>
  <p3><input type="file" name="upfile"><p3>
  <br>
  <p4><input type='submit' value='登録する'></p4>
</form>

</body>
</html>
