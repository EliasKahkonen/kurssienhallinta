<?php
$servername = "localhost";
$db = "kurssienhallinta";
$username = "root";
$password = ""; 
try {
       $yhteys = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
       $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Yhteys muodostettu<br>";
    }
catch(PDOException $e)
    {
    echo "Ei yhteytt� tietokantaan!<br> " . $e->getMessage();
    }
?>
