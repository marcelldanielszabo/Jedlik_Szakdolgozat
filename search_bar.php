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
</head>
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
<body>
<div class="container">

        <div class="jumbotron">
            
                <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                                            <div class="card-body row no-gutters align-items-center">
                                                                <div class="col-auto">
                                                                    <i class="fas fa-search h4 text-body"></i>
                                                                </div>
                                                                <div class="col">
                                                                    <input class="form-control form-control-lg form-control-borderless" type="search"  name ="keres">
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-lg btn-success" type="submit">Keres</button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body row no-gutters align-items-center">
                                                                    <div class="col">
                                                                            <div class="form-group">
                                                                                    <select class="form-control" id="selection" name="szarmaz">
                                                                                        <option>Összes</option>
                                                                                        <option>Magyar</option>
                                                                                        <option>Külföldi</option>     
                                                                                    </select>
                                                                            </div>
                                                                    </div>

                                                                    <div class="col">
                                                                            <div class="form-group">
                                                                                    <select class="form-control" id="selection" name="dont">
                                                                                        <option value="Dal">Dal</option>
                                                                                        <option value="Eloado">Előadó</option>  
                                                                                    </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col">
                                                                            <div class="form-group">
                                                                                    <select class="form-control" id="selection" name="tipus">
                                                                                        <option>Gitár</option>
                                                                                        <option>Basszus</option>
                                                                                          
                                                                                    </select>
                                                                            </div>
                                                                    </div>

                                                                </div>
                            </form>
                        </div>
                    </div>
        </div>

   <div class="jumbotron">
            
            <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div  class="card card-sm">
                                    <?php

                                        if ($_SERVER["REQUEST_METHOD"] == "POST") 
                                        {
                                            include("db_config.php"); 
                                            $select = "SELECT
                                                            kottak.cim,
                                                            kottak.kotta_ID
                                                        FROM kottak ";
                                            $where = " 
                                                    INNER JOIN eloadok
                                                        ON kottak.eloado = eloadok.eloado_ID 
                                                    WHERE ";

                                            $szarmazas = " ";
                                            $dont = " 1 = 1";
                                            $tipus = " ";

                                            if(isset($_POST["keres"])) //ha be van írva valami
                                            {
                                                    $valtozo = $_POST["keres"];

                                                    if($_POST["szarmaz"] == "Összes")
                                                    {
                                                       
                                                    }
                                                    else if($_POST["szarmaz"] == "Magyar")
                                                    {
                                                        $szarmazas = "szarmazas = 1 AND";
                                                    }
                                                    else if($_POST["szarmaz"] == "Külföldi")
                                                    {
                                                        $szarmazas = "szarmazas = 2 AND";
                                                    }

                                                        if($_POST["dont"] == "Dal" )
                                                        {
                                                            $dont = " kottak.cim LIKE '%$valtozo%' AND ";

                                                        }
                                                        else
                                                        {

                                                            $dont = "   kottak.eloado =  (  SELECT eloadok.eloado_ID
                                                                                            FROM eloadok
                                                                                            WHERE eloadok.eloado_nev LIKE '%$valtozo%') 
                                                                                            AND";
                                                        }

                                                    if($_POST["tipus"] == "Gitár")
                                                    {
                                                        $tipus = "tipus = 1 ";
                                                    }
                                                    else if($_POST["tipus"] == "Basszus")
                                                    {
                                                        $tipus = " tipus = 2";
                                                    }

                                            }
                                            else if($_POST["dont"] == "Előadó" )
                                            {
                                                $valtozo = $_POST["keres"];
                                                if($_POST["szarmaz"] == "Magyar")
                                                {
                                                    $szarmazas = "szarmazas = 1 AND";
                                                }
                                                else if($_POST["szarmaz"] == "Külföldi")
                                                {
                                                    $szarmazas = "szarmazas = 2 AND";
                                                }

                                                $dont = " kottak.cim LIKE '%$valtozo%' AND ";

                                                if($_POST["tipus"] == "Gitár")
                                                    {
                                                        $tipus = "tipus = 1 ";
                                                    }
                                                    else if($_POST["tipus"] == "Basszus")
                                                    {
                                                        $tipus = " tipus = 2";
                                                    }
                                            }
                                            
                                            $sql = " " . $select . " " . $where .  " ". $szarmazas . " " . $dont . " "  . $tipus . " ORDER BY kottak.cim";
                                            $result = $connection->query($sql);
                                            echo "<br><h4> &nbsp Találatok a keresett szóra:</h4><hr>";
                                            if ($result->num_rows > 0) 
                                            {
                                                while($row = $result->fetch_assoc())
                                                {
                                                    echo "
                                                        <form action=\"tab.php\" method=\"POST\">
                                                            <button type=\"submit\" class=\"button\" >"
                                                            . $row["cim"] .
                                                            "</button>
                                                            <input type=\"hidden\" value=\"" . $row["kotta_ID"] . "\" name=\"atadott_ID\">
                                                        </form>
                                                        <hr>"
                                                        
                                                        ;

                                                }
                                            } 
                                            else 
                                            {
                                                echo "
                                                <form> &nbsp Nincs találat </form>
                                                        <hr>";
                                            } 
                                            
                                        }
                                    ?>
                        </div>            
                    </div>
            </div>
    </div>
   </div>     
        
</body>
</html>


