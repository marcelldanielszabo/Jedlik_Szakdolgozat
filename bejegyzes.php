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
        
        <style>
        
        
        .topos
            {
                padding-top:20px;
                margin-top:20px;
            }
            
        </style>
        
        <link rel="stylesheet" href="style.css">
    </head>
<body>
    <div class="container">
          <div class="row">
              
                    <div class="col-sm-8">
                        <div class="jumbotron">

                             
                        <?php 
                              if(isset($_SESSION["atadott_id"]))
                              {
                                  $id_keres =  $_SESSION["atadott_id"];
                                if(isset($_SESSION["alap"]))
                                {
                                  $id_keres = $_SESSION["alap"];    
                                }
                                  include("db_config.php");

                                  $sql = "SELECT *
                                          FROM topics
                                          WHERE topics.topic_id = $id_keres ;";
    
                                  $row = $connection->query($sql)->fetch_assoc();
    
                                  echo " <h1>  " .  $row["topic_subject"] . " </h1>"; 
                              }
                              else if( isset($_POST["atadott_ID"]))
                              {

                                      $id_keres =  $_POST["atadott_ID"];
                                      if(isset($_SESSION["alap"]))
                                      {
                                        $id_keres = $_SESSION["alap"];    
                                      }
                                      $_SESSION["atadott_id"] = $id_keres;
                                      include("db_config.php");

                              $sql = "SELECT *
                                      FROM topics
                                      WHERE topics.topic_id = $id_keres ;";

                              $row = $connection->query($sql)->fetch_assoc();

                              echo " <h1>  " .  $row["topic_subject"] . " </h1>"; 
                              }

                              ?>

                                        <div class="card">
                                          <div class="card-body">
                                            <div class="row">
                                               
                                                  <p class="card-text">
                                                        <?php
                                                          include("db_config.php"); 
                                            
                                                          if(isset($_SESSION["alap"]))
                                                          {
                                                            $id_keres = $_SESSION["alap"];    
                                                          }
                                                          else
                                                          {
                                                            $id_keres =  $_POST["atadott_ID"];
                                                          }
                                                         
                                                          $sql = "SELECT *
                                                                  FROM topics
                                                                  WHERE topics.topic_id = $id_keres; ";

                                                          $row = $connection->query($sql)->fetch_assoc();
                                                          if(  $row["topic_desc"] == "")
                                                          {
                                                            echo "A felhasználó nem adott leírást";
                                                          }
                                                          else{
                                                          echo " <p>" .  $row["topic_desc"] . "</p>";  
                                                          }
                                                          $connection->close();

                                                        ?>

                                                  </p>
                                                
                                            </div>
                                          </div>
                                        </div>
                             </div>
                             <?php 
                                include("db_config.php");
                                $sql = "SELECT * FROM guitar.posts WHERE posts.post_topic = $id_keres ORDER BY posts.post_date;";
                                $result = $connection->query($sql);
                                    if ($result->num_rows > 0) 
                                    {
                                      while($row = $result->fetch_assoc())
                                      {
                                        $nev = $row["post_by"]; 
                                        $sql_user = "SELECT * FROM guitar.users WHERE users.userID = $nev;";
                                        $eredmeny = $connection->query($sql_user);                                     
                                        $sor = $eredmeny->fetch_assoc();
                                        echo '
                                              <div class="card">
                                                <div class="card-body">
                                                      <div class ="row">
                                                        <div class="col col-sm-4">
                                                          <img src=" ' . $sor["kep_eleresi_ut"]  . '" class="card-img-top" alt="User képe" >
                                                        </div>
                                                          <div class=" col col-sm-8">
                                                          <h5 class="card-title"> ' .  $sor["username"] . ' </h5> <p>' . $row["post_date"].' </p> <hr>
                                                              ' . $row["post_content"] . '
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          ';
                                      }
                                    }
                               
                             ?>
                             
                    </div>
                      
                    <div class="col-sm-4">
                        <div class="jumbotron">
                          
                            <div class="card">
                                  <div class="card-body">
                                      
                                      <?php 
                                            include("db_config.php");

                                            $sql = "SELECT *
                                                    FROM topics
                                                    WHERE topics.topic_id = $id_keres ";

                                            $row = $connection->query($sql)->fetch_assoc();
                                            $user_ = $row["topic_by"];
                                            $sql_1 = "SELECT users.username
                                                            FROM users
                                                            WHERE users.userID = $user_ ";
                                            $sor = $connection->query($sql_1)->fetch_assoc();
                                            $sql_2 = "SELECT users.kep_eleresi_ut
                                            FROM users
                                            WHERE users.userID = $user_ ";
                                            $kep = $connection->query($sql_2)->fetch_assoc();
                                            echo '<br><img class="card-img-top" src="'.$kep["kep_eleresi_ut"].'" />';    
                                            echo " <p> Ezt a bejegyzést <i> " .  $sor["username"] . " </i>  nyitotta <br>" . $row["topic_date"]. "-kor</p>";  

                                      
                                      ?>
                                    
                                      
                                  </div>
                            </div>
                            
                            <div class="card">
                                  <div class="card-body">
                                          <h5 class="card-title">Leírás</h5>
                                      
                                      
                                      <?php 

                                       if(isset($_SESSION["atadott_id"]))
                                       {
                                           $id_keres =  $_SESSION["atadott_id"];
                                           
                                       }
                                       else if( isset($_POST["atadott_ID"]))
                                       {
         
                                               $id_keres =  $_POST["atadott_ID"];
                                               $_SESSION["atadott_id"] = $id_keres;
                                              
                                       }
                                      
                                            include("db_config.php");

                                            $sql = "SELECT *
                                                    FROM topics
                                                    WHERE topics.topic_id = $id_keres ";

                                            $row = $connection->query($sql)->fetch_assoc();
                                            if(  $row["topic_desc"] == "")
                                            {
                                              echo "A felhasználó nem adott leírást";
                                            }
                                            else{
                                            echo " <p>" .  $row["topic_desc"] . "</p>";  
                                            }
                                            $connection->close();
                                      
                                      ?>
                                    
                                      
                                  </div>
                            </div>

                        </div>
                        
                    </div>



              </div>
              <div class="card">
              <div class="card-header">
                Hozzászólás írása
              </div>
              <div class="card-body">
                
                  <form action="komment.php" method="POST">
                            <label for="komment"> </label>
                            <textarea class="form-control" id="komment" name="komment" rows="3"></textarea>
                            <button type="submit" class="btn btn-primary btn-lg btn-block topos"> Küldés</button>
                            <input type="hidden" name="atadott_id" value=" <?php echo $id_keres; ?>">
                  </form>
             
              </div>
            </div>
          
          </div>

    
    
    </div>
</body>
</html>

<?php





include("footer.html");


?>