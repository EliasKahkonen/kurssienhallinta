<?php
@ini_set("display_errors", 1);
@ini_set("error_reporting", E_ALL);

include("yhteys.php");

if (!isset($_POST["opettajatunnus"])) {
    die("Virhe: opettajatunnus puuttuu.");
}

$id = (int)$_POST["opettajatunnus"];

try {
    $sql = "DELETE FROM opettajat WHERE opettajatunnus = :id";
    $stmt = $yhteys->prepare($sql);
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() === 0) {
        echo "Mitään ei poistettu (id $id ei löytynyt).";
    } else {
        echo "Opettaja (id $id) poistettu.";
    }
} catch (PDOException $e) {
    // 23000 = viite-eheyden rikkominen (FK)
    if ($e->getCode() === "23000") {
        echo "Poisto estettiin: tällä opettajalla on kursseja (kurssit.opettaja_id viittaa häneen). "
           . "Poista tai siirrä ensin kyseiset kurssit toiselle opettajalle.";
    } else {
        echo "VIRHE: " . $e->getMessage();
    }
}

echo '<p><b><a href="naytaopettaja.php">Takaisin</b></a></p><br><br>';

echo '<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>';
