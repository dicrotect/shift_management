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

//新規の従業員登録のための情報が入力されてるか判定
if(isset($_POST["newWorker"]) && !(empty($_POST["newWorker"])) && !(empty($_FILES["upfile"]["name"]))) {
  $newWorker = $_POST["newWorker"];
  //画像ファイルをアップロード
  if(is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
    if(move_uploaded_file($_FILES["upfile"]["tmp_name"], "./pictures/".$_FILES["upfile"]["name"])) {
      chmod("./pictures/".$_FILES["upfile"]["name"], 0750);
      echo $_FILES["upfile"]["name"]."をアップロードしました。";
    } else {
      echo "ファイルをアップロードできません。";
      exit;
    }
  } else {
    echo "ファイルが選択されていません。";
    exit;
  }

  //登録した画像ファイルの変数を定義
  $upfile = $_FILES["upfile"]["name"];
  //投稿された名前と画像ファイルを従業員管理ファイルに書き込むための指定
  $workerIcon = $newWorker.",".$upfile;

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

  if(fwrite($filePointer, $workerIcon."\n") === false) {
    echo "could not write";
    exit;
  }

  fclose($filePointer);
}

if(isset($_POST["workerName"]) && !(empty($_POST["workerName"]))) {
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
  if(is_writable($shiftDatPath) === false) {
    echo "not writable";
    exit;
  }

  $filePointer = fopen($shiftDatPath, "w");
  if($filePointer === false) {
    echo "could not open";
    exit;
  }
  //配列を１行づつ書き込む
  for($i = 0; $i < $workerMax; $i++) {
    if(fwrite($filePointer, $shiftTimes[$i]) === false) {
      echo "could not write";
      exit;
    }
  }
  fclose($filePointer);
}
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
            //表に時間と曜日を表示
            if($i == 0 && $j > 0) {
              echo $times[$j-1];
            } elseif ($i > 0 && $j == 0) {
              echo $weekJpNames[$i-1];
            } else {
              echo '　';
            }

            //表示するためにtime配列内のシフトの開始時間と終了時間の添え字を取り出す
            for($k = 0; $k < $workerMax; $k++) {
              for($l = 0; $l < $hours; $l++) {
                if($workerShifts[$k][1] == $times[$l]) {
                  $startTime = $l;
                }
                if($workerShifts[$k][2] == $times[$l]) {
                  $endTime = $l;
                }
              }
              //時間表示の１行に書き込まれないようにする
              if($i > 0 && $workerShifts[$k][3][$i-1] == 1 && $j - 1 >= $startTime && $j - 1 <= $endTime) {
                echo "<img src='./pictures/".$workerIcons[$workerShifts[$k][0]]."'>\n";
              }
            }
            ?>
          </tb>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
    <?php
    //閉じタグも3項演算子
    ($i == 0) ? print "</thead>" : "</tbody>";
    ?>
  </table>
  <form action='' method='post' enctype="multipart/form-data">
    シフトを変更したい従業員を選択してください。
    <div>
      <select name='workerName'>
        <option value="従業員一覧">従業員</option>
        <?php
        // for($i = 0; $i < $workerMax; $i++) {
        //   echo "<option value='{$workerIcons[$workerShifts[$i][0]]}'>".$workerIcons[$workerShifts[$i][0]]."</option>";
        // }
        for($i = 0; $i < $newWorkerMax; $i++) {
          echo "<option value='{$workerIcon[$i][0]}'>".$workerIcon[$i][0]."</option>";
        }

        ?>
      </select>
      <p><input type='submit' value='シフトをリセットする'></p>
    </div>
    追加したい従業員を登録できます。
    <br>
    <p>
    名前
    <input type='text' value='' name='newWorker'>
    <input type="file" name="upfile">
    </p>
    <p><input type='submit' value='登録する'></p>
    <br>
    <a href="host.php">完成したシフトはこちら</a>
    <a href="shift.php">シフト登録はこちら</a>
  </form>
  <br>
  </body>
</html>
