<?php

  $s = range(6, 24);
  $k = range(1, 5);
  $time = array_merge($s,$k);
  //sとkの配列を組み合わせる
  //スーパーグローバル変数$_POST

if( $_SERVER['REQUEST_METHOD']=='POST') {
  //送信（POST）されているか
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
    // contentsにyoubiをふくめたい
    // countで７回回る宣言
    // ７回youbiの配列から値をとりだして、ファイルに保存するデータを作る
    // ファイルにデータを保存したい
    $contents = $contents.$youbi[$y];
  }

  $file = "file.dat";
  $worker = "worker.dat"
  $contents = file($file);
  $person = $_POST["person"];
  //var_dump($contents);
  //コンテンツが存在するだけpersndataの配列をつくりたい
  //$persondata配列contentsと同じ文の配列の数
  for ($j = 0; $j < $count; $j++) {
    if (strstr($contents[$j], $person) != false) {
      unset($contents[$j]);
    }
  }
  $contents = array_merge($contents);
  $count = count($contents);
  var_dump($contents);
  for($y=0; $y < $count; $y++ ) {
    $persondata[] = explode("　", $contents[$y]);
  }
  // $worker = array("たかけん", "いのうえ", "ふじた", "おりまー");
  // for ($w=0; $w <count($worker) ; $w++) {
    //if($_POST["person"] == $worker[$w]) {
  if(is_writable($file)) {
    if(!$fp = fopen($file, "w")){
      echo "could not open";
      exit;
    }
    for($m = 0; $m < $count; $m++ ){
      if(fwrite($fp, $contents[$m]) === false){
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

          // for ($j = 0; $j < 25; $j++) {
          //   //スタートでポストされた値がtimeの何番目位置番号を保存する
          //   //スタートでポストされた値がtime配列のjの位置に保存されていますか？
          //   //timeの添字がj（time配列のj番目）
          //   //timeのj番目のことをsatarttimeに保存します
          //   if ( $time[$j] == $_POST['start'] ) {
          //   //右のものを左に入れる
          //     $starttime = $j;
          //   }
          //   if ($time[$j] == $_POST['end'] ) {
          //     $endtime = $j;
          //   }
          // }
          // //変化する値を左側におく
          // if( $i - 1 >= $starttime && $i - 1 <= $endtime  && $b == $_POST['c'.$b] && $b > 0) {
          //   echo '◯';
          // }
          $pic = array("たかけん" => "./takakura.png","いのうえ"=> "./inoue.jpeg","ふじた" =>"./huzita.jpeg","おりまー" => "./olimer.jpeg");
          //$pic = array("./takakura.png","./inoue.jpeg","./huzita.jpeg","./olimer.jpeg");
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
               echo "<img src='{$pic[$persondata[$j][0]]}'>\n";
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
