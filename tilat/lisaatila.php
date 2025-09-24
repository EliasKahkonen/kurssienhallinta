<?php
include("yhteys.php");
if (isset($_POST["nimi"])) {
    $annettunimi = $_POST["nimi"];
} else {
    die("Nimi puuttuu!");
}

if ( isset($_POST["kapasiteetti"]) ) {
$annettukapasiteetti = $_POST["kapasiteetti"];
} else {
    die("Kapasiteetti puuttuu!");
}

$sql = "INSERT INTO tilat (nimi, kapasiteetti, tilatunnus)
        VALUES (:annettunimi, :annettukapasiteetti, NULL)";
try { 
    $kysely = $yhteys->prepare($sql); 
    $kysely->execute([
        "annettunimi" => $annettunimi,
        "annettukapasiteetti" => $annettukapasiteetti
    ]);
} catch (PDOException $e) { 
    die("VIRHE: " . $e->getMessage()); 
} 

echo "Tila $annettunimi lisätty!";
echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>
