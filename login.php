<?php
  session_start();
  $ip = file_get_contents("internalip.txt");

  if(isset($_SESSION["username"])){
    header("Location: index.php");
  }
 ?>
<html>
  <head>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="dist/css/adminlte.min.css">
  </head>
  <body style="background-color:#cce1ff; height:100%;">
    <?php include("modal.php"); ?>
    <div style="position: fixed; left:50%; top:50%; transform:translate(-50%, -50%);">

      <form action="" method="POST" id="myForm" style="padding: 25px 50px;background-color: white;border-radius: 10px;margin:0 auto;width: 500px;max-width:90%;padding: 25px 50px;box-shadow:2px 2px 8px black;" >
        <div style="text-align:center;margin-bottom:30px;">
          <h2>Login</h2>
        </div>
        <div style="text-align:center;margin-top:20px;">
          <input style="padding: 10px 25px;" type="text" name="username" id="username" placeholder="Enter your username" required><br>
          <input style="margin-top:1em; padding: 10px 25px;" type="password" name="password" id="password" placeholder="Enter your password" required><br>
          <input style="margin-top:1em;" type="submit" class="btn btn-primary" value="Submit">
        </div>
      </form>

      <div style="clear; both;"> </div>

    </div>
    <script>
      document.getElementById("myForm").addEventListener("submit",OnSubmit);

      function OnSubmit(e){
        e.preventDefault();
        var http = new XMLHttpRequest();
        var url = "api/loginUser.php";

        var params = 'username='+encodeURI(document.getElementById("username").value)+'&password='+encodeURI(document.getElementById("password").value);

        http.open('POST', url, true);

        //Send the proper header information along with the request
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //https://stackoverflow.com/questions/25695778/sending-xmlhttprequest-with-formdata

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
              if(http.responseText == "missingUsername"){
                document.getElementById("modal-body").innerHTML = "Please type your username";
                $('#exampleModalCenter').modal('show');
              }
              else if(http.responseText == "missingPassword"){
                document.getElementById("modal-body").innerHTML = "Please type your password";
                $('#exampleModalCenter').modal('show');
              }
              else if(http.responseText == "0"){
                document.getElementById("modal-body").innerHTML = "Wrong credentials";
                $('#exampleModalCenter').modal('show');
              }
              else if(http.responseText == "-1"){
                document.getElementById("modal-body").innerHTML = "Your account is disabled";
                $('#exampleModalCenter').modal('show');
              }
              else if(http.responseText == "1"){
                window.location.href="index.php";
              }
            }
        }
        http.send(params);
      }
    </script>
  </body>
</html>
