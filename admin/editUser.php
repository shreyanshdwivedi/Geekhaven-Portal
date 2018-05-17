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
    $query = $conn->prepare("SELECT * FROM users WHERE id=:id");
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
                    <form method="POST" action="editUser.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row["username"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="rollNum">Roll Number:</label>
                            <input type="text" class="form-control" id="rollNum" name="rollNum" value="<?php echo $row["rollNum"]; ?>">
                        </div><div class="form-group">
                        <label for="position">Position:</label>
                        <select class="dropdown" id="position" name="position">
                            <option value="overall">Overall Co-Ordinator</option>
                            <option value="coordinator">Co-Ordinator</option>
                            <option value="member">Member</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact Number:</label>
                            <input type="number" class="form-control" id="contact" name="contact" value="<?php echo $row["contact"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="wing">Wing:</label>
                            <select class="dropdown" id="wing" name="wing">
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
                            <img src="<?php echo $row['img'];?>" height="100px" width="100px">
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
        $("select#wing option").each(function(){
            if($(this).val()=="<?php echo $row['wing']; ?>"){ // EDITED THIS LINE
                $(this).attr("selected","selected");    
            }
        });
        $("select#position option").each(function(){
            if($(this).val()=="<?php echo $row['position']; ?>"){ // EDITED THIS LINE
                $(this).attr("selected","selected");    
            }
        });
    </script>

<?php
    if(isset($_POST['submit'])){
        $rollNum = $_POST['rollNum'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $contact = $_POST['contact'];
        $wing = $_POST['wing'];

        if($_FILES['image']['size'] == 0){
            $target_file = $row['img'];
        } else {
            $target_dir = "../images/users/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $filename = basename( $_FILES['image']['name']);
            $path_parts = pathinfo($_FILES["image"]["name"]);
            $image_path = $path_parts['filename'].'_'.date("Y-m-d_h:i:sa").'.'.$path_parts['extension'];
            $target_file = $target_dir.$image_path;

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if ($_FILES["image"]["size"] > 500000) {
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
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        $query = $conn->prepare("UPDATE users SET username = :username,
                                    rollNum = :rollNum,
                                    position = :position,
                                    contact = :contact,
                                    wing = :wing,
                                    img = :img
                                WHERE id=:id");
        $query->execute(['username'=>$name, 'rollNum'=>$rollNum, 'position'=>$position, 'contact'=>$contact, 'wing'=>$wing, 'img'=>$target_file,'id'=>$id]);

        header("Location: users.php");
    }
?>