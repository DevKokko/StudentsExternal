<?php

$username = $_POST["username"];
$password = $_POST["password"];

if(!isset($username) || trim($username) == ""){
  echo "missingUsername";
  exit;
}
if(!isset($password) || trim($password) == ""){
  echo "missingPassword";
  exit;
}

$post = [
    'username' => trim($username),
    'password' => trim($password)
];

$ip = trim(file_get_contents("../internalip.txt"));
$ch = curl_init("http://$ip:8080/spring-crm-with-security/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".urlencode(trim($username))."&password=".urlencode(trim($password)));
curl_setopt($ch, CURLOPT_POST, true);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

if($response=="1"){
  session_start();
  $_SESSION["username"] = trim($username);
  echo "1";
}
else if($response=="0" || $response=="-1"){
  echo $response;
}
 ?>
