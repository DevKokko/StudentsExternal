<?php

session_start();

if(!isset($_SESSION["username"])){
  echo "0";
  exit;
}
$username = $_SESSION["username"];

$studentIncome = $_POST["studentIncome"];
$parents = $_POST["parents"];
$familyIncome = $_POST["familyIncome"];
$siblings = $_POST["siblings"];
$fromAnotherCity = $_POST["fromAnotherCity"];
$years = $_POST["years"];

if(!isset($studentIncome) || trim($studentIncome) == ""){
  echo "missingValues";
  exit;
}
if(!isset($parents) || trim($parents) == ""){
  echo "missingValues";
  exit;
}
if(!isset($familyIncome) || trim($familyIncome) == ""){
  echo "missingValues";
  exit;
}
if(!isset($siblings) || trim($siblings) == ""){
  echo "missingValues";
  exit;
}
if(!isset($fromAnotherCity) || trim($fromAnotherCity) == ""){
  echo "missingValues";
  exit;
}
if(!isset($years) || trim($years) == ""){
  echo "missingValues";
  exit;
}

if($_FILES["fileToUpload"]["name"] == ""){
  echo "missingFiles";
  exit;
}

$target_dir = "files/".$username."/";
$uploadOk = 1;
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$target_file = $target_dir . time() . "." . $imageFileType;
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "large";
    exit;
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
    echo "notallowed";
    exit;
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  exit;
// if everything is ok, try to upload file
} else {
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
      echo "notuploaded";
      exit;
    //    echo "Sorry, there was an error uploading your file.";
    }
}

$ip = trim(file_get_contents("../internalip.txt"));
$ch = curl_init("http://$ip:8080/spring-crm-with-security/api/submitApplication");

$year = date("Y");

$postfields = "username=".urlencode(trim($username))."&studentIncome=";
$postfields .= urlencode(trim($studentIncome))."&parents=".urlencode(trim($parents))."&familyIncome=";
$postfields .= urlencode(trim($familyIncome))."&siblings=".urlencode(trim($siblings))."&fromAnotherCity=";
$postfields .= urlencode(trim($fromAnotherCity))."&years=".urlencode(trim($years))."&year=".urlencode(trim($year))."&fileUrl=".urlencode(trim($target_file));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_POST, true);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

echo $response;
 ?>
