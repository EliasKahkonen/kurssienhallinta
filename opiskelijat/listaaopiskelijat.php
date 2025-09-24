<?php 
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);
include("yhteys.php");  
$sql_lause =  "SELECT * FROM opiskelijat";
try {
  $kysely = $yhteys->prepare($sql_lause);
  $kysely->execute();
} 
 catch (PDOException $e) {
            die("VIRHE: " . $e->getMessage());
       }
$tulos = $kysely->fetchAll();
foreach ($tulos as $rivi) {
  $etunimi  = htmlspecialchars($rivi['Etunimi']);
  $sukunimi = htmlspecialchars($rivi['Sukunimi']);
  $syntyma  = htmlspecialchars($rivi['Syntymäpäivä']);
  $vuosikurssi = (int)$rivi['Vuosikurssi'];
  $id = (int)$rivi['opiskelijatunnus'];

  echo "<br><strong>{$etunimi} {$sukunimi}</strong><br>";
  echo "Syntymäpäivä: {$syntyma}<br>";
  echo "Vuosikurssi: {$vuosikurssi}<br>";
  echo "Opiskelijan tunnus: {$id}<br><br>";

  echo ' <a href="naytaopiskelija.php?id='.(int)$rivi['opiskelijatunnus'].'">Näytä</a>';
  echo ' | <a href="muokkaaopiskelija.php?id='.(int)$rivi['opiskelijatunnus'].'">Muokkaa</a><br><br>';
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';

