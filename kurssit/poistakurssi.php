<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");

if (!isset($_POST["ainetunnus"])) {
    die("Virhe: ainetunnus puuttuu.");
}

$id = (int)$_POST["ainetunnus"];

try {
    $sql = "DELETE FROM kurssit WHERE ainetunnus = :id";
    $stmt = $yhteys->prepare($sql);
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        echo "Mitään ei poistettu (id $id ei löytynyt).";
    } else {
        echo "Kurssi (id $id) poistettu.";
    }
} catch (PDOException $e) {
    // 23000 = viite-eheyden rikkominen (FK)
    if ($e->getCode() === "23000") {
        echo "Poisto estettiin: tällä kurssilla on opiskelijoiden kirjautumisia (kurssikirjautumiset-taulu viittaa tähän kurssiin). "
           . "Poista ensin kurssin kirjautumiset.";
    } else {
        echo "VIRHE: " . $e->getMessage();
    }
}

echo '<p><b><a href="naytaopettaja.php">Takaisin</b></a></p><br><br>';

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
