<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$st=$yhteys->prepare("SELECT * FROM opettajat WHERE opettajatunnus=:id");
$st->execute([":id"=>$id]); $op=$st->fetch(PDO::FETCH_ASSOC);
if(!$op){ die("Opettajaa ei löytynyt."); }

$sql="
SELECT k.ainetunnus,k.Nimi,k.Alkupäivä,k.Loppupäivä,t.nimi AS tila_nimi
FROM kurssit k
JOIN tilat t ON k.tila_id=t.tilatunnus
WHERE k.opettaja_id=:id
ORDER BY k.Alkupäivä";
$st2=$yhteys->prepare($sql); $st2->execute([":id"=>$id]); $kurssit=$st2->fetchAll(PDO::FETCH_ASSOC);
?>
<html><head><meta charset="utf-8"><title>Opettaja</title></head><body>
  <h2><?= htmlspecialchars($op['Etunimi'].' '.$op['Sukunimi']) ?></h2>
  <div>Aine: <?= htmlspecialchars($op['Aine']) ?></div>

  <h3>Kurssit</h3>
  <?php if(!$kurssit){ echo "Ei kursseja."; } else {
    foreach($kurssit as $k){
      echo htmlspecialchars($k['Nimi'])." — ".
           "Alku: ".htmlspecialchars($k['Alkupäivä']).", ".
           "Loppu: ".htmlspecialchars($k['Loppupäivä']).", ".
           "Tila: ".htmlspecialchars($k['tila_nimi'])."<br>";
    }
  } ?>
  <p><a href="muokkaaopettaja.php?id=<?=$id?>">Muokkaa</a> | <a href="poistaopettaja.html">Poista</a> | <a href="listaaopettajat.php">Takaisin</a></p>

<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
