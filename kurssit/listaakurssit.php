<?php 
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);
include("yhteys.php");

$sql_lause = "
  SELECT 
    k.ainetunnus,
    k.Nimi,
    k.Kuvaus,
    k.Alkupäivä,
    k.Loppupäivä,
    o.Etunimi AS opettaja_etunimi,
    o.Sukunimi AS opettaja_sukunimi,
    t.nimi AS tila_nimi
  FROM kurssit k
  JOIN opettajat o ON k.opettaja_id = o.opettajatunnus
  JOIN tilat t ON k.tila_id = t.tilatunnus
  ORDER BY k.ainetunnus ASC
";

try {
  $kysely = $yhteys->prepare($sql_lause);
  $kysely->execute();
} catch (PDOException $e) {
  die("VIRHE: " . $e->getMessage());
}

$tulos = $kysely->fetchAll(PDO::FETCH_ASSOC);

foreach ($tulos as $rivi) {
  $opettaja_nimi = $rivi['opettaja_etunimi'] . " " . $rivi['opettaja_sukunimi'];

  echo "<br><strong>{$rivi['Nimi']}</strong><br>";
  echo "Kuvaus: {$rivi['Kuvaus']}<br>";
  echo "Alkupäivä: {$rivi['Alkupäivä']}<br>";
  echo "Loppupäivä: {$rivi['Loppupäivä']}<br>";
  echo "Opettaja: {$opettaja_nimi}<br>";
  echo "Tila: {$rivi['tila_nimi']}<br><br>";
  
  echo ' <a href="naytakurssi.php?id='.(int)$rivi['ainetunnus'].'">Näytä</a>';
  echo ' | <a href="muokkaakurssi.php?id='.(int)$rivi['ainetunnus'].'">Muokkaa</a><br><br>';
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';



