<?php
session_start();
if(!empty($_SESSION)){ 
  header('Location: index.php');
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CentroColor Web </title>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo-icon.png">
    <link href="assets/css/login.css" rel="stylesheet" />
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body class="">
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="assets/img/logo-login.png" id="icon" alt="User Icon" />
    </div>
    <br/>
    <!-- Login Form -->
    <form id="formLogin" method="POST">
      <input type="email" id="email" class="fadeIn second" name="email" placeholder="correo">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña">
      <button name="login" id="login" class="btn btn-info fadeIn fourth">Ingresar</button>
      <input type="hidden" name="MM_insert" value="form" />
    </form>
    <br/>

    <div class="alert alert1 alert-danger alert-dismissible fade show" style="display:none;" role="alert">
        El usuario o la contraseña son incorrecto.
    </div>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">¿Olvidaste tu contraseña?</a>
    </div>

  </div>
</div>

  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {

    $("#login").click(function(){
      $.ajax({ 
          type:"POST",
          url: "session/login.php",
          data:$('#formLogin').serialize(),
          success: function(respuesta){
            console.log(respuesta);
              if(respuesta==1){
                
                   window.location.href = "index.php";

              } else if(respuesta==2){

                  $(".alert1").fadeTo(1000,0.9);

              }        
          }
      })
        return false
    })

    $( "#password" ).hover(function() {
      $(".alert1").fadeOut(1000);
    });

  })

  </script>

 
</body>
</html>