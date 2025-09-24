<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");

if (!isset($_POST["opiskelijatunnus"])) {
    die("Virhe: opiskelijatunnus puuttuu.");
}

$id = (int)$_POST["opiskelijatunnus"];

try {
    $sql = "DELETE FROM opiskelijat WHERE opiskelijatunnus = :id";
    $stmt = $yhteys->prepare($sql);
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        echo "Mitään ei poistettu (id $id ei löytynyt).";
    } else {
        echo "Opiskelija (id $id) poistettu.";
    }
} catch (PDOException $e) {
    if ($e->getCode() === "23000") {
        echo "Poisto estettiin: tämä opiskelija on kirjautuneena johonkin kurssiin.
              Poista ensin hänen kurssikirjautumisensa.";
    } else {
        echo "VIRHE: " . $e->getMessage();
    }
}

echo '<p><b><a href="naytaopiskelija.php">Takaisin</b></a></p><br><br>';

echo '<br><a href="listaopiskelijat.php">Takaisin opiskelijalistaan</a>';
