
<?php 
// LISTAA TILAT

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

echo "<h2>Tilat</h2>";

foreach ($tulos as $rivi) {
  $nimi = htmlspecialchars($rivi['nimi']);
  $kap  = (int)$rivi['kapasiteetti'];
  $id   = (int)$rivi['tilatunnus'];

  echo "<br><strong>{$nimi}</strong><br>";
  echo "Kapasiteetti: {$kap}<br>";
  echo "Tilan tunnus: {$id}<br><br>";
}
?>

<?php
//LISTAA OPISKELIJAT
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

echo "<h2>Opiskelijat</h2>";

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
}
?>

<?php 
// LISTAA OPETTAJAT
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

echo "<h2>Opettajat</h2>";

foreach ($tulos as $rivi) {
  $etunimi = htmlspecialchars($rivi['Etunimi']);
  $sukunimi = htmlspecialchars($rivi['Sukunimi']);
  $aine = htmlspecialchars($rivi['Aine']);
  $id = (int)$rivi['opettajatunnus'];

  echo "<br><strong>{$etunimi} {$sukunimi}</strong><br>";
  echo "Aine: {$aine}<br>";
  echo "Opettajan tunnus: {$id}<br><br>";
}
?>

<?php 
//LISTAA KURSSIT
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

echo "<h2>Kurssit</h2>";

foreach ($tulos as $rivi) {
  $opettaja_nimi = $rivi['opettaja_etunimi'] . " " . $rivi['opettaja_sukunimi'];

  echo "<br><strong>{$rivi['Nimi']}</strong><br>";
  echo "Kuvaus: {$rivi['Kuvaus']}<br>";
  echo "Alkupäivä: {$rivi['Alkupäivä']}<br>";
  echo "Loppupäivä: {$rivi['Loppupäivä']}<br>";
  echo "Opettaja: {$opettaja_nimi}<br>";
  echo "Tila: {$rivi['tila_nimi']}<br>";
}
?>

<?php
//LISTAA KURSSIKIRJAUTUMISET
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

echo "<h2>Kurssikirjautumiset</h2>";

foreach ($tulos as $rivi) {
  $opiskelija = htmlspecialchars($rivi['opiskelija_nimi']);
  $kurssi     = htmlspecialchars($rivi['kurssi_nimi']);
  $paiva      = htmlspecialchars($rivi['kirjautumispaiva']);
  $id         = (int)$rivi['kirjautumistunnus'];

  echo "<br><strong>{$opiskelija}</strong><br>";
  echo "Kurssi: {$kurssi}<br>";
  echo "Kirjautumispäivä: {$paiva}<br>";
  echo "Kirjautumisen tunnus: {$id}<br><br>";
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>

