<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kurssin perustiedot + opettaja + tila
$sql = "
SELECT k.ainetunnus,k.Nimi,k.Kuvaus,k.Alkupäivä,k.Loppupäivä,
       CONCAT(o.Etunimi,' ',o.Sukunimi) AS opettaja_nimi,
       t.nimi AS tila_nimi
FROM kurssit k
JOIN opettajat o ON k.opettaja_id=o.opettajatunnus
JOIN tilat t ON k.tila_id=t.tilatunnus
WHERE k.ainetunnus=:id";
$st = $yhteys->prepare($sql); $st->execute([":id"=>$id]);
$kurssi = $st->fetch(PDO::FETCH_ASSOC);
if(!$kurssi){ die("Kurssia ei löytynyt."); }

// Kurssin opiskelijat
$sql2 = "
SELECT s.opiskelijatunnus, s.Etunimi, s.Sukunimi, s.Vuosikurssi
FROM kurssikirjautumiset kk
JOIN opiskelijat s ON kk.opiskelija_id=s.opiskelijatunnus
WHERE kk.kurssi_id=:id
ORDER BY s.Sukunimi, s.Etunimi";
$st2 = $yhteys->prepare($sql2); $st2->execute([":id"=>$id]);
$opisk = $st2->fetchAll(PDO::FETCH_ASSOC);
?>
<html><head><meta charset="utf-8"><title>Kurssi</title></head><body>
  <h2><?= htmlspecialchars($kurssi['Nimi']) ?></h2>
  <div>Kuvaus: <?= htmlspecialchars($kurssi['Kuvaus']) ?></div>
  <div>Alku: <?= htmlspecialchars($kurssi['Alkupäivä']) ?> | Loppu: <?= htmlspecialchars($kurssi['Loppupäivä']) ?></div>
  <div>Opettaja: <?= htmlspecialchars($kurssi['opettaja_nimi']) ?></div>
  <div>Tila: <?= htmlspecialchars($kurssi['tila_nimi']) ?></div>

  <h3>Ilmoittautuneet opiskelijat</h3>
  <?php if(!$opisk){ echo "Ei ilmoittautuneita."; } else {
    foreach($opisk as $s){
      echo htmlspecialchars($s['Etunimi']." ".$s['Sukunimi'])." — Vuosikurssi: ".(int)$s['Vuosikurssi']."<br>";
    }
  } ?>
  <p><a href="muokkaakurssi.php?id=<?=$id?>">Muokkaa kurssia</a> | <a href="poistakurssi.html">Poista</a> | <a href="listaakurssit.php">Takaisin</a></p>

<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
