<?php
include("yhteys.php");

$annettuetunimi = $_POST["Etunimi"];
$annettusukunimi = $_POST["Sukunimi"];
$annettusyntymapaiva = $_POST["Syntymäpäivä"];
$annettuvuosikurssi = $_POST["Vuosikurssi"];


$sql = "INSERT INTO opiskelijat (Etunimi, Sukunimi, Syntymäpäivä, Vuosikurssi, opiskelijatunnus)
        VALUES (:annettuetunimi, :annettusukunimi, :annettusyntymapaiva, :annettuvuosikurssi, NULL)";
try { 
    $kysely = $yhteys->prepare($sql); 
    $kysely->execute([
        "annettuetunimi" => $annettuetunimi,
        "annettusukunimi" => $annettusukunimi,
        "annettusyntymapaiva" => $annettusyntymapaiva,
        "annettuvuosikurssi" => $annettuvuosikurssi
    ]);
} catch (PDOException $e) { 
    die("VIRHE: " . $e->getMessage()); 
} 

echo "Opiskelija $annettuetunimi $annettusukunimi lisätty!";
echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>
