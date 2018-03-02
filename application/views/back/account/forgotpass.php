<!DOCTYPE html> 

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Forgot Password</title>

  <meta name="description" content="">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="apple-touch-icon" href="<?php echo base_url(); ?>layout/elephant/apple-touch-icon.png">

  <link rel="icon" href="favicon.ico">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/vendor.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/elephant.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/application.min.css">



  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/login-3.min.css">



  <script>

    function captca() {

      var c = document.getElementById("myCanvas");

      var ctx = c.getContext("2d");

      ctx.font = "15px Arial";

      ctx.fillText('<?php echo strtolower($cWord); ?>',10,20);



      document.getElementById("myCaptca").value = "<?php echo strtolower($cWord); ?>";

    }

  </script>

</head>

<body class="layout" onload="captca()">

  <!-- Modal -->

  <div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog">



      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-body">

          <div class="text-center">

            <h3 class="text-default"><?php if(isset($msg)) { echo $msg; } ?></h3>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>

      </div>



    </div>

  </div>

  <div class="login">

    <div class="login-body">

      <a class="signup-brand" href="<?php echo base_url(); ?>">

        <img class="img-responsive" src="<?php echo base_url(); ?>layout/img/logo-lc-account.jpg" alt="Limit Code">

      </a>

      <div class="login-form">

        <form data-toggle="md-validator" action="" method="post">

          <div class="md-form-group md-label-floating">

            <input class="md-form-control" type="email" name="email" spellcheck="false" autocomplete="off" data-msg-required="Please enter your email address." required>

            <label class="md-control-label">Email address</label>

            <span class="md-help-block">We'll send you an email to reset your password.</span>

          </div>



          Input captcha : <canvas id="myCanvas" width="100" height="30"></canvas>



          <div class="md-form-group md-label-floating">

            <input class="md-form-control" type="text" name="captcaInput" spellcheck="false" autocomplete="off" data-msg-required="Please enter the Captcha." required>

            <input id="myCaptca" type="hidden" name="captcaOriginal">

            <label class="md-control-label">Captcha</label>

          </div>

          <button name="submit" value="resetpass" class="btn btn-warning btn-block" type="submit">Send password reset email</button>

        </form>

      </div>

    </div>

    <div class="login-footer">

      Don't have an account? <a href="signup">Sign Up</a>

    </div>

  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



  <script src="<?php echo base_url(); ?>layout/elephant/js/vendor.min.js"></script>

  <script src="<?php echo base_url(); ?>layout/elephant/js/elephant.min.js"></script>

  <script src="<?php echo base_url(); ?>layout/elephant/js/application.min.js"></script>



  <?php if(isset($msg)):?>

    <?php if(!empty($msg) || $msg != ''):?>

      <script> 

        $('#myModal').modal('show', function () {

          $(".modal-backdrop.in").hide();

        });

      </script>

    <?php endif;?>

  <?php endif;?>

</body>

</html>