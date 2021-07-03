<?php 
$_SESSION["atadott_id"] = NULL;
  $_SESSION["uid"] = NULL; 
  ?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .button
    {
        background-color:white;
        border:none;
        max-width:300px;
        text-align:left;
        margin-left:10px;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Újdonságok</h1>
            <p class="lead">Nap mint nap, új kották, és tabok érkeznek minden zenésznek! Válogass bátran</p>
            <hr class="my-4">
            <p>Az oldalon jelenleg 
                <?php
                    include("db_config.php"); 
                    $sql_count = "  SELECT
                                    COUNT(kottak.kotta_ID) AS kottak_szama
                                            FROM kottak";
                    $sor = $connection->query($sql_count)->fetch_assoc();
                    echo $sor["kottak_szama"];
                    $connection->close();
                ?>
                
                kotta található</p>
            <a class="btn btn-success btn-lg" href="search.php" role="button">Böngéssz kottákat</a>

        </div>
        
        <div class="jumbotron">
                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top" src="01.jpg" alt="Card image cap">
                        <div class="card-body">
                        <h5 class="card-title">Hírek</h5>
                        <p class="card-text">Tisztelt felhasználók! Az oldal elindult, és működik</p>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="02.jpg" alt="Card image cap">
                        <div class="card-body">
                        <h5 class="card-title">Fórum</h5>
                        <p class="card-text">Fórumonkon több gitárossal veheted fel a kapcsolatot, és véleményüket is kikérheted</p>
                        <a class="btn btn-warning btn-lg" href="forum.php" role="button">Irány a Fórum</a>
                        </div>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="03.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">A legtöbbet értékelt kották</h5>
                            <?php 
                             
                             include("db_config.php");
                             $sql_get_id = "     SELECT
                                                    like_ok.l_kotta_ID,
                                                    COUNT(like_ok.l_user_ID) AS like_szam
                                                FROM like_ok
                                                GROUP BY like_ok.l_kotta_ID
                                                ORDER BY like_szam DESC LIMIT 5";
                             $result = $connection->query($sql_get_id);
                             if ($result->num_rows > 0) 
                             {
                                 echo "<br>";
                                 while($row = $result->fetch_assoc())
                                 {
                                    $l_kid = $row["l_kotta_ID"] ;

                                    $sql_select = " SELECT
                                                        kottak.cim,
                                                        kottak.kotta_ID
                                                    FROM kottak 
                                                    WHERE  kottak.kotta_ID = $l_kid";
                                    $results = mysqli_query($connection, $sql_select);
                                    if ($rows = $results->fetch_assoc()) 
                                    {
                                         echo "
                                            <form action=\"tab.php\" method=\"POST\">
                                                <button type=\"submit\" class=\"button\" >"
                                                . $rows["cim"] . " - <i>" .  $row["like_szam"]    . "</i>
                                                </button>
                                                <input type=\"hidden\" value=\"" . $rows["kotta_ID"] . "\" name=\"atadott_ID\">
                                            </form>
                                            <hr>";
                                            
                                    }
                                   
                                 }
                            }
                             
                             $connection->close();


                            ?>
                            <p class="card-text">.</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</body>
</html>