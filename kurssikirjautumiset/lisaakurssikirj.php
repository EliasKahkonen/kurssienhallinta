<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");

$opiskelija_id     = $_POST["opiskelija_id"];
$kurssi_id         = $_POST["kurssi_id"];
$kirjautumispaiva  = $_POST["kirjautumispaiva"];

$sql = "INSERT INTO kurssikirjautumiset (opiskelija_id, kurssi_id, kirjautumispaiva, kirjautumistunnus)
        VALUES (:opiskelija_id, :kurssi_id, :kirjautumispaiva, NULL)";
try {
  $kysely = $yhteys->prepare($sql);
  $kysely->execute([
    "opiskelija_id"    => $opiskelija_id,
    "kurssi_id"        => $kurssi_id,
    "kirjautumispaiva" => $kirjautumispaiva
  ]);
} catch (PDOException $e) {
  die("VIRHE: " . $e->getMessage());
}

echo "Kurssikirjautuminen lisätty!";
echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
?>
