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
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Gitarkotta</title>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="style.css">
        <style>


            .topos
            {
                padding-top:20px;
                margin-top:20px;
            }
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
            .card-img-top
            {
              border:1px solid black;
            }
            .button
            {
                background-color:white;
                border:none;
                max-width:200px;
                text-align:left;
                margin-left:10px;
            }
         </style>
    </head>
<body>
    <div class="container">

        <div class="row">
                <div class="col-sm-4">
                      <div class="jumbotron" >
                        <div class="card card-body">
                         
                        <?php 
                            include("db_config.php");
                            $_user = $_SESSION['username'];
                            $sql_kep = "        SELECT
                                                    users.kep_eleresi_ut
                                                FROM users
                                                WHERE users.username = '".$_user."'";                                                                                  
                            $result = $connection->query($sql_kep);
                            $sor = $result->fetch_assoc();    
                            $kep_ = $sor["kep_eleresi_ut"];
                            echo '<img class="card-img-top" src="'.$kep_.'" />';     
                        ?>
                         
                              <h5 class="card-title" stlye="padding-top:10px;"> <?php echo $_user; ?> </h5>

                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                    Beállítások
                                </button>
                        </div>
                      </div>
                </div>

                <div class="col-sm-8">
                      
                
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h5> Elmentett tabok:</h5>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                    <?php
                                    include("db_config.php");

                                        $username = $_SESSION['username'];
                                        $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                        $sor = $connection->query($sqluser)->fetch_assoc();
                                        $_id = $sor["userID"];
                                        $sql = "SELECT
                                                    kottak.cim, kottak.kotta_ID
                                                FROM kedvencek
                                                    INNER JOIN kottak
                                                        ON kedvencek.kotta_ID = kottak.kotta_ID
                                                    INNER JOIN users
                                                        ON kedvencek.user_ID = users.userID
                                                WHERE  kedvencek.user_ID = $_id
                                                    AND kottak.kotta_ID = kedvencek.kotta_ID";
                                        $result = $connection->query($sql);
                                        if ($result->num_rows > 0) 
                                        {
                                            while($row = $result->fetch_assoc())
                                            {
                                                    echo "<form action=\"tab.php\" method=\"POST\">
                                                                <button type=\"submit\" class=\"button\" >"
                                                                . $row["cim"] .
                                                                "</button>
                                                                <input type=\"hidden\" value=\"" . $row["kotta_ID"] . "\" name=\"atadott_ID\">
                                                            </form>
                                                            <hr>";
                                            }
                                        }
                                        else
                                        {
                                            echo "Még nincsenek elmentett kottáid";
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h5> Aktív fórum bejegyzések</h5>
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                                    <?php
                                                    
                                                    include("db_config.php");
                                                    
                                                    $username = $_SESSION['username'];
                                                    $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                    $sor = $connection->query($sqluser)->fetch_assoc();
                                                    $_id = $sor["userID"];

                                                    $sql = "    SELECT *FROM topics
                                                                WHERE topics.topic_by = $_id;";
                                                    $result = $connection->query($sql);
                                                        if ($result->num_rows > 0) 
                                                        {
                                                            while($row = $result->fetch_assoc())
                                                            {
                                                                echo "
                                                                <form action=\"bejegyzes.php\" method=\"POST\">
                                                                    <button type=\"submit\" class=\"button btn btn-block\" >"
                                                                    . $row["topic_subject"] .  "- <i>" . $row["topic_date"] . " </i> 
                                                                    </button>
                                                                    <input type=\"hidden\" value=\"" . $row["topic_id"] . "\" name=\"atadott_ID\">
                                                                </form>
                                                                <hr>";
                                                            ;

                                                        }
                                                        }
                                                        else
                                                        {
                                                            echo "Nincsenek megjeleníthető bejegyzések";
                                                        }
                                                    ?>
                                                    </div>
                                            </div>
                                    </div>
                                </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <h5> Feltöltött tabok:</h5>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <?php

                                                include("db_config.php");

                                                $username = $_SESSION['username'];
                                                $sqluser = "SELECT userID FROM  users WHERE users.username = '$username'";
                                                $sor = $connection->query($sqluser)->fetch_assoc();
                                                $_id = $sor["userID"];
                                                $sql = "SELECT
                                                            kottak.cim, kottak.kotta_ID, kotta_by
                                                        FROM 
                                                            guitar.kottak
                                                        WHERE 
                                                            kotta_by = $_id;";
                                                $result = $connection->query($sql);
                                                if ($result->num_rows > 0) 
                                                {
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                            echo "<form action=\"tab.php\" method=\"POST\">
                                                                        <button type=\"submit\" class=\"button\" >"
                                                                        . $row["cim"] .
                                                                        "</button>
                                                                        <input type=\"hidden\" value=\"" . $row["kotta_ID"] . "\" name=\"atadott_ID\">
                                                                    </form>
                                                                    <hr>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "Még nincsenek feltöltött kottáid";
                                                }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
    </div>
    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Beállíások</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="upload.php" method="post" enctype="multipart/form-data" >
                <div class="card container">
                    <h5 class="card-title"> Profilkép változtatás</h5>
                        <div class="card-body">
                            <p class="card-text text-center">Válaszd ki a feltöltendő fájlt. </p>
                                <div class="row">
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                    <input type="submit" value="Upload Image" name="submit">
                                </div>
                        </div>
                </div> 
            </form>

            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
      </div>
    </div>
  </div>
</div>

          
    
</body>
</html>

<?php
 include("footer.html");
?>