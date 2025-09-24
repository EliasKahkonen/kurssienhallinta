<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);
include("yhteys.php");

if (!isset($_POST["tilatunnus"])) {
    die("Virhe: tilatunnus puuttuu.");
}

$id = (int)$_POST["tilatunnus"];

try {
    $sql = "DELETE FROM tilat WHERE tilatunnus = :id";
    $stmt = $yhteys->prepare($sql);
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        echo "Mitään ei poistettu (id $id ei löytynyt).";
    } else {
        echo "Tila (id $id) poistettu.";
    }
} catch (PDOException $e) {

    if ($e->getCode() === "23000") {
        echo "Poisto estettiin: tämä tila on käytössä kurssissa. Poista ensin kyseiset kurssit
              tai vaihda niiden tila toiseksi.";
    } else {
        echo "VIRHE: " . $e->getMessage();
    }
}

echo '<p><b><a href="naytatila.php">Takaisin</b></a></p><br><br>';

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
