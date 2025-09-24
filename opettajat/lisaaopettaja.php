<?php
include("yhteys.php");

$annettuetunimi = $_POST["Etunimi"];
$annettusukunimi = $_POST["Sukunimi"];
$annettuaine = $_POST["Aine"];

$sql = "INSERT INTO opettajat (Etunimi, Sukunimi, Aine, opettajatunnus)
        VALUES (:annettuetunimi, :annettusukunimi, :annettuaine, NULL)";
try { 
    $kysely = $yhteys->prepare($sql); 
    $kysely->execute([
        "annettuetunimi" => $annettuetunimi,
        "annettusukunimi" => $annettusukunimi,
        "annettuaine" => $annettuaine,
    ]);
} catch (PDOException $e) { 
    die("VIRHE: " . $e->getMessage()); 
} 

echo "Opettaja $annettuetunimi $annettusukunimi lisätty!";
echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>
