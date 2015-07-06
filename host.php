<?php
$weekJpNames   = array("月", "火", "水", "木", "金", "土", "日");
$times         = array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 1, 2, 3, 4, 5);
$shiftDatPath  = "./data/shift.dat";
$workerDatPath = "./data/worker.dat";
$hours         = 24;
$oneWeekDays   = 7;


$shiftTimes = file($shiftDatPath);
$workerMax  = count($shiftTimes);
for($i = 0; $i < $workerMax; $i++) {
  //$workerShifts[][0]名前
  //$workerShifts[][1]開始時間
  //$workerShifts[][2]終了時間
  //$workerShifts[][3]曜日
  $workerShifts[] = explode(",", $shiftTimes[$i]);
}

//従業員管理ファイルを読み込む
$workerData   = file($workerDatPath);
$newWorkerMax = count($workerData);
//従業員管理ファイルを配列化
$workerIcons = ["workerName" => "workerIcon"];
for($i = 0; $i < $newWorkerMax; $i++) {
  //$workerIcons[][0]登録した従業員の名前
  //$workerIcons[][1]登録した従業員の画像
  $workerIcon[] = explode(",", $workerData[$i]);
  $workerIcons += [$workerIcon[$i][0] => $workerIcon[$i][1]];
}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
  <meta charaset='UTF-8'>
  <title>シフトが出来上がったよ</title>
  <link rel="stylesheet" href="./stylesheet/style.css">
</head>
<body>
  <h1>完成したシフト表はこちら</h1>
  <table>
    <?php
    //週の曜日の７行+時間帯の表示の１行を表示させるため<=条件式とする
    for($i = 0; $i <= $oneWeekDays; $i++):
      //ここも3項演算子
      ($i == 0) ? print "<thead>" : print "<tbody>";
    ?>
      <tr>
        <?php
        //１日24時間分の列+曜日の表示の１列を表示させるため<=条件式とする
        for($j = 0; $j <= $hours; $j++):
        ?>
          <td>
            <?php
            //表に曜日と時間を表示
            if($i == 0 && $j > 0) {
              echo $times[$j-1];
            } elseif ($i > 0 && $j == 0) {
              echo $weekJpNames[$i-1];
            } else {
              echo '　';
            }

            for($k = 0; $k < $workerMax; $k++) {
              //表示するためにtime配列内のシフトの開始時間と終了時間の添え字を取り出す
              for($l = 0; $l <= $hours; $l++) {
                if($workerShifts[$k][1] == $times[$l]) {
                  $startTime = $l;
                }
                if($workerShifts[$k][2] == $times[$l]) {
                  $endTime = $l;
                }
              }

              if($i > 0 && $workerShifts[$k][3][$i-1] == 1 && $j - 1 >= $startTime && $j - 1 <= $endTime) {
                echo "<img src='./pictures/".$workerIcons[$workerShifts[$k][0]]."'>\n";
              }
            }
            ?>
          </td>
        <?php endfor; ?>
      </tr>
      <?php
      ($i == 0) ? print "</thead>" : "</tbody>";
      ?>
    <?php endfor; ?>
  </table>
  <br>
  <a href="shift.php">シフト登録はこちら</a>
  <a href="owner.php">シフトを修正はこちら</a>
  <br><br><br>
</body>
</html>
