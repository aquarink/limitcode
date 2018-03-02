<!DOCTYPE html> 

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Signup</title>

  <meta name="description" content="">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="apple-touch-icon" href="<?php echo base_url(); ?>layout/elephant/apple-touch-icon.png">

  <link rel="icon" href="favicon.ico">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/vendor.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/elephant.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/application.min.css">



  <link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/signup-3.min.css">



  <script>

    function captca() {

      var c = document.getElementById("myCanvas");

      var ctx = c.getContext("2d");

      ctx.font = "15px Arial";

      ctx.fillText('<?php echo strtolower($cWord); ?>',10,20);



      document.getElementById("myCaptca").value = "<?php echo strtolower($cWord); ?>";

    }

  </script>

  <script async src="http://www.googletagmanager.com/gtag/js?id=UA-112616852-1"></script>

  <script>

    window.dataLayer = window.dataLayer || [];

    function gtag(){dataLayer.push(arguments);}

    gtag('js', new Date());



    gtag('config', 'UA-112616852-1');

  </script>



<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7268142918614748",
    enable_page_level_ads: true
  });
</script
</head>

<body class="layout" onload="captca()">

  <div class="signup">

    <div class="signup-body">

      <a class="signup-brand" href="<?php echo base_url(); ?>">

        <img class="img-responsive" src="<?php echo base_url(); ?>layout/img/logo-lc-account.jpg" alt="Limit Code">

      </a>

      <p class="signup-heading">

        <em>Get started with a free account.</em>

      </p>

      <h3 class="signup-heading">Sign up</h3>

      <div class="signup-form">

        <form data-toggle="md-validator" data-groups='{"birthdate": "birth_month birth_day birth_year"}' method="POST" action="">

          <div class="row">

            <div class="col-sm-6">

              <div class="md-form-group md-label-floating">

                <input class="md-form-control" type="text" name="first_name" spellcheck="false" data-msg-required="Please enter your first name." required>

                <label class="md-control-label">First name</label>

              </div>

            </div>

            <div class="col-sm-6">

              <div class="md-form-group md-label-floating">

                <input class="md-form-control" type="text" name="last_name" spellcheck="false" data-msg-required="Please enter your last name." required>

                <label class="md-control-label">Last name</label>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-sm-12">

              <div class="md-form-group md-label-floating">

                <input class="md-form-control" type="email" name="email" spellcheck="false" autocomplete="off" data-msg-required="Please enter your email address." required>

                <label class="md-control-label">Email</label>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-sm-12">

              <div class="md-form-group md-label-floating">

                <input id="pass" class="md-form-control" type="password" name="password" minlength="6" data-msg-minlength="Password must be 6 characters or more." data-msg-required="Please enter your password." required>

                <label class="md-control-label">Password</label>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-sm-12">

              <div class="md-form-group md-label-floating">

                <input id="repass" class="md-form-control" type="password" name="repassword" minlength="6" data-msg-minlength="Password must be 6 characters or more." data-msg-required="Please enter your password." required>

                <div id="warning" style="color: red">Password Not Match</div>

                <label class="md-control-label">Re Password</label>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-xs-12">

              <div class="md-form-group">

                <div class="row">

                  <div class="col-xs-6">

                    <div class="md-form-group">

                      <select class="md-form-control" name="birth_month" data-msg-required="Please enter your birthday." required>

                        <option value="" disabled="disabled" selected="selected">Birth Month</option>

                        <option value="01">January</option>

                        <option value="02">February</option>

                        <option value="03">March</option>

                        <option value="04">April</option>

                        <option value="05">May</option>

                        <option value="06">June</option>

                        <option value="07">July</option>

                        <option value="08">August</option>

                        <option value="09">September</option>

                        <option value="10">October</option>

                        <option value="11">November</option>

                        <option value="12">December</option>

                      </select>

                      <label class="md-control-label"></label>

                    </div>

                  </div>

                  <div class="col-xs-3">

                    <div class="md-form-group">

                      <select class="md-form-control" name="birth_day" data-msg-required="Please enter your birthday." required>

                        <option value="" selected="selected" disabled="disabled">Day</option>

                        <?php for($i=1; $i < 31; $i++) { 

                          echo '<option value='.$i.'>'.$i.'</option>';

                        } ?>

                      </select>

                      <label class="md-control-label"></label>

                    </div>

                  </div>

                  <div class="col-xs-3">

                    <div class="md-form-group">

                      <select class="md-form-control" name="birth_year" data-msg-required="Please enter your birthday." required>

                        <option value="" selected="selected" disabled="disabled">Year</option>

                        <?php for($i=1950; $i < date('Y'); $i++) { 

                          echo '<option value='.$i.'>'.$i.'</option>';

                        } ?>

                      </select>

                      <label class="md-control-label"></label>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-xs-12">

              <div class="md-form-group">

                <select class="md-form-control" name="gender" data-msg-required="Please indicate your gender." required>

                  <option value="" disabled="disabled" selected="selected">Gender</option>

                  <option value="male">Male</option>

                  <option value="female">Female</option>

                </select>

                <label class="md-control-label"></label>

              </div>

            </div>

          </div>



          Input captcha : <canvas id="myCanvas" width="100" height="30"></canvas>



          <div class="row">

            <div class="col-sm-12">

              <div class="md-form-group md-label-floating">

                <input class="md-form-control" type="text" name="captcaInput" spellcheck="false" autocomplete="off" data-msg-required="Please enter the capthca." required>

                <input id="myCaptca" type="hidden" name="captcaOriginal">

                <label class="md-control-label">Captcha</label>

              </div>

            </div>

          </div>



          <button id="signupbtn" name="submit" value="signup" class="btn btn-danger btn-block" type="submit">Sign up</button>

          <div class="divider">

            <div class="divider-content">OR</div>

          </div>

          <a href="<?php echo $signinFacebook; ?>" class="btn btn-info btn-block" type="submit"><span class="icon icon-facebook-official"></span> Sign up with Facebook</a>

        </form>

      </div>

    </div>

    <div class="signup-footer">

      Already have an account? <a href="<?php echo base_url(); ?>index.php/signin">Sign In</a>

    </div>

  </div>



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



  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



  <script src="<?php echo base_url(); ?>layout/elephant/js/vendor.min.js"></script>

  <script src="<?php echo base_url(); ?>layout/elephant/js/elephant.min.js"></script>

  <script src="<?php echo base_url(); ?>layout/elephant/js/application.min.js"></script>

  <script type="text/javascript">

    $('#signupbtn').prop("disabled", true);
    $('#warning').hide();

    $("#repass").keyup(function(){

        var pass = $("#pass").val();

        var repass = $("#repass").val();


        if(pass !== repass) {

            $('#warning').show();
            $("#signupbtn").prop("disabled", true);

        } else {
            $('#warning').hide();
            $("#signupbtn").prop("disabled", false);

        }



    });
  </script>


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