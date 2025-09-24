<?php 
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);
include("yhteys.php");  
$sql_lause =  "SELECT * FROM opettajat";
try {
  $kysely = $yhteys->prepare($sql_lause);
  $kysely->execute();
} 
 catch (PDOException $e) {
            die("VIRHE: " . $e->getMessage());
       }
$tulos = $kysely->fetchAll();
foreach ($tulos as $rivi) {
  $etunimi = htmlspecialchars($rivi['Etunimi']);
  $sukunimi = htmlspecialchars($rivi['Sukunimi']);
  $aine = htmlspecialchars($rivi['Aine']);
  $id = (int)$rivi['opettajatunnus'];

  echo "<br><strong>{$etunimi} {$sukunimi}</strong><br>";
  echo "Aine: {$aine}<br>";
  echo "Opettajan tunnus: {$id}<br><br>";

  echo ' <a href="naytaopettaja.php?id='.(int)$rivi['opettajatunnus'].'">Näytä</a>';
  echo ' | <a href="muokkaaopettaja.php?id='.(int)$rivi['opettajatunnus'].'">Muokkaa</a><br><br>';
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';


