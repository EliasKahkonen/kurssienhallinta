<?php 
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");  

$sql_lause =  "SELECT * FROM tilat ORDER BY tilatunnus ASC";
try {
  $kysely = $yhteys->prepare($sql_lause);
  $kysely->execute();
} catch (PDOException $e) {
  die("VIRHE: " . $e->getMessage());
}

$tulos = $kysely->fetchAll(PDO::FETCH_ASSOC);

foreach ($tulos as $rivi) {
  $nimi = htmlspecialchars($rivi['nimi']);
  $kap  = (int)$rivi['kapasiteetti'];
  $id   = (int)$rivi['tilatunnus'];

  echo "<br><strong>{$nimi}</strong><br>";
  echo "Kapasiteetti: {$kap}<br>";
  echo "Tilan tunnus: {$id}<br><br>";
  
  echo ' <a href="naytatila.php?id='.(int)$rivi['tilatunnus'].'">Näytä</a>';
  echo ' | <a href="muokkaatila.php?id='.(int)$rivi['tilatunnus'].'">Muokkaa</a><br><br>';
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';




