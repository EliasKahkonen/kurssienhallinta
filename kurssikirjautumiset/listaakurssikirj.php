<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);
include("yhteys.php");

$sql = "
  SELECT
    kk.kirjautumistunnus,
    kk.kirjautumispaiva,
    CONCAT(o.Etunimi, ' ', o.Sukunimi) AS opiskelija_nimi,
    k.Nimi AS kurssi_nimi
  FROM kurssikirjautumiset kk
  JOIN opiskelijat o ON kk.opiskelija_id = o.opiskelijatunnus
  JOIN kurssit k     ON kk.kurssi_id     = k.ainetunnus
  ORDER BY kk.kirjautumistunnus ASC
";

try {
  $kysely = $yhteys->prepare($sql);
  $kysely->execute();
} catch (PDOException $e) {
  die("VIRHE: " . $e->getMessage());
}

$tulos = $kysely->fetchAll(PDO::FETCH_ASSOC);

foreach ($tulos as $rivi) {
  $opiskelija = htmlspecialchars($rivi['opiskelija_nimi']);
  $kurssi     = htmlspecialchars($rivi['kurssi_nimi']);
  $paiva      = htmlspecialchars($rivi['kirjautumispaiva']);
  $id         = (int)$rivi['kirjautumistunnus'];

  echo "<br><strong>{$opiskelija}</strong><br>";
  echo "Kurssi: {$kurssi}<br>";
  echo "Kirjautumispäivä: {$paiva}<br>";
  echo "Kirjautumisen tunnus: {$id}<br><br>";
  echo ' <a href="naytakirj.php?id='.(int)$id.'">Näytä</a>';
  echo ' | <a href="muokkaakirj.php?id='.(int)$id.'">Muokkaa</a><br><br>';

  echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
  
}

