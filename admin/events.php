<?php
    ob_start();
    include "base.php";
    include "navbarheader.php";
    include "navtop.php";
    include "sidemenu.php";

    $servername = "localhost";
    $dbname = "geekhaven";
    $table = "events";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $conn->prepare("SELECT * FROM events");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Event Information</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Add Event
                    </button>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Event</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="addEvent.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="startDate">Start Date:</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate">
                                        </div>
                                        <div class="form-group">
                                            <label for="endDate">End Date:</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate">
                                        </div>
                                        <div class="form-group">
                                            <label for="conductedBy">Conducted By:</label>
                                            <select class="dropdown" id="conductedBy" name="conductedBy">
                                                <option selected="selected">------</option>
                                                <option value="Web Development">Web Development</option>
                                                <option value="App Development">App Development</option>
                                                <option value="Software Development">Software Development</option>
                                                <option value="FOSS">FOSS</option>
                                                <option value="Cyber Security">Cyber Security</option>
                                                <option value="Competitive Coding">Competitive Coding</option>
                                                <option value="Blockchain">Blockchain</option>
                                                <option value="Artificial Intelligence">Artificial Intelligence</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="permission">Permission Letter:</label>
                                            <input type="file" id="permission" name="permission">
                                        </div>
                                        <button type="submit" class="btn btn-default" name="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <br/>
            <div class="row">
                <div class="col-lg-12">
                    <!-- {% if error_msg %}
                    <div class="alert alert-danger">
                      {{error_msg}}
                    </div>
                    {% endif %} -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            List of all Users
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Conducted By</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($result as $row){
                                        echo('<tr>
                                            <td>'.$row["eventName"].'</td>
                                            <td>'.$row["startDate"].'</td>
                                            <td>'.$row["endDate"].'</td>
                                            <td>'.$row["conductedBy"].'</td>
                                            <td>');
                                            if($row["eventStatus"] == "To Be Conducted"){
                                                echo('<span class="label label-warning">To Be Conducted</span>');
                                            }else if($row["eventStatus"] == "Conducted") {
                                                echo('<span class="label label-success">Conducted</span>');
                                            }else if($row["eventStatus"] == "Cancelled") {
                                                echo('<span class="label label-danger">Cancelled</span>');
                                            }
                                        echo('</td>
                                        <td>
                                        <a href="editEvent.php?id='.$row["id"].'">
                                            <button type="button" class="btn btn-primary editEvent" data-toggle="modal" data-target="#myModal'.$row["id"].'">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                        </td>
                                        </tr>');
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <script src="../static/vendor/jquery/jquery.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../static/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../static/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../static/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../static/vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../static/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>