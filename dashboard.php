<?php
  ob_start();
  session_start();
  if(!isset($_SESSION['userGeekhavenLoggedIn']) or !($_SESSION['userGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    $_SESSION['errorMsg'] = "Please login first";
    header("Location: index.php");
  } else {
    $conn = new mysqli("localhost", "root", "", "geekhaven");
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("s", $_SESSION['userID']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $rollNum = $user['rollNum'];
    $stmt = $conn->prepare("SELECT * from attendance WHERE rollNum=?");
    $stmt->bind_param("s", $rollNum);
    $stmt->execute();
    $stmt->store_result();
    $attended = $stmt->num_rows;
    $stmt->close();

    $date = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("SELECT id from events WHERE startDate >= ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $stmt->store_result();
    $upcoming = $stmt->num_rows;
    $stmt->close();

    $stmt = $conn->prepare("SELECT id from events WHERE startDate < ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $stmt->store_result();
    $past = $stmt->num_rows;
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM reviews WHERE userID=?");  
    $stmt->bind_param("s", $_SESSION['userID']);
    $stmt->execute();
    $stmt->store_result();
    $numReviews = $stmt->num_rows;
    $stmt->close();

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Geekhaven</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" >
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="static/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="images/geekhavenlogo.svg" height="50px" width="50px"></span>
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
                  <a href="includes/profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="includes/logout.php" class="btn btn-default btn-flat">Sign out</a>
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
        <li class="active">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="includes/calendar.php">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
          </a>
        </li>
        <li>
          <a href="includes/profile.php">
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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $attended; ?></h3>

              <p>Events Attended</p>
            </div>
            <div class="icon">
              <i class="ion ion-pin"></i>
            </div>
            <a href="#eventsAttended" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $upcoming; ?></h3>

              <p>Upcoming Events</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#eventsUpcoming" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $past; ?></h3>

              <p>Past Events</p>
            </div>
            <div class="icon">
              <i class="ion ion-cube"></i>
            </div>
            <a href="#eventsPast" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $numReviews; ?></h3>

              <p>Reviews</p>
            </div>
            <div class="icon">
              <i class="ion ion-quote"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-xs-12" id="rank">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Rank List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="rankList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Rank</th>
                  <th>Name</th>
                  <th>Roll Num.</th>
                  <th>Aggregate</th>
                </tr>
                </thead>
                <tbody>
                  <?php

                    $stmt = $conn->prepare("SELECT rollNum, ((100.0*sum(grade))/count(grade))/100.0 as aggregate from attendance group by rollNum order by ((100.0*sum(grade))/count(grade)) DESC");
                    $stmt->execute();
                    $ranks = $stmt->get_result();
                    $stmt->close();

                    if($ranks) {
                      $i = 1;
                      while ($rank = $ranks->fetch_assoc()) {

                        $stmt = $conn->prepare("SELECT * from users where rollNum=?");
                        $stmt->bind_param("s", $rank["rollNum"]);
                        $stmt->execute();
                        $user = $stmt->get_result()->fetch_assoc();
                        $stmt->close();

                        echo("
                          <tr>
                            <td>".$i."</td>
                            <td>".$user['first_name']." ".$user['last_name']."</td>
                            <td>".strtoupper($user['rollNum'])."</td>
                        ");

                        if($rank['aggregate'] == 10.0) {
                          echo "<td><span class='label label-success'>".$rank['aggregate']."</span></td></tr>";
                        }
                        else if(($rank['aggregate'] < 10.0) && $rank['aggregate'] >= 9.0) {
                          echo "<td><span class='label label-info'>".$rank['aggregate']."</span></td></tr>";
                        }
                        else if(($rank['aggregate'] < 9.0) && $rank['aggregate'] >= 8.0) {
                          echo "<td><span class='label label-primary'>".$rank['aggregate']."</span></td></tr>";
                        }
                        else if(($rank['aggregate'] < 8.0) && $rank['aggregate'] >= 7.0) {
                          echo "<td><span class='label label-default'>".$rank['aggregate']."</span></td></tr>";
                        }
                        else if(($rank['aggregate'] < 7.0) && $rank['aggregate'] >= 6.0) {
                          echo "<td><span class='label label-warning'>".$rank['aggregate']."</span></td></tr>";
                        }
                        else if(($rank['aggregate'] < 6.0) && $rank['aggregate'] >= 5.0) {
                          echo "<td><span class='label label-danger'>".$rank['aggregate']."</span></td></tr>";
                        }

                        $i++;
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
            $stmt->bind_param("s", $rollNum);
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
      <!-- /.row -->
      <?php
            $stmt->close();
            $date = date("Y-m-d H:i:s");
            $stmt = $conn->prepare("SELECT * from events WHERE startDate >= ?");
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $events = $stmt->get_result();
      ?>
      <div class="row">
        <div class="col-xs-12" id="eventsUpcoming">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Upcoming Events</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Event Name</th>
                  <th>Wing Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    if($events) {
                      while($event = $events->fetch_assoc()) {

                        $st = $conn->prepare("SELECT * from wings WHERE id=?");
                        $st->bind_param("s", $event['conductedBy']);
                        $st->execute();
                        $wing = $st->get_result()->fetch_assoc();

                        echo("<tr>
                          <td><a href='includes/eventDetails.php?eventID=".$event['id']."'>".$event['eventName']."</td>
                          <td><span class='label ".$wingColor[$wing['name']]."'>".$wing['name']."</span></td>
                          <td>".date('h:i A, dS F Y', strtotime($event['startDate']))."</td>
                          <td>".date('h:i A, dS F Y', strtotime($event['endDate']))."</td>
                        </tr>");
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
      </div>

      <?php
            $stmt->close();
            $date = date("Y-m-d H:i:s");
            $stmt = $conn->prepare("SELECT * from events WHERE startDate <= ?");
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $events = $stmt->get_result();
      ?>

        <!-- /.col -->
      <div class="row">
        <div class="col-xs-12" id="eventsPast">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Past Events</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Event Name</th>
                  <th>Wing Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    if($events) {
                      while($event = $events->fetch_assoc()) {

                        $st = $conn->prepare("SELECT * from wings WHERE id=?");
                        $st->bind_param("s", $event['conductedBy']);
                        $st->execute();
                        $wing = $st->get_result()->fetch_assoc();

                        echo("<tr>
                          <td><a href='includes/eventDetails.php?eventID=".$event['id']."'>".$event['eventName']."</td>
                          <td><span class='label ".$wingColor[$wing['name']]."'>".$wing['name']."</span></td>
                          <td>".$event['startDate']."</td>
                          <td>".$event['endDate']."</td>
                        </tr>");
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
        <?php
            $stmt->close();
        ?>
      </div>
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
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE r demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable({
        "order": []
      });
    $('#example2').DataTable({
        "order": []
      });
    $('#example3').DataTable({
        "order": []
      });
    $('#rankList').DataTable({
        "order": []
      });
  });
  $(document).ready(function() {
    $('a[href*=\\#]').on('click', function(e){
        e.preventDefault();
        $('html, body').animate({
            scrollTop : $(this.hash).offset().top
        }, 500);
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
