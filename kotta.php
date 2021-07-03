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



    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {  
        if(isset($_POST["cim"]) && isset($_POST["eloado"]) &&  isset($_POST["kotta_text"]))
        {
            include("db_config.php");

            $cim = $_POST["cim"];
            $eloado = $_POST["eloado"];
            $tipus = $_POST["tipus"];
            $orszag = $_POST["radio"];
            var_dump($orszag);
            echo $_POST["radio"];
           
            $sql = "SELECT * FROM kottak WHERE kottak.cim = '$cim';";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) 
                {
                    echo "Ilyen kotta már létezik";
                }
                else
                {
                    //eloadó
                    $sql_eloado = "SELECT eloadok.eloado_ID
                            FROM eloadok
                            WHERE eloadok.eloado_nev LIKE '%$eloado%'
                            ";
                    $result = $connection->query($sql_eloado);
                    if ($result->num_rows > 0)
                    {
                        echo "Ilyen előadó is van már" ;// ezzel fog tovább dolgozni a program
                        $row = $result->fetch_assoc();
                        $eloado_ID = $row["eloado_ID"]; 
                    }
                    else
                    {
                        $sql_eloado_insert = "INSERT INTO eloadok (eloado_nev) VALUES ('$eloado');";
                        $connection->query($sql_eloado_insert);
                        $sql = "SELECT eloadok.eloado_ID
                                FROM eloadok
                                WHERE eloadok.eloado_nev = '$eloado';";
                        $result = $connection->query($sql);
                        $row = $result->fetch_assoc();
                        $eloado_ID = $row["eloado_ID"]; 
                    }
                    //tipus
                    $sql_tipus = "SELECT tipusok.tipus_ID FROM tipusok WHERE tipusok.tipus = '$tipus';";
                    $result = $connection->query($sql_tipus);
                    $row = $result->fetch_assoc();
                    $tipus_ID = $row["tipus_ID"]; 
                    
                    //Az orszag alapból 1-es vagy 2-es ID-t kap
                    
                    //kotta 
                    
                    
                    $newFileName = 'kottak/temporary.txt';
                    
                    $text = trim($_POST['kotta_text']);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                    $newFileContent = "";
                    foreach ($textAr as $line) {
                            $resStr = str_replace(' ', '    ', $line); 
                            $newFileContent = $newFileContent . $resStr . PHP_EOL;
                    } 

                    if (file_put_contents($newFileName, $newFileContent) !== false) 
                    {
                        echo "File created (" . basename($newFileName) . ")";
                    } 
                    else 
                    {
                        echo "Cannot create file (" . basename($newFileName) . ")";
                    }

                    $sql_max = "SELECT MAX(kottak.kotta_ID) AS last_ID FROM kottak";
                    $result = $connection->query($sql_max);
                    $row = $result->fetch_assoc();
                    $last_ID = $row["last_ID"] +1; 
                    var_dump($last_ID);
                    $filename = "kottak/".$last_ID.".txt";
                    rename($newFileName, $filename );
                    //feltöltő user
                    $user = $_SESSION['username'];
                    $sql = "SELECT users.userID
                    FROM users
                    WHERE users.username = '$user';";
                    $sor = $connection->query($sql)->fetch_assoc();
                    $_postby = $sor["userID"] ;
                    var_dump($_postby);

                    if(isset($_POST["yt_link"]))
                    {
                        $yt_link = $_POST["yt_link"];
                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $yt_link, $matches);
                        $link = 'https://www.youtube.com/embed/'.$matches[1];
                        $kotta_insert = "   INSERT INTO guitar.kottak (cim,eloado,tipus, szarmazas,eleresi_ut, kotta_by,yt_link) 
                        VALUES ('$cim', $eloado_ID, $tipus_ID, $orszag, '$filename', $_postby, '$link');";
                        var_dump($link);
                    }
                    else
                    {
                        $kotta_insert = "   INSERT INTO guitar.kottak (cim,eloado,tipus, szarmazas,eleresi_ut, kotta_by) 
                        VALUES ('$cim', $eloado_ID, $tipus_ID, $orszag, '$filename', $_postby);";
                    }

                    $result = $connection->query($kotta_insert);
                    echo $kotta_insert;
                    echo "Siker";
                    header("location: search.php");
                }

            }
            else
            {
                echo "Sikertelen";
            }
       }



?>