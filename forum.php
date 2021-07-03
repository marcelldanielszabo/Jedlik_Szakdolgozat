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
  $_SESSION["atadott_id"] = NULL;
  $_SESSION["uid"] = NULL;


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
            .button
    {
        background-color:white;
        border:none;
        max-width:500px;
        text-align:left;
        margin-left:10px;
    }
            
         </style>
    </head>
<body>




    <div class="container">
            <div class="row">
                    <div class="col-sm-4">
                                <div class="card" style="padding:15px width: 18rem;">

                                        <img src="forum_logo.png" class="card-img-top" alt="logo">
                                            <div class="card-body">
                                                <p class="card-text text-justify">
                                                    Üdvözlet a gitárkotta fórum oldalán. Itt megtalálhatod a legfrissebb fórum bejegyzéseket! 
                                                    Valamint ha nem találsz számodra megfelelőt, akkor nyithatsz sajátot is akár.
                                                    Bejegyzés nyitás előtt viszont kérlek olvasd el a szabályzatot!
                                                    Köszönettel a szerkesztőség
                                                </p>
                                            </div>
                                    </div>
                    </div>

                    <div class="col-sm-8">
                                    <div class="card"> 
                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
                                                <br>
                                                        <h3 class="display-4"> &nbsp Friss bejegyzések </h3><hr>
                                                       

                                                </form>
                                                <?php 
                                                        include("db_config.php");
                                                        $sql = "          SELECT
                                                                                *
                                                                            FROM topics
                                                                            WHERE 1=1
                                                                            ORDER BY topic_date DESC LIMIT 5";
                                                        $result = $connection->query($sql);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while($row = $result->fetch_assoc())
                                                                {
                                                                    echo "
                                                                    <form action=\"bejegyzes.php\" method=\"POST\">
                                                                        <button type=\"submit\" class=\"button\" >"
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
    <div class="container">
            <div class="row">

                <div class="col-sm-4">
                        <div class="jumbotron"> 
                            <div class="card"> 
                                                <div class="card-header">
                                                    <h4 class=""> &nbspÚj bejegyzés nyitása</h4>
                                                </div>
                                         <div class="card-body">
                                                    <form action="new_topic.php" method="POST"> 
                                                            A bejegyzés neve
                                                                <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            
                                                                        </div>
                                                                    <input type="text" class="form-control" name="nev">
                                                                </div>
                                                                    A bejegyzés bővebb leírása - <i> Nem kötelező</i>
                                                                    <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                
                                                                            </div>
                                                                        <textarea class="form-control" name="leiras"></textarea>
                                                                    </div>
                                                                <br>

                                                                    </div>
                                                                    <?php 
                                                                        include("db_config.php");
                                                                        $user = $_SESSION['username'];
                                                                        $sql = "SELECT users.userID
                                                                                    FROM users
                                                                                WHERE users.username = '$user' ;";
                                                                        $sor = $connection->query($sql)->fetch_assoc();
                                                                        $_user_ID = $sor["userID"] ;
                                                                        
                                                                        echo '<input type="hidden" name="letrehozo_id" value= "' . $_user_ID . '"> ' 
                                                                        
                                                                    ?>
                                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Létrehoz</button>
                                                    </form>
                                        </div>
                                 </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="jumbotron">
                                <div class="card"> 
                                <div class="card"> 
                                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> 
                                                <br>
                                                        <h3 class="display-4"> Az összes bejegyzés </h3><hr>
                                                       

                                                </form>
                                                <?php 
                                                        include("db_config.php");
                                                        $sql = "          SELECT
                                                                                *
                                                                            FROM topics
                                                                            WHERE 1=1";
                                                        $result = $connection->query($sql);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while($row = $result->fetch_assoc())
                                                                {
                                                                    echo "
                                                                    <form action=\"bejegyzes.php\" method=\"POST\">
                                                                        <button type=\"submit\" class=\"button\" >"
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
                </div>
                       
             </div>
    </div>
    </div>
</body>
</html>

<?php 

include("footer.html");


?>