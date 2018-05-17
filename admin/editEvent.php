<?php
    ob_start();
    include "base.php";
    include "navbarheader.php";
    include "navtop.php";
    include "sidemenu.php";

    $servername = "localhost";
    $dbname = "geekhaven";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET['id'];
    $query = $conn->prepare("SELECT * FROM events WHERE id=:id");
    $query->execute(['id'=>$id]);
    $row = $query->fetch();

?>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit Event
                    </div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                    <form method="POST" action="editEvent.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Event Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row["eventName"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="startDate">Start Date:</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $row["startDate"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date:</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $row["endDate"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="conductedBy">Conducted By:</label>
                            <select class="dropdown" id="conductedBy" name="conductedBy">
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
                            <img src="<?php echo $row['permission'];?>" height="100px" width="100px">
                        </div>
                        <button type="submit" class="btn btn-default" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../static/vendor/jquery/jquery.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../static/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../static/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../static/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../static/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../static/vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../static/dist/js/sb-admin-2.js"></script>
    <script>
        $("select#conductedBy option").each(function(){
            if($(this).val()=="<?php echo $row['conductedBy']; ?>"){ // EDITED THIS LINE
                $(this).attr("selected","selected");    
            }
        });
    </script>

<?php
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        // $addedBy = "Admin";
        $conductedBy = $_POST['conductedBy'];
        $status = $row["eventStatus"];
        if($_FILES['permission']['size'] == 0){
            $target_file = $row['permission'];
        } else {
            $target_dir = "../images/permissions/";
            $target_file = $target_dir . basename($_FILES["permission"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $filename = basename( $_FILES['permission']['name']);
            $path_parts = pathinfo($_FILES["permission"]["name"]);
            $image_path = $path_parts['filename'].'_'.date("Y-m-d_h:i:sa").'.'.$path_parts['extension'];
            $target_file = $target_dir.$image_path;

            $check = getimagesize($_FILES["permission"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if ($_FILES["permission"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["permission"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["permission"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        $query = $conn->prepare("UPDATE events SET eventName = :eventName,
                                    startDate = :startDate,
                                    endDate = :endDate,
                                    conductedBy = :conductedBy,
                                    permission = :permission
                                WHERE id=:id");
        $query->execute(['eventName'=>$name, 'startDate'=>$startDate, 'endDate'=>$endDate, 'conductedBy'=>$conductedBy, 'permission'=>$target_file, 'id'=>$id]);

        header("Location: events.php");
    }
?>