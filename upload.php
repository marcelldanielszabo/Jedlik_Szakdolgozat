<?php
    session_start(); 
    if (!isset($_SESSION['username']))
    {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if (isset($_GET['logout'])) 
    {
            session_destroy();
            unset($_SESSION['username']);
            header("location: login.php");
    }



        $fileToUpload = $_FILES['fileToUpload']['name'];
        $target_dir = "kepek/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } 
        else 
        {
            $newfilename = $_SESSION["username"] . '.' . $imageFileType;
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir .$newfilename )) {

                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } 
            else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
            include("db_config.php");
            $user = $_SESSION["username"] ;
            $sql_kep = " UPDATE guitar.users SET  users.kep_eleresi_ut = 'kepek/$newfilename' WHERE users.username = '$user';";                                                                               
            $result = $connection->query($sql_kep); 
            var_dump($sql_kep, $newfilename,$result);
            header('location: profil.php');
        }
?>