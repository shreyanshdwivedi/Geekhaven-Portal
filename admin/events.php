<?php
  session_start();

  if(!isset($_SESSION['adminGeekhavenLoggedIn']) or !($_SESSION['adminGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    
    $_SESSION['errorMsg'] = "Please login first";
    header("Location: ../index.php");

  } else {

    $conn = new mysqli("localhost", "root", "", "geekhaven");
    mysqli_set_charset($conn,"utf8");

    $stmt = $conn->prepare("SELECT * FROM wings WHERE id=?");
    $stmt->bind_param("s", $_SESSION['adminID']);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM events WHERE conductedBy=? ORDER BY startDate DESC");
    $stmt->bind_param("s", $_SESSION['adminID']);
    $stmt->execute();
    $events = $stmt->get_result();
    $stmt->close();

    // var_dump($events->fetch_assoc());

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Geekhaven | Events</title>
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
  <link rel="stylesheet" href="../static/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

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
    <a href="../index.php" class="logo">
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
              if(isset($_SESSION['adminGeekhavenLoggedIn']) && ($_SESSION['adminGeekhavenLoggedIn'] == true)) {
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $admin['image']; ?>" class="user-image" alt="Admin Image">
              <span class="hidden-xs"><?php echo $_SESSION['name']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $admin['image']; ?>" class="img-circle" alt="Admin Image">

                <p>
                  <?php echo $_SESSION['name']; ?>
                </p>
              </li>
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
          <img src="<?php echo $admin['image']; ?>" class="img-circle" alt="Admin Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['name']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="index.php">
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
        <li class="active">
          <a href="events.php">
            <i class="fa fa-table"></i> <span>Events</span>
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
        Events
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Events</li>
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
        <div class="col-xs-12 col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#events" data-toggle="tab">Events</a></li>
              <li><a href="#addEvent" data-toggle="tab">Add Event</a></li>
            </ul>
            <div class="tab-content">

              <div class="active tab-pane" id="events">
                <table id="example1" class="table table-bordered table-striped">
                  <?php

                    if($admin['username'] == "superAdmin") {

                  ?>

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
                                  <td>
                                    <a href='eventDetails.php?eventID=".$event['id']."'>".$event['eventName']."
                                  </td>
                                  <td>
                                    <span class='label ".$wingColor[$wing['name']]."'>".$wing['name']."</span>
                                  </td>
                                  <td>".date('h:i A, dS F Y', strtotime($event['startDate']))."</td>
                                  <td>".date('h:i A, dS F Y', strtotime($event['endDate']))."</td>
                                </tr>");
                              }
                            }
                          ?>
                        </tbody>

                  <?php
                    } else {
                  ?>

                    <thead>
                    <tr>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Status</th>
                      <th>Edit</th>
                      <th>Report</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($events) {
                          while($event = $events->fetch_assoc()) {

                            $start = date('h:i A, dS F Y', strtotime($event['startDate']));
                            $end = date('h:i A, dS F Y', strtotime($event['endDate']));

                            echo("<tr>
                              <td><a href='eventDetails.php?eventID=".$event['id']."'>".$event['eventName']."</td>
                              <td>".substr($event['description'], 0, 105)." . . . . .</td>
                              <td>".$start."</td>
                              <td>".$end."</td>
                              <td>");

                            //Event Status
                            date_default_timezone_set("Asia/Calcutta");
                            $date = date('Y-m-d h:i:s', time());

                            if($event['eventStatus'] == "Conducted") {
                              echo "<span class='label label-success'>Conducted</span></td>";
                            }
                            else if($event['eventStatus'] == "Postponed") {
                              echo "<span class='label label-warning'>Postponed</span></td>";
                            }
                            else if($event['eventStatus'] == "Cancelled") {
                              echo "<span class='label label-danger'>Cancelled</span></td>";
                            }
                            else if($date < $event['startDate']) {
                              echo "<span class='label label-info'>To Be Conducted</span></td>";
                            }
                            else if(($event['startDate'] < $date) && ($date < $event['endDate'])) {
                              echo "<span class='label bg-purple'>Ongoing</span></td>";
                            }
                            else if($date > $event['endDate']) {
                              echo "<span class='label label-default'>To Be Updated</span></td>";
                            }


                            //Edit or Submit Report
                            if($date < $event['startDate']) {
                              echo("<td class='text-center'>
                                  <a href='editEvent.php?eventID=".$event['id']."'>
                                    <i class='fa fa-edit fa-lg' style='cursor: pointer; color: #3c8dbc;'></i>
                                  </a>
                                </td>
                                <td class='text-center'>
                                  <i class='fa fa-cloud-upload fa-lg'></i>
                                </td>");
                            } else {
                              echo("
                                <td class='text-center'>
                                    <i class='fa fa-edit fa-lg'></i>
                                </td>");
                                
                                $stmt = $conn->prepare("SELECT reportUrl from events WHERE id=?");
                                $stmt->bind_param("s", $event['id']);
                                $stmt->execute();
                                $result = $stmt->get_result()->fetch_assoc();
                                $stmt->close();
                                $reportUrl = $result["reportUrl"];
                                
                                if($reportUrl == "") 
                                {
                                    echo("<td class='text-center'>
                                      <i class='fa fa-cloud-upload fa-lg' id='fileTrigger' style='color: #3c8dbc; cursor: pointer;'></i>
                                      <input type='file' name='file' id='file' style='display: none;' data-id='".$event['id']."'/>
                                    </td>");
                                }
                                else 
                                {
                                    echo("<td class='text-center'>Submitted</td>");
                                }
                            }


                            // if($date > $event['endDate']) {
                            //   echo("<td class='text-center'>
                            //     <i class='fa fa-cloud-upload fa-lg'></i>
                            //   </td>");
                            // } else {
                            //   echo("");
                            // }

                          }
                        }
                      ?>
                    </tbody>
                  <?php
                    }
                  ?>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="addEvent">
                <form class="form-horizontal" method="post" action="addEditEvent.php">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name" name="eventName">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputD" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea rows="5" class="form-control" id="inputD" placeholder="Description" style="resize: none;" name="description"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputP" class="col-sm-2 control-label">Prerequisites</label>

                    <div class="col-sm-10">
                      <textarea rows="2" class="form-control" id="inputP" placeholder="Prerequisites (separated by comma)" style="resize: none;" name="prerequisites"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="datetimepicker1" class="col-sm-2 control-label">Start DateTime</label>

                    <div class="col-sm-10">
                      <input type='text' class="form-control datetimepicker1" id='datetimepicker1' name="start"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputP" class="col-sm-2 control-label">End DateTime</label>

                    <div class="col-sm-10">
                      <input type='text' class="form-control datetimepicker2" id='datetimepicker2' name="end"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger" name="addEvent">Add Event</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

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
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE r demo purposes -->
<script src="../dist/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  <script>
    $(function () {
      $('#example1').DataTable({
        "order": []
        // "order": [[ 2, "desc" ]]
      });

      // $('#datetimepicker1').datetimepicker({
      //   minDate:new Date(),
      //   format: 'YYYY-MM-DD HH:mm:ss'
      // });
      // $('#datetimepicker2').datetimepicker({
      //   minDate:new Date(),
      //   format: 'YYYY-MM-DD HH:mm:ss'
      // });

      $('#datetimepicker1').datetimepicker({

          showTodayButton: true,
          showClose: true,
          toolbarPlacement: "bottom",
          format: "YYYY-MM-DD HH:mm:ss",
          minDate:new Date(),
          stepping: 10

      }).on('dp.change',function(e){

          $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
          console.log("Hello");
      });

      $('#datetimepicker2').datetimepicker({

          showTodayButton: true,
          showClose: true,
          toolbarPlacement: "bottom",
          useCurrent: false,
          format: "YYYY-MM-DD HH:mm:ss",
          minDate:new Date(),
          stepping: 10

      }).on('dp.change',function(e){

          $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
      });

    });

    $(document).ready(function(){

      $("#fileTrigger").on('click', function(){
        $("#file").click();
      });

      $("#file").on('change', function(){

        var property = $("#file").files[0];
        var file_name = property.name;
        var file_ext = file_name.split('.').pop().toLowerCase();

        if(jQuery.inArray(file_ext, ['csv']) == -1) {
          alert("Please upload csv file only");
        }
        else {
          var form_data = new FormData();
          form_data.append("file", property);

          $.ajax({
            url: "upload.php",
            method: "POST",
            data: form_data,
            success: function(data){
              console.log(data);
              alert("File uploaded successfully");
            }
          })
        }

      });
    });

  </script>

</div>
</body>
</html>