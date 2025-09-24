<?php
include("yhteys.php");

$annettuetunimi = $_POST["Nimi"];
$annettukuvaus = $_POST["Kuvaus"];
$annettualkupaiva = $_POST["Alkupäivä"];
$annettuloppupaiva = $_POST["Loppupäivä"];
$annettuopettaja = $_POST["opettaja_id"];
$annettutila = $_POST["tila_id"];

$sql = "INSERT INTO kurssit (Nimi, Kuvaus, Alkupäivä, Loppupäivä, opettaja_id, tila_id, ainetunnus)
        VALUES (:annettuetunimi, :annettukuvaus, :annettualkupaiva, :annettuloppupaiva, :annettuopettaja, :annettutila, NULL)";
try { 
    $kysely = $yhteys->prepare($sql); 
    $kysely->execute([
        "annettuetunimi" => $annettuetunimi,
        "annettukuvaus" => $annettukuvaus,
        "annettualkupaiva" => $annettualkupaiva,
        "annettuloppupaiva" => $annettuloppupaiva,
        "annettuopettaja" => $annettuopettaja,
        "annettutila" => $annettutila
        
    ]);
} catch (PDOException $e) { 
    die("VIRHE: " . $e->getMessage()); 
} 

echo "Kurssi $annettuetunimi lisätty!";
echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>
