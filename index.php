<?php
	session_start();
	if(isset($_SESSION['userGeekhavenLoggedIn']) && ($_SESSION['userGeekhavenLoggedIn'] == true) && isset($_SESSION['securityKey']) && ($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {

		header("Location: dashboard.php");
	}
  else if(isset($_SESSION['adminGeekhavenLoggedIn']) && ($_SESSION['adminGeekhavenLoggedIn'] == true) && isset($_SESSION['securityKey']) && ($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    
    header("Location: admin/");
  }
    require_once('includes/gmail-setting.php');
    $login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Geekhaven | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="static/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Geekhaven</b> Portal
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
    	if(isset($_SESSION['errorMsg'])) {
            echo('<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> '.$_SESSION['errorMsg'].'
                </div>');
            unset($_SESSION['errorMsg']);
        }
        else if(isset($_SESSION['successMsg'])) {
            echo('<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> '.$_SESSION['successMsg'].'
                </div>');
            unset($_SESSION['successMsg']);
        }
    ?>


        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#userLogin" data-toggle="tab">User Login</a></li>
              <li><a href="#adminLogin" data-toggle="tab">Admin Login</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="userLogin">
                <form action="includes/login.php" method="post">
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row text-center">
                    <div class="col-xs-4">
                    </div>
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat" name="userLoginGeekhaven">Sign In</button>
                    </div>
                    <div class="col-xs-4"></div>
                    <!-- /.col -->
                  </div>
                </form>
                <div class="social-auth-links text-center">
                  <p>- OR -</p>
                  <a href="<?php echo $login_url; ?>" target="_self">
                    <button class="loginBtn loginBtn--google">
                      Login with Google
                    </button>
                  </a>
                </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="adminLogin">
                <form action="includes/login.php" method="post">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username" name="adminUsername" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="adminPassword" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row text-center">
                    <div class="col-xs-4">
                    </div>
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat" name="adminLoginGeekhaven">Sign In</button>
                    </div>
                    <div class="col-xs-4"></div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>  
    <!-- <form action="includes/login.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row text-center">
        <div class="col-xs-4">
          <a href="admin/"> Admin Login</a>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="loginGeekhaven">Sign In</button>
        </div>
        <div class="col-xs-4"></div>
      </div>
    </form> -->

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="</?php echo $login_url; ?>" target="_self">
        <button class="loginBtn loginBtn--google">
          Login with Google
        </button>
      </a>
    </div> -->
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  // $(function () {
  //   $('input').iCheck({
  //     checkboxClass: 'icheckbox_square-blue',
  //     radioClass: 'iradio_square-blue',
  //     increaseArea: '20%' /* optional */
  //   });
  // });
</script>
</body>
</html>
