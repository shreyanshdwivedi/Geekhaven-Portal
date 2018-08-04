<?php
  ob_start();
  session_start();
  if(!isset($_SESSION['userGeekhavenLoggedIn']) or !($_SESSION['userGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    $_SESSION['errorMsg'] = "Please login first";
    header("Location: ../index.php");
  } else {
    $conn = new mysqli("localhost", "root", "", "geekhaven");
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("s", $_SESSION['userID']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Geekhaven | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
      form .error {
        color: #ff0000;
      }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="../images/geekhavenlogo.svg" height="50px" width="50px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Geekhaven</b> Portal</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <?php
              if(isset($_SESSION['userGeekhavenLoggedIn']) && ($_SESSION['userGeekhavenLoggedIn'] == true)) {
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $user['image']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['name']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $user['image']; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['name']; ?>
                  <small>Member since <?php echo $user['createdAt']; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
            <?php
              } 
            ?>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $user['image']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['name']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="post" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search by Roll Number">
          <span class="input-group-btn">
                <button type="submit" name="searchByRoll" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="../dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="calendar.php">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
          </a>
        </li>
        <li class="active">
          <a href="profile.php">
            <i class="fa fa-user"></i> <span>Profile</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

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

        $stmt = $conn->prepare("SELECT ((100.0*sum(grade))/count(grade))/100.0 as aggregate from attendance where rollNum=?");
        $stmt->bind_param("s", $user['rollNum']);
        $stmt->execute();
        $grade = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    ?>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $user['image']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $user['first_name']." ".$user['last_name']; ?>
                
              </h3>

              <p class="text-muted text-center"><b>Roll No.</b> <?php echo $user['rollNum']; ?></p>

              <!-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul> -->

              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Bio</strong>
              <?php
                if($user['bio'] != "") {
                  echo "<p>".$user['bio']."</p>";
                } else {
                  echo "<p class='text-muted'>
                    None
                  </p>";
                }
              ?>

              <hr>

              <strong><i class="fa fa-book margin-r-5"></i> Experience</strong>
              <?php
                if($user['experience'] != "") {

                  $label = ['danger', 'success', 'info', 'warning', 'primary'];

                  $experiences = explode(",", $user['experience']);
                  echo "<p>";
                  $i = 0;
                  foreach ($experiences as $key => $value) {
                    echo "<span class='label label-".$label[$i]."'>".$value."</span> ";
                    $i += 1;
                    if($i == 5) {
                      $i = 0;
                    }
                  }
                  echo "</p>";

                } else {
              ?>
              <p class="text-muted">
                None
              </p>
              <?php
                }
              ?>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <?php
                if($user['skills'] != "") {
                  $label = ['info', 'warning', 'primary', 'danger', 'success'];

                  $skills = explode(",", $user['skills']);
                  echo "<p>";
                  $i = 0;
                  foreach ($skills as $key => $value) {
                    echo "<span class='label label-".$label[$i]."'>".$value."</span> ";
                    $i += 1;
                    if($i == 5) {
                      $i = 0;
                    }
                  }
                  echo "</p>";

                } else {
              ?>
              <p class="text-muted">
                None
              </p>
              <?php
                }
              ?>

              <hr>

              <strong><i class="fa fa-percent margin-r-5"></i> Aggregate</strong>
              <?php
                echo ("<p>");
                if($grade['aggregate'] == 10.0) {
                  echo "<span class='label label-success'>".$grade['aggregate']."</span>";
                }
                else if(($grade['aggregate'] < 10.0) && $grade['aggregate'] >= 9.0) {
                  echo "<span class='label label-info'>".$grade['aggregate']."</span>";
                }
                else if(($grade['aggregate'] < 9.0) && $grade['aggregate'] >= 8.0) {
                  echo "<span class='label label-primary'>".$grade['aggregate']."</span>";
                }
                else if(($grade['aggregate'] < 8.0) && $grade['aggregate'] >= 7.0) {
                  echo "<span class='label label-default'>".$grade['aggregate']."</span>";
                }
                else if(($grade['aggregate'] < 7.0) && $grade['aggregate'] >= 6.0) {
                  echo "<span class='label label-warning'>".$grade['aggregate']."</span>";
                }
                else if(($grade['aggregate'] < 6.0) && $grade['aggregate'] >= 5.0) {
                  echo "<span class='label label-danger'>".$grade['aggregate']."</span>";
                }
                echo("</p>");
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
              <li><a href="#changePassword" data-toggle="tab">Change Password</a></li>
              <li><a href="#changeImage" data-toggle="tab">Update Profile Pic</a></li>
            </ul>
            <div class="tab-content">

              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post" action="updateProfile.php">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name" readonly="true" value="<?php echo $user['first_name'].' '.$user['last_name']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" readonly="true" value="<?php echo $user['email']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputNumber" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="inputNumber" placeholder="Phone Number" value="<?php echo $user['phoneNum']; ?>" name="phoneNum">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputBio" class="col-sm-2 control-label">Bio</label>

                    <div class="col-sm-10">
                      <textarea rows="2" class="form-control" id="inputBio" placeholder="Bio(max. 200 characters)" style="resize: none;" name="bio"><?php if($user['bio'] != ""){echo $user['bio'];} ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea rows="3" class="form-control" id="inputExperience" placeholder="Experience(separated by comma) e.g. Head at IIIC, Overall at Geekhaven" style="resize: none;" name="experience"><?php if($user['experience'] != ""){echo $user['experience'];} ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <textarea rows="3" class="form-control" id="inputSkills" placeholder="Skills(separated by comma) e.g. PHP, Django" style="resize: none;" name="skills"><?php if($user['skills'] != ""){echo $user['skills'];} ?></textarea>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger" name="updateProfile">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="changePassword">
                <form class="form-horizontal" method="post" action="updateProfile.php" id="changePass">
                  <div class="form-group">
                    <label for="inputPass" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPass" placeholder="Password" name="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputConfPass" class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputConfPass" placeholder="Confirm Password" name="confirmPass">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger" name="changePassword">Change Password</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="tab-pane" id="changeImage">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo $user['image']; ?>" alt="User profile picture">
                <form method="post" action="updateProfile.php">
                  <input type="file" name="image">
                  <button type="submit" class="btn btn-danger" name="changeImage">Update Image</button>
                </form>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script>
        $(function () {
                // Initialize form validation on the registration form.
                // It has the name attribute "registration"
                $("#changePass").validate({
                    // Specify validation rules
                    rules: {
                        password: {
                            required: true,
                            minlength: 5
                        },
                        confirmPass: {
                            equalTo: "#inputPass"
                        }
                    },
                    // Specify validation error messages
                    messages: {
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        }
                    },
                        // Make sure the form is submitted to the destination defined
                        // in the "action" attribute of the form when valid
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>
</body>
</html>

<?php
 
  if(isset($_POST['searchByRoll']))
  {
    $rollNum = $_POST['q'];
    header("Location: http://localhost/desktop/Geekhaven-Portal/includes/viewProfile.php?rollNum=".$rollNum);
  }
  else
  {
    echo "Hello";
  }

?>