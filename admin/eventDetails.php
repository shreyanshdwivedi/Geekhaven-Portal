<?php
  session_start();

  require_once '../vendor/autoload.php'; 
  use Michelf\MarkdownExtra;

  // $Parsedown = new \Parsedown();


  if(!isset($_SESSION['adminGeekhavenLoggedIn']) or !($_SESSION['adminGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    
    $_SESSION['errorMsg'] = "Please login first";
    header("Location: ../index.php");

  } else {

    $conn = new mysqli("localhost", "root", "", "geekhaven");
    mysqli_set_charset($conn,"utf8");

    if(isset($_GET['eventID'])) {
      $eventID = $_GET['eventID'];
    }

    $stmt = $conn->prepare("SELECT * FROM wings WHERE id=?");
    $stmt->bind_param("s", $_SESSION['adminID']);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
    $stmt->bind_param("s", $eventID);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if(!$event) {
      header("Location: 404.php");
    } 

    $wingID = $event['conductedBy'];
    $stmt = $conn->prepare("SELECT * FROM wings WHERE id=?");
    $stmt->bind_param("s", $wingID);
    $stmt->execute();
    $wing = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM attendance WHERE eventID=?");
    $stmt->bind_param("s", $eventID);
    $stmt->execute();
    $stmt->store_result();
    $numAttendees = $stmt->num_rows;
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM reviews WHERE eventID=?");  
    $stmt->bind_param("s", $eventID);
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
  <title>Geekhaven | Event Details</title>
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

  <link rel="stylesheet" href="../static/css/style.css">

  <link href='../bower_components/jquery-bar-rating/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>

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
        <li>
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
        Event Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Event Details</li>
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
        <div class="col-md-3">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Name Of the Event</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <span style="font-size: 15px;"><i><?php echo $event['eventName']; ?></i></span>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Date Of the Event</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <span style="font-size: 15px;"><i><?php $sdate = date('h:i A, dS F Y', strtotime($event['startDate'])); $edate = date('h:i A, dS F Y', strtotime($event['endDate'])); echo $sdate." - ".$edate; ?></i></span> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Attended By</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <span style="font-size: 15px;"><i><?php echo $numAttendees; ?> Students</i></span>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Total Reviews</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <span style="font-size: 15px;"><i><?php echo $numReviews; ?> Reviews</i></span>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <br/>
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!-- <div class="box-header with-border">
                <h3 class="box-title">Conducted By</h3>
              </div><br/> -->
              <center>
                <img src="<?php echo $wing['image']; ?>" alt="Wing profile picture" heigth="100px" width="100px">
              </center>

              <h3 class="profile-username text-center"><?php echo $wing['name']; ?></h3>

              <!-- <p class="text-muted text-center"><b>Roll No.</b> </p> -->

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
          <div class="box box-info">
            <div class="box-body box-profile" style="color: #D4AF37;">
              <div class="box-header with-border">
                <h3 class="box-title">Ratings</h3>
              </div><br/>

              <?php
                  $rating = 5;
                  $stmt = $conn->prepare("SELECT * FROM ratings WHERE eventID=? AND rating=?");  
                  $stmt->bind_param("ss", $eventID, $rating);
                  $stmt->execute();
                  $stmt->store_result();
                  $fiveRating = $stmt->num_rows;
                  $stmt->close();
              ?>

              <span style="font-size: 20px;">
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <span style="float: right; color: #333; font-size: 15px;"><?php echo $fiveRating; ?> Ratings</span>
              </span>
              <br/>
              <?php
                  $rating = 4;
                  $stmt = $conn->prepare("SELECT * FROM ratings WHERE eventID=? AND rating=?");  
                  $stmt->bind_param("ss", $eventID, $rating);
                  $stmt->execute();
                  $stmt->store_result();
                  $fourRating = $stmt->num_rows;
                  $stmt->close();
              ?>
              <span style="font-size: 20px;">
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <span style="float: right; color: #333; font-size: 15px;"><?php echo $fourRating; ?> Ratings</span>
              </span>
              <br/>
              <?php
                  $rating = 3;
                  $stmt = $conn->prepare("SELECT * FROM ratings WHERE eventID=? AND rating=?");  
                  $stmt->bind_param("ss", $eventID, $rating);
                  $stmt->execute();
                  $stmt->store_result();
                  $threeRating = $stmt->num_rows;
                  $stmt->close();
              ?>
              <span style="font-size: 20px;">
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <span style="float: right; color: #333; font-size: 15px;"><?php echo $threeRating; ?> Ratings</span>
              </span>
              <br/>
              <?php
                  $rating = 2;
                  $stmt = $conn->prepare("SELECT * FROM ratings WHERE eventID=? AND rating=?");  
                  $stmt->bind_param("ss", $eventID, $rating);
                  $stmt->execute();
                  $stmt->store_result();
                  $twoRating = $stmt->num_rows;
                  $stmt->close();
              ?>
              <span style="font-size: 20px;">
                <i class="glyphicon glyphicon-star"></i>
                <i class="glyphicon glyphicon-star"></i>
                <span style="float: right; color: #333; font-size: 15px;"><?php echo $twoRating; ?> Ratings</span>
              </span>
              <br/>
              <?php
                  $rating = 1;
                  $stmt = $conn->prepare("SELECT * FROM ratings WHERE eventID=? AND rating=?");  
                  $stmt->bind_param("ss", $eventID, $rating);
                  $stmt->execute();
                  $stmt->store_result();
                  $oneRating = $stmt->num_rows;
                  $stmt->close();
              ?>

              <span style="font-size: 20px;">
                <i class="glyphicon glyphicon-star"></i>
                <span style="float: right; color: #333; font-size: 15px;"><?php echo $oneRating; ?> Ratings</span>
              </span>
              <hr>
              <?php

                  $query = "SELECT ROUND(AVG(rating),1) as averageRating FROM ratings WHERE eventID=".$eventID;
                  $avgresult = mysqli_query($conn,$query) or die(mysqli_error());
                  $fetchAverage = mysqli_fetch_array($avgresult);
                  $averageRating = $fetchAverage['averageRating'];

                  if($averageRating <= 0){
                      $averageRating = "No rating yet.";
                  }
              ?>
              <center>Average Rating : <span id='avgrating_<?php echo $eventID; ?>'><?php echo $averageRating; ?></span></center>
            </div>
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-info">
            <div class="box-body box-profile">
              <div class="box-header with-border">
                <h3 class="box-title">Description</h3>
              </div>
                <?php
                    echo MarkdownExtra::defaultTransform($event['description']); 
                    echo "<hr>";
                    // echo MarkdownExtra::defaultTransform($event['prerequisites']); 
                ?>
                <div class="box-header with-border">
                  <h3 class="box-title">Prerequisites</h3>
                </div>
                <?php
                if($event['prerequisites'] != "") {

                  $label = ['danger', 'success', 'info', 'warning', 'primary'];

                  $p = explode(",", $event['prerequisites']);
                  echo "<p>";
                  $i = 0;
                  foreach ($p as $key => $value) {
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
            </div>
          </div>
          <div class="box box-default" style="height: 500px; overflow-y: scroll;">
            <div class="box-body chat" id="chat-box">
              <div class="box-header with-border">
                <h3 class="box-title">Reviews</h3>
              </div><br/>
              <!-- chat item -->
              <?php
                $eventID = $_GET['eventID'];
                $stmt = $conn->prepare("SELECT * FROM reviews WHERE eventID=?");  
                $stmt->bind_param("s", $eventID);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if($result->num_rows) {
                  while($review = $result->fetch_assoc()) {

                    $reviewUserID = $review['userID'];
                    $reviewEventID = $review['eventID'];

                    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
                    $stmt->bind_param("s", $reviewUserID);
                    $stmt->execute();
                    $user = $stmt->get_result()->fetch_assoc();
                    $stmt->close();

              ?>
                <div class="item">
                  <img src="<?php echo $user['image']; ?>" alt="user image" class="online">

                  <p class="message">
                    <a href="viewProfile.php?rollNum=<?php echo $user['rollNum']; ?>" class="name">
                      <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo time_ago_in_php($review['timestamp']); ?></small>
                      <?php echo $user['first_name']; ?>
                    </a>
                    <?php echo $review['review']; ?>
                  </p>
                </div>

                <?php
                  }
                } else {
                  echo "No reviews yet";
                }
                ?>
            </div>
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

<script src="../bower_components/jquery-bar-rating/dist/jquery.barrating.min.js" type="text/javascript"></script>
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

            $(function() {
              $('.rating').barrating({
                  theme: 'fontawesome-stars',
                  onSelect: function(value, text, event) {

                      // Get element id by data-id attribute
                      var el = this;
                      var el_id = el.$elem.data('id');

                      // rating was selected by a user
                      if (typeof(event) !== 'undefined') {
                          
                          var split_id = el_id.split("_");

                          var eventID = split_id[1];  // postid
                          console.log(value);
                          // AJAX Request
                          $.ajax({
                              url: 'rating_ajax.php',
                              type: 'post',
                              data: {eventID: eventID, rating: value},
                              dataType: 'json',
                              success: function(data){
                                  // Update average
                                  var average = data['averageRating'];
                                  $('#avgrating_'+eventID).text(average);
                                  console.log(data);
                              }
                          });
                      }
                  }
                });
            });
            $(function(){
                // $('#rating_</?php echo $eventID; ?>')
                // .barrating("destroy")
                // .prop("value", </?php echo $rating; ?>)
                // .barrating({theme: 'fontawesome-stars'});

                // $('#rating_<?php echo $eventID; ?>').barrating({
                //   theme: 'fontawesome-stars',
                //   initialRating: <?php echo $rating; ?>
                // });
                console.log(<?php echo $rating; ?>);

                $('#rating_<?php echo $eventID; ?>').barrating('set',<?php echo $rating; ?>);
                // $('#rating_1').barrating('set' 5);
            });
            // $('#rating_</?php echo $eventID; ?>').barrating('set',</?php echo $rating; ?>);
        </script>
</body>
</html>

<?php
    
function time_ago_in_php($timestamp){
  
  date_default_timezone_set("Asia/Kolkata");         
  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;
  
  $minutes = round($seconds / 60); // value 60 is seconds  
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
  $weeks   = round($seconds / 604800); // 7*24*60*60;  
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                
  if ($seconds <= 60){

    return "Just Now";

  } else if ($minutes <= 60){

    if ($minutes == 1){

      return "one minute ago";

    } else {

      return "$minutes minutes ago";

    }

  } else if ($hours <= 24){

    if ($hours == 1){

      return "an hour ago";

    } else {

      return "$hours hrs ago";

    }

  } else if ($days <= 7){

    if ($days == 1){

      return "yesterday";

    } else {

      return "$days days ago";

    }

  } else if ($weeks <= 4.3){

    if ($weeks == 1){

      return "a week ago";

    } else {

      return "$weeks weeks ago";

    }

  } else if ($months <= 12){

    if ($months == 1){

      return "a month ago";

    } else {

      return "$months months ago";

    }

  } else {
    
    if ($years == 1){

      return "one year ago";

    } else {

      return "$years years ago";

    }
  }
}

?>
