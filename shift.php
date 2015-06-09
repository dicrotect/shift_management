<?php

$times = array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 1, 2, 3, 4, 5);

$oneWeek = array(0, 0, 0, 0, 0, 0, 0);
$hours = 24;
$oneWeekDays = 7;
//表に表示する曜日
$weekJpNames = array("月", "火", "水", "木", "金", "土", "日");

//シフトに入っている曜日を判定
for($i = 0; $i < $oneWeekDays; $i++) {
  if(isset($_POST['c'.($i+1)])) {
    $oneWeek[$i] = 1;
  }
}

$shiftTime = $_POST["person"].",".$_POST["start"].",".$_POST["end"].",";

//ファイルに書き込む形式に曜日情報を結合
for($i = 0; $i < $oneWeekDays; $i++) {
  $shiftTime = $shiftTime.$oneWeek[$i];
}

//shift.datに$shiftTimeを書き込み
if(is_writable("shift.dat") === true) {
  $filePointer = fopen("shift.dat", "a");
  if($filePointer === false) {
    echo "could not open";
    exit;
  } elseif(fwrite($filePointer, $shiftTime."\n") === false) {
    echo "could not write";
    exit;
  }
  fclose($filePointer);
} else {
  echo "not writable";
  exit;
}

?>

<!DOCTYPE html>
<html lang='ja'>
<head>
  <meta charaset='UTF-8'>
  <title>希望シフトを入力しよう</title>
  <link rel="stylesheet" href="shift.css">
</head>
<body>
  <h1>希望の基本シフトを入力してください</h1>
  <table>
    <?php
      //週の曜日の７行+時間帯の表示の１行を表示させるため<=条件式とする
      for($i = 0; $i <= $oneWeekDays; $i++):
    ?>
      <tr>
        <?php
          //１日24時間分の列+曜日の表示の１列を表示させるため<=条件式とする
          for($j = 0; $j <= $hours; $j++):
        ?>
          <td>
            <?php
              //表に曜日と時間を表示
              if ($j > 0 && $i == 0) {
                echo $times[$j-1];
              } elseif ($j == 0 && $i > 0) {
                echo $weekJpNames[$i-1];
              } else {
                echo '　';
              }
              //表示するためにtime配列内のシフトの開始時間と終了時間の添え字を取り出す
              for ($k = 0; $k < $hours; $k++) {
                if ($times[$k] == $_POST['start']) {
                  $startTime = $k;
                }
                if ($times[$k] == $_POST['end']) {
                  $endTime = $k;
                }
              }
              //開始時間から終了時間とシフトに入る曜日に◯を出力
              if ($i > 0 && $j - 1 >= $startTime && $j - 1 <= $endTime  && $i == $_POST['c'.$i] ) {
                echo '◯';
              }
             ?>
           </tb>

      <?php endfor; ?>
    </tr>
    <?php endfor; ?>
  </table>
  <form action='' method='post'>
    氏名
    <select name='person'>
      <option value='たかけん'>たかけん</option>
      <option value='いのうえ'>いのうえ</option>
      <option value='ふじた'>ふじた</option>
      <option value='おりまー'>おりまー</option>
    </select><br>
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
    <p><input type='submit' name='push' value='作成する'></p>
    <p><input type='reset' name='reset' value='更新する'></p>
  </form>

</body>
</html>
