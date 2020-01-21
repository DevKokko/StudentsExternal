<?php
  session_start();

  if(!isset($_SESSION["username"])){
    echo "expired";
    exit;
  }


$username = $_SESSION["username"];

$ip = trim(file_get_contents("../internalip.txt"));
$ch = curl_init("http://$ip:8080/spring-crm-with-security/api/getStatus");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".urlencode(trim($username)));
curl_setopt($ch, CURLOPT_POST, true);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

echo $response;
 ?>
