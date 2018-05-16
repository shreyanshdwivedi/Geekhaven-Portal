<?php
 include "base.php";
 include "navbarheader.php";
 include "navtop.php";
 include "sidemenu.php";
?>

</nav>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">20</div>
                            <div>Co-Ordinators!</div>
                        </div>
                    </div>
                </div>
                <a href="users.php?category=coordinator">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">42</div>
                            <div>Total Members!</div>
                        </div>
                    </div>
                </div>
                <a href="users.php?category=member">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">7</div>
                            <div>Total Events!</div>
                        </div>
                    </div>
                </div>
                <a href="events.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">7</div>
                            <div>Total Participants!</div>
                        </div>
                    </div>
                </div>
                <a href="details.php?category=participants">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Top Performers
                        </div>
                        <!-- /.panel-heading -->
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">RollNum</th>
                              <th scope="col">Name</th>
                              <th scope="col">Points</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>IWM2016501</td>
                              <td>Shreyansh Dwivedi</td>
                              <td>700</td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- /.panel-body -->
                    </div>

                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Upcoming Events
                        </div>
                        <!-- /.panel-heading -->
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Event Name</th>
                              <th scope="col">Start Date</th>
                              <th scope="col">End Date</th>
                              <th scope="col">Conducted By</th>
                              <th scope="col">Satus</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
                              <td>\</td>
                              <td></td>
                              <td>Delivery</td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

            <div id="chart_div" style="width: 100%; height: 500px;"></div>
            <!-- /.row -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "scripts.php"; ?>