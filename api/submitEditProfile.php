<?php

session_start();

if(!isset($_SESSION["username"])){
  echo "0";
  exit;
}
$username = $_SESSION["username"];

$first_name = trim($_POST["first_name"]);
$last_name = trim($_POST["last_name"]);
$phone_number = trim($_POST["phone_number"]);
$password = trim($_POST["password"]);

if($password != ""){
  if(strlen($password) < 6 || !preg_match("/[0-9]/", $password) || !preg_match("/[a-zA-Z]/", $password)){
    echo "password";
    exit;
  }
}

$ip = trim(file_get_contents("../internalip.txt"));
$ch = curl_init("http://$ip:8080/spring-crm-with-security/api/submitEditProfile");

$postfields = "first_name=".urlencode(trim($first_name))."&last_name=";
$postfields .= urlencode(trim($last_name))."&phone_number=".urlencode(trim($phone_number))."&password=";
$postfields .= urlencode(trim($password))."&username=".urlencode(trim($username));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_POST, true);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

echo $response;
 ?>
