<?php
$times = array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 1, 2, 3, 4, 5);
//表に表示する曜日
$weekJpNames = array("月", "火", "水", "木", "金", "土", "日");

$shiftDatPath = "./data/shift.dat";
$workerDatPath = "./data/worker.dat";

$hours = 24;
$oneWeekDays = 7;

//新規の従業員登録のための情報が入力されてるか判定
if(isset($_POST["newWorker"]) && !(empty($_POST["newWorker"])) && !(empty($_FILES["upfile"]["name"]))) {

  $newWorker = $_POST["newWorker"];
  //画像ファイルをアップロード
  if(is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
    if(move_uploaded_file($_FILES["upfile"]["tmp_name"],"./workericons/".$_FILES["upfile"]["name"])) {


      chmod("./workericons/".$_FILES["upfile"]["name"],0644);
      echo $_FILES["upfile"]["name"]."をアップロードしました。";
      

    } else {
      echo "ファイルをアップロードできません。";
    }
  } else {
    echo "ファイルが選択されていません。";
  }

  //登録した画像ファイルの変数を定義
  $upfile =$_FILES["upfile"]["name"];
  //投稿された名前と画像ファイルを従業員管理ファイルに書き込むための指定
  $workerIcons = $newWorker.",".$upfile;

  //新規従業員を従業員管理ファイルに書き込む
  if(is_writable($workerDatPath) === false) {
    echo "not writable";
    exit;
  }
  $filePointer = fopen($workerDatPath, "a");
  if($filePointer == false) {
    echo "could not open";
    exit;
  }
  if(fwrite($filePointer, $workerIcons."\n") === false) {
    echo "could not write";
    exit;
  }
  fclose($filePointer);
}
//従業員管理ファイルを読み込む
$workerData = file($workerDatPath);
$newWorkerMax = count($workerData);

//従業員管理ファイルを配列化
for($i = 0; $i < $newWorkerMax; $i++) {
  //$workerIcons[][0]登録した従業員の名前
  //$workerIcons[][1]登録した従業員の画像
  $workerIcons[] = explode(",", $workerData[$i]);
}

//従業員シフト情報ファイルを読み込む
$shiftTimes = file($shiftDatPath);
$workerMax = count($shiftTimes);
$workerName = $_POST["workerName"];

//指定した従業員のシフト情報をファイルにから削除
for($i = 0; $i < $workerMax; $i++) {
  if(strpos($shiftTimes[$i], $workerName) !== false) {
    unset($shiftTimes[$i]);
  }
}
//削除した配列を詰める
$shiftTimes = array_merge($shiftTimes);

//変更された、従業員シフト情報ファイルを配列化
$workerMax = count($shiftTimes);
for($i = 0; $i < $workerMax; $i++) {
  //$workerShifts[][0]名前
  //$workerShifts[][1]開始時間
  //$workerShifts[][2]終了時間
  //$workerShifts[][3]曜日
  $workerShifts[] = explode(",", $shiftTimes[$i]);
}

//従業員情報を管理するファイルを、空にして書き直す
if(is_writable($shiftDatPath)  === false) {
  echo "not writable";
  exit;
}
$filePointer = fopen($shiftDatPath, "w");
if($filePointer === false) {
  echo "could not open";
  exit;
}
//配列を１行づつ書き込む
for($i = 0; $i < $workerMax; $i++ ) {
  if(fwrite($filePointer, $shiftTimes[$i]) === false) {
    echo "could not write";
    exit;
  }
}
fclose($filePointer);

?>

<!DOCTYPE html>
<html lang ='ja'>
<head>
  <meta charaset = 'UTF-8'>
  <title>シフトを確認して調整しましょう</title>
  <link rel="stylesheet" href="./stylesheet/style.css">
</head>
<body>
  <h1>シフトのチェックができます</h1>
  <table>
    <?php
    //週の曜日の７行+時間帯の表示の１行を表示させるため<=条件式とする
      for($i = 0; $i <= $oneWeekDays; $i++):
        if ($i == 0){
          echo "<thead>";
        } elseif($i == 1){
          echo "<tbody>";
        }
    ?>
      <tr>
        <?php
          //１日24時間分の列+曜日の表示の１列を表示させるため<=条件式とする
          for($j = 0; $j <= $hours; $j++):
        ?>
          <td>
            <?php
              //表に時間と曜日を表示
              if($j > 0 && $i == 0) {
                echo $times[$j-1];
              } elseif ($j == 0 && $i > 0) {
                echo $weekJpNames[$i-1];
              } else {
                echo '　';
              }

              //表示するためにtime配列内のシフトの開始時間と終了時間の添え字を取り出す
              for($k = 0; $k < $workerMax; $k++) {
                for($l = 0; $l <= $hours; $l++) {
                  if($times[$l] == $workerShifts[$k][1]) {
                    $startTime = $l;
                  }
                  if($times[$l] == $workerShifts[$k][2]) {
                    $endTime = $l;
                  }
                }
                //時間表示の１行に書き込まれないようにする
                if($i > 0 && $j - 1 >= $startTime && $j - 1 <= $endTime && $workerShifts[$k][3][$i-1] == 1) {
                  // echo "<img src='{$workerIcons[$workerShihts[$k][0]]}'>\n";
                  for($m = 0; $m < $newWorkerMax; $m++) {
                    if($workerShifts[$k][0] == $workerIcons[$m][0]) {
                      echo "<img src='./workericons/{$workerIcons[$m][1]}'>\n";
                      //echo "<img src='./workericons/{$workerIcons[0][1]}'>";
                    }
                  }
                }
              }
            ?>
          </tb>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
    <?php
      if ($i == 0) {
        echo "</thead>";
      } elseif ($i == $oneWeekDays) {
        echo "</tbody>";
      }
    ?>
  </table>
  <form action='' method='post' enctype="multipart/form-data">
  シフトを変更したい従業員を選択してください
  <br>
  <select name='workerName'>
    <option value="従業員一覧">従業員</option>]

    <?php

    for ($i = 0; $i < $newWorkerMax; $i++){
      echo "<option value='{$workerIcons[$i][0]}'>";
      echo $workerIcons[$i][0];
      echo "</option>";
    }
    ?>



  </select>


  <br>
  <p1><input type='submit' value='シフトを削除する'></p1>
  <br>
  <br>
  追加したい従業員を登録できます。
  <br>
  <p2><input type='text' value='ここに名前を入力' name='newWorker'></p2>
  <p3><input type="file" name="upfile"><p3>
  <br>
  <p4><input type='submit' value='登録する'></p4>
</form>

</body>
</html>
