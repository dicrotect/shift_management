<?php
$times = array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 1, 2, 3, 4, 5);
//表に表示する曜日
$weekJpNames = array("月", "火", "水", "木", "金", "土", "日");
//従業員ごとに写真を対応づける
$workerIcons = array(
  "たかけん" => "./workericons/takakura.png",
  "いのうえ" => "./workericons/inoue.jpeg",
  "ふじた" => "./workericons/huzita.jpeg",
  "おりまー" => "./workericons/olimer.jpeg"
);

$shiftDatPath = "./data/shift.dat";

$hours = 24;
$oneWeekDays = 7;

$shiftTimes = file($shiftDatPath);

$workerMax = count($shiftTimes);
for($i = 0; $i < $workerMax; $i++) {
  //$workerShifts[][0]名前
  //$workerShifts[][1]開始時間
  //$workerShifts[][2]終了時間
  //$workerShifts[][3]曜日
  $workerShifts[] = explode(",", $shiftTimes[$i]);
}
?>
<!DOCTYPE html>
<html lang ='ja'>
<head>
  <meta charaset = 'UTF-8'>
  <title>シフトが出来上がったよ</title>
  <link rel="stylesheet" href="./stylesheet/host.css">
</head>
<body>
  <h1>完成したシフト表はこちら</h1>
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
              if($j > 0 && $i == 0) {
                echo $times[$j-1];
              } elseif ($j == 0 && $i > 0) {
                echo $weekJpNames[$i-1];
              } else {
                echo '　';
              }

              for($k = 0; $k < $workerMax; $k++) {
                //表示するためにtime配列内のシフトの開始時間と終了時間の添え字を取り出す
                for($l = 0; $l <= $hours; $l++) {
                  if($times[$l] == $workerShifts[$k][1]) {
                    $startTime = $l;
                  }
                  if($times[$l] == $workerShifts[$k][2]) {
                    $endTime = $l;
                  }
                }
                //時間表示の１行目に書き込まれないようにする
                if($i > 0 && $j - 1 >= $startTime && $j - 1 <= $endTime && $workerShifts[$k][3][$i-1] == 1) {
                  echo "<img src='{$workerIcons[$workerShifts[$k][0]]}'>\n";
                }
              }
            ?>
          </td>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>
</html>
