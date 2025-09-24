<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$st = $yhteys->prepare("SELECT * FROM opiskelijat WHERE opiskelijatunnus=:id");
$st->execute([":id"=>$id]); $o=$st->fetch(PDO::FETCH_ASSOC);
if(!$o){ die("Opiskelijaa ei löytynyt."); }

$sql = "
SELECT k.ainetunnus, k.Nimi, k.Alkupäivä
FROM kurssikirjautumiset kk
JOIN kurssit k ON kk.kurssi_id=k.ainetunnus
WHERE kk.opiskelija_id=:id
ORDER BY k.Alkupäivä";
$st2=$yhteys->prepare($sql); $st2->execute([":id"=>$id]); $kurssit=$st2->fetchAll(PDO::FETCH_ASSOC);
?>
<html><head><meta charset="utf-8"><title>Opiskelija</title></head><body>
  <h2><?= htmlspecialchars($o['Etunimi'].' '.$o['Sukunimi']) ?></h2>
  <div>Syntymäpäivä: <?= htmlspecialchars($o['Syntymäpäivä']) ?></div>
  <div>Vuosikurssi: <?= (int)$o['Vuosikurssi'] ?></div>

  <h3>Kurssit</h3>
  <?php if(!$kurssit){ echo "Ei kirjautumisia."; } else {
    foreach($kurssit as $k){
      echo htmlspecialchars($k['Nimi'])." — Alkaa: ".htmlspecialchars($k['Alkupäivä'])."<br>";
    }
  } ?>
  <p><a href="muokkaaopiskelija.php?id=<?=$id?>">Muokkaa</a> | <a href="poistaopiskelija.html">Poista</a> | <a href="listaaopiskelijat.php">Takaisin</a></p>

<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
