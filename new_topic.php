<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        include("db_config.php");
        $_topic_nev = $_POST["nev"];
        $_topic_leiras = $_POST["leiras"];
        $_topic_date = date("Y-m-d h:i:s");
        $_topic_by = $_POST["letrehozo_id"];

        $sql =  "INSERT INTO topics (topic_subject,topic_date, topic_by, topic_desc)
                        VALUES('$_topic_nev', NOW() , $_topic_by, '$_topic_leiras');";


        if($connection->query($sql))
        {
            header("location: forum.php");
            $message = "Bejegyzés sikeresen létrehozva";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }                                                                  
        else
        {
            $message = "Bejegyzés nem lett létrehozva! Próbáld meg később";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
       
    }
?>