<?php
    include "base.php";
    include "navbarheader.php";
    include "navtop.php";
    include "sidemenu.php";

    $servername = "localhost";
    $dbname = "geekhaven";
    $table = "users";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['category'])){
        $category = $_GET['category'];
        $query = $conn->prepare("SELECT * FROM users WHERE position=:position");
        $query->execute(['position'=>$category]);
    } else {
        $query = $conn->prepare("SELECT * FROM users");
        $query->execute();
    }
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Users Information</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Add User
                    </button>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add User</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="addUser.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="rollNum">Roll Number:</label>
                                            <input type="text" class="form-control" id="rollNum" name="rollNum">
                                        </div>
                                        <div class="form-group">
                                            <label for="position">Position:</label>
                                            <select class="dropdown" id="position" name="position">
                                                <option selected="selected">------</option>
                                                <option value="overall">Overall Co-Ordinator</option>
                                                <option value="coordinator">Co-Ordinator</option>
                                                <option value="member">Member</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact">Contact Number:</label>
                                            <input type="number" class="form-control" id="contact" name="contact">
                                        </div>
                                        <div class="form-group">
                                            <label for="wing">Wing:</label>
                                            <select class="dropdown" id="wing" name="wing">
                                                <option selected="selected">------</option>
                                                <option value="Overall">Overall</option>
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
                                            <label for="image">Image:</label>
                                            <input type="file" id="image" name="image">
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Roll Num</th>
                                        <th>Contact</th>
                                        <th>Position</th>
                                        <th>Wing</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($result as $row){
                                        echo('<tr>
                                            <td><img src="'.$row["img"].'" height="50px" width="50px"></td>
                                            <td>'.$row["username"].'</td>
                                            <td>'.$row["rollNum"].'</td>
                                            <td>'.$row["contact"].'</td>
                                            <td>');
                                            
                                            $pos = $row["position"];
                                            if($pos == "overall"){
                                                echo('Overall Coordinator');
                                            } elseif($pos == "coordinator"){
                                                echo("Coordinator");
                                            } elseif($pos == "member"){
                                                echo("Member");
                                            }
                                            echo('</td>
                                            <td>'.$row["wing"].'</td>
                                            <td>
                                            <a href="editUser.php?id='.$row["id"].'">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

    <script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../static/vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../static/dist/js/sb-admin-2.js"></script>

</body>

</html>