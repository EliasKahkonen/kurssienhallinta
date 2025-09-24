<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");

if (!isset($_POST["kirjautumistunnus"])) {
  die("Virhe: kirjautumistunnus puuttuu.");
}

$id = (int)$_POST["kirjautumistunnus"];

try {
  $sql = "DELETE FROM kurssikirjautumiset WHERE kirjautumistunnus = :id";
  $stmt = $yhteys->prepare($sql);
  $stmt->execute([":id" => $id]);

  if ($stmt->rowCount() === 0) {
    echo "Mitään ei poistettu (id $id ei löytynyt).";
  } else {
    echo "Kurssikirjautuminen (id $id) poistettu.";
  }
} catch (PDOException $e) {
  echo "VIRHE: " . $e->getMessage();
}

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
