<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
  include("header.html");
  include("navbar.html");
  $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" collate="utf8_hungarian_ci">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Gitarkotta</title>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="style.css">
        <style>
         .jumbotron .container .row 
            {
                margin:0px!important;
                margin-bottom:auto;
                padding:0px !important;
                background-color: white !important; 
                
                
            }
            .card .card-body
            {
                border-radius:0 !important;
            }
            
         </style>
    </head>
<body>
    <div class="container">
        <div class="row">
                <div class="col-sm-8">
                                <div class="jumbotron">
                                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
                                        <?php
                                        include("db_config.php");
                                        if(isset($_SESSION["atadott_id"]))
                                        {
                                            $id_keres =  $_SESSION["atadott_id"];

                                        }
                                        else if( isset($_POST["atadott_ID"]))
                                        {

                                                $id_keres =  $_POST["atadott_ID"];
                                                $_SESSION["atadott_id"] = $id_keres;
                                        }
                                                $sql = "SELECT kottak.cim, kottak.eleresi_ut
                                                FROM kottak
                                                WHERE kottak.kotta_ID = $id_keres ";
    
                                                $row = $connection->query($sql)->fetch_assoc();
                                                $eleresi_ut = $row["eleresi_ut"];
                                                $f = fopen($eleresi_ut, "r") or die("Unable to open file!");
                                                //echo fread($f);
                                                echo "<h1> ".  $row["cim"] . " </h1>";
                                                while(!feof($f)) {
                                                    echo fgets($f) . "<br>";
                                                }
    
                                                fclose($f);
                                            

                                            $connection->close();
                                        ?>
                                    
                                    </form>
                                </div>
                </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pengetések:</h5>
                                <p class="card-text"> Eddig 
                                    <?php 
                                            include("db_config.php");
                                            $_kotta =  $_SESSION["atadott_id"];
                                            $sql_count = "  SELECT
                                                                COUNT(like_ok.l_kotta_ID) AS likeok
                                                            FROM like_ok
                                                            WHERE like_ok.l_kotta_ID =  $_kotta" ;
                                            $sor = $connection->query($sql_count)->fetch_assoc();
                                            echo $sor["likeok"];
                                            $connection->close();

                                    ?> 
                                
                                felpengetés érkezett erre a tabra</p>
                                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
                                                <button type="submit" class="btn btn-warning btn-block" name="btn_like" > 
                                                    <?php 
                                                    include("db_config.php");
                                                    $username = $_SESSION['username'];
                                                    $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                    $sor = $connection->query($sqluser)->fetch_assoc();
                                                    $_user = $sor["userID"];
                                                    $_kotta =  $_SESSION["atadott_id"];

                                                    $sql_hiba = "SELECT l_user_ID, l_kotta_ID FROM like_ok WHERE like_ok.l_user_ID = $_user AND like_ok.l_kotta_ID = $_kotta"; $results = mysqli_query($connection, $sql_hiba);
                                                    if (mysqli_num_rows($results) == 1)  //már benne van ez a kombó a táblában
                                                    {
                                                        echo "Lepengetés";
                                                    }
                                                    else
                                                    {
                                                        echo "Felpengetés";
                                                    }
                                                    $connection->close();
                                                    ?>
                                                    <img src="like.png" style="width:20px; width:20px;">
                                                </button>
                                            </form>
                                            <?php

                                                include("db_config.php");

                                                if($_SERVER['REQUEST_METHOD'] == 'POST') 
                                                {
                                                    if (isset($_POST['btn_like']))
                                                    {
                                                            $username = $_SESSION['username'];
                                                            $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                            $sor = $connection->query($sqluser)->fetch_assoc();
                                                            $_user = $sor["userID"];
                                                            $_kotta =  $_SESSION["atadott_id"];

                                                            $sql_hiba = "SELECT l_user_ID, l_kotta_ID FROM like_ok WHERE like_ok.l_user_ID = $_user AND like_ok.l_kotta_ID = $_kotta";
                                                            $results = mysqli_query($connection, $sql_hiba);
                                                            if (mysqli_num_rows($results) == 1)  //már benne van ez a kombó a táblában
                                                            {
                                                                $sql_ = "DELETE FROM like_ok WHERE like_ok.l_user_ID = $_user AND like_ok.l_kotta_ID = $_kotta";
                                                                if ($connection->query($sql_) == TRUE) 
                                                                {
                                                                    echo '<script>window.location.href = "tab.php";</script>';
                                                                }
                                                                else 
                                                                {
                                                                            echo "Error: " . $sql_ . "<br>" . $connection->error;
                                                                } 
                                                            }
                                                            else
                                                            {
                                                                $sql_ = "   INSERT INTO like_ok (l_user_ID, l_kotta_ID)
                                                                            VALUES($_user,$_kotta); ";
                                                                if ($connection->query($sql_) == TRUE) 
                                                                {
                                                                        echo '<script>window.location.href = "tab.php";</script>';
                                                                } 
                                                                else 
                                                                {
                                                                            echo "Error: " . $sql_ . "<br>" . $connection->error;
                                                                } 
                                                            }	

                                                    }
                                                }
                                                $connection->close();


                                            ?>
                            </div>
                        </div>
<br>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Letöltés</h5>
                                <p class="card-text">Le tudod tölteni ezt a tabot formátumban.</p>
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#exampleModal">
                                    Letöltés
                                </button>
                            </div>
                        </div>
<br>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Mentés kedvencek közé</h5>
                                <p class="card-text">El tudod menteni a tabot a kedvencek közé.</p>
                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
                                    <button type="submit" class="btn btn-info btn-block" name="btn_save" >
                                                <?php 
                                                include("db_config.php");
                                                $username = $_SESSION['username'];
                                                    $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                    $sor = $connection->query($sqluser)->fetch_assoc();
                                                    $_user = $sor["userID"];
                                                    $_kotta =  $_SESSION["atadott_id"];

                                                    $sql_hiba = "SELECT user_ID, kotta_ID FROM kedvencek WHERE kedvencek.user_ID = $_user AND kedvencek.kotta_ID = $_kotta";
                                                    $results = mysqli_query($connection, $sql_hiba);
                                                 if (mysqli_num_rows($results) == 1)  //már benne van ez a kombó a táblában
                                                 {
                                                     echo "Törlés";
                                                 }
                                                 else
                                                 {
                                                     echo "Mentés";
                                                 }
                                                 $connection->close();
                                                ?>

                                    </button>
                                    <?php
                                        if($_SERVER['REQUEST_METHOD'] == 'POST') 
                                        {
                                            if (isset($_POST['btn_save']))
                                            {
                                                include("db_config.php");
                                                $username = $_SESSION['username'];
                                                    $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                    $sor = $connection->query($sqluser)->fetch_assoc();
                                                    $_user = $sor["userID"];
                                                    $_SESSION["uid"] = $_user;
                                                    $_kotta =  $_SESSION["atadott_id"];

                                                    $sql_hiba = "SELECT user_ID, kotta_ID FROM kedvencek WHERE kedvencek.user_ID = $_user AND kedvencek.kotta_ID = $_kotta";
                                                    $results = mysqli_query($connection, $sql_hiba);
                                                    if (mysqli_num_rows($results) == 1)  //már benne van ez a kombó a táblában
													{
                                                        $sql_ = "DELETE FROM kedvencek WHERE kedvencek.user_ID = $_user AND kedvencek.kotta_ID = $_kotta";
                                                        if ($connection->query($sql_) == TRUE) 
                                                        {
                                                            echo '<script>window.location.href = "tab.php";</script>';
                                                        }
                                                        else 
                                                        {
                                                                    echo "Error: " . $sql_ . "<br>" . $connection->error;
                                                        } 
                                                    }
                                                    else
                                                    {
                                                        $sql_ = "   INSERT INTO kedvencek (user_ID, kotta_ID)
                                                                    VALUES($_user,$_kotta); ";
                                                        if ($connection->query($sql_) == TRUE) 
                                                        {
                                                                echo '<script>window.location.href = "tab.php";</script>';
                                                        } 
                                                        else 
                                                        {
                                                                    echo "Error: " . $sql_ . "<br>" . $connection->error;
                                                        } 
                                                    }	
                                                    echo '<script>window.location.href = "tab.php";</script>';

                                                    
                                                $connection->close();
                                            }
                                        }
                                    ?>
                                </form>
                               
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Letöltés</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="comment"> <?php   echo "<h3> ".  $row["cim"] . " </h3>"; ?>  </label>
                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
                                                <textarea class="form-control" rows="15" id="ta_kotta">
                                                        <?php
                                                            $f = fopen($eleresi_ut, "r") or die("Unable to open file!");
                                                            while(!feof($f)) { echo fgets($f); }
                                                            fclose($f);
                                                        ?>      
                                                </textarea>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                                            <button type="button" class="btn btn-primary" onclick="ctrlc_ctrlv()" >Másolás</button>
                                            <script>
                                                function ctrlc_ctrlv() {
                                                var copyText = document.getElementById("ta_kotta");
                                                copyText.select();
                                                document.execCommand("copy");
                                                }
                                            </script>

                                        </div>
                                </div>
                            </div>
                        </div>
<br>
                    
                        <div class="card">
                            <div class="card-body">
                                    <h5 class="card-title">Hallgasd meg</h5>
                                
                                <?php 
                                    include("db_config.php");
                                    $_kotta =  $_SESSION["atadott_id"];
                                    $sql_yt = "SELECT yt_link FROM kottak WHERE kottak.kotta_ID = $_kotta";
                                    $sor = $connection->query($sql_yt)->fetch_assoc();
                                    $_link = $sor["yt_link"];
                                    if (isset($_link))
                                    {  
                                        echo "
                                        
                                        <div class=\"embed-responsive embed-responsive-16by9\">
                                        <iframe class=\"embed-responsive-item\" src=\"" . $_link .  "\" frameborder=\"0\" allowfullscreen> </iframe>
                                        </div>
                                        ";
                                    }
                                    else
                                    {
                                        echo "Ehhez a kottához nincsen linkelt dal";
                                    }
                                    $connection->close();
                                ?>
                                    
                                
                            </div>
                        </div>
<br>

                    </div>
                </div>
            </div>
        </div>
    </div>



</body>
</html>

<?php

include("footer.html");

?>