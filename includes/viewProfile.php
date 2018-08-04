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


    if(isset($_GET['rollNum'])) {
      $rollNum = $_GET['rollNum'];
      $stmt = $conn->prepare("SELECT * FROM users WHERE rollNum=?");
      $stmt->bind_param("s", $rollNum);
      $stmt->execute();
      $viewUser = $stmt->get_result()->fetch_assoc();
      $stmt->close();

      if(!$viewUser) {
        header("Location: 404.php");
      }

      $stmt = $conn->prepare("SELECT ((100.0*sum(grade))/count(grade))/100.0 as aggregate from attendance where rollNum=?");
      $stmt->bind_param("s", $_GET['rollNum']);
      $stmt->execute();
      $grade = $stmt->get_result()->fetch_assoc();
      $stmt->close();

    } else {
      header("Location: 404.php");
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Geekhaven | View Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" >
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
        <li>
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
        View Profile - <?php echo strtoupper($rollNum); ?>
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
    ?>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $user['image']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $viewUser['first_name']." ".$viewUser['last_name']; ?> 
              </h3>

              <p class="text-muted text-center"><b>Roll No.</b> <?php echo strtoupper($viewUser['rollNum']); ?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About &nbsp;<i><?php echo strtoupper($viewUser['rollNum']); ?></i></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Bio</strong>
              <?php
                if($viewUser['bio'] != "") {
                  echo "<p>".$viewUser['bio']."</p>";
                } else {
                  echo "<p class='text-muted'>
                    None
                  </p>";
                }
              ?>

              <hr>

              <strong><i class="fa fa-book margin-r-5"></i> Experience</strong>
              <?php
                if($viewUser['experience'] != "") {

                  $label = ['danger', 'success', 'info', 'warning', 'primary'];

                  $experiences = explode(",", $viewUser['experience']);
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
                if($viewUser['skills'] != "") {
                  $label = ['info', 'warning', 'primary', 'danger', 'success'];

                  $skills = explode(",", $viewUser['skills']);
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
                echo "<p>";
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
                echo "</p>";
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-8">
          <?php
            $wingColor = array();
            $wingColor["Software Development"] = "label-success";
            $wingColor["App Development"] = "label-info";
            $wingColor["Web Development"] = "label-primary";
            $wingColor["FOSS"] = "label-warning";
            $wingColor["Blockchain"] = "label-danger";
            $wingColor["Artificial Intelligence"] = "label-default";
            $wingColor["Competitive Coding"] = "label-success disabled";
            $wingColor["Cyber Security"] = "label-danger disabled";

            $rollNum = $user['rollNum'];
            $stmt = $conn->prepare("SELECT * from attendance WHERE rollNum=?");
            $stmt->bind_param("s", $_GET['rollNum']);
            $stmt->execute();
            $result = $stmt->get_result();
          ?>
          <div class="row">
            <div class="col-xs-12" id="eventsAttended">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Events Attended</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Event Name</th>
                      <th>Wing Name</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Grade</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($result) {
                          while($a = $result->fetch_assoc()) {

                            $eventID = $a['eventID'];
                            $stm = $conn->prepare("SELECT * from events WHERE id=?");
                            $stm->bind_param("s", $eventID);
                            $stm->execute();
                            $event = $stm->get_result()->fetch_assoc();

                            $st = $conn->prepare("SELECT * from wings WHERE id=?");
                            $st->bind_param("s", $event['conductedBy']);
                            $st->execute();
                            $wing = $st->get_result()->fetch_assoc();

                            echo("<tr>
                              <td><a href='includes/eventDetails.php?eventID=".$event['id']."'>".$event['eventName']."</td>
                              <td><span class='label ".$wingColor[$wing['name']]."'>".$wing['name']."</span></td>
                              <td>".$event['startDate']."</td>
                              <td>".$event['endDate']."</td>");

                            if($a['grade'] == 10.0) {
                              echo "<td><span class='label label-success'>".$a['grade']."</span></td></tr>";
                            }
                            else if(($a['grade'] < 10.0) && $a['grade'] >= 9.0) {
                              echo "<td><span class='label label-info'>".$a['grade']."</span></td></tr>";
                            }
                            else if(($a['grade'] < 9.0) && $a['grade'] >= 8.0) {
                              echo "<td><span class='label label-primary'>".$a['grade']."</span></td></tr>";
                            }
                            else if(($a['grade'] < 8.0) && $a['grade'] >= 7.0) {
                              echo "<td><span class='label label-default'>".$a['grade']."</span></td></tr>";
                            }
                            else if(($a['grade'] < 7.0) && $a['grade'] >= 6.0) {
                              echo "<td><span class='label label-warning'>".$a['grade']."</span></td></tr>";
                            }
                            else if(($a['grade'] < 6.0) && $a['grade'] >= 5.0) {
                              echo "<td><span class='label label-danger'>".$a['grade']."</span></td></tr>";
                            }
                          }
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <?php
            $stmt->close();
          ?>
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
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
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
        $('#example1').DataTable({
          "order": []
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