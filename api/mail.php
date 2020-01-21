<?php
session_start();

if(!isset($_SESSION["username"])){
  echo "expired";
  exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset( $_POST['message']))
$message = $_POST['message'];
if(isset( $_POST['subject']))
$subject = $_POST['subject'];

if(trim($subject) == "" || trim($message) == ""){
  echo "missingValues";
  exit;
}

$username = trim($_SESSION["username"]);

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = "smtp-project2-group4.alwaysdata.net";
$mail->Port = "587"; // typically 587
$mail->SMTPSecure = 'tls'; // ssl is depracated
$mail->SMTPAuth = true;
$mail->Username = "project2-group4@alwaysdata.net";
$mail->Password = "kopa9703";
$mail->setFrom("project2-group4@alwaysdata.net", "Eksoteriko Sistima");
$mail->addAddress("it21637@hua.gr", "Kostas");
$mail->Subject = $subject;
$mail->msgHTML($message); // remove if you do not want to send HTML email
$mail->AltBody = 'HTML not supported';
//$mail->addAttachment('docs/brochure.pdf'); //Attachment, can be skipped

if(!$mail->send())
{
    echo "0";
}
else
{
    echo "1";
}
?>
