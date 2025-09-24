<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$st=$yhteys->prepare("SELECT * FROM tilat WHERE tilatunnus=:id");
$st->execute([":id"=>$id]); $t=$st->fetch(PDO::FETCH_ASSOC);
if(!$t){ die("Tilaa ei löytynyt."); }

$sql="
SELECT k.ainetunnus,k.Nimi,k.Alkupäivä,k.Loppupäivä,
       CONCAT(o.Etunimi,' ',o.Sukunimi) AS opettaja_nimi,
       COUNT(kk.kirjautumistunnus) AS osallistujat
FROM kurssit k
JOIN opettajat o ON k.opettaja_id=o.opettajatunnus
LEFT JOIN kurssikirjautumiset kk ON kk.kurssi_id=k.ainetunnus
WHERE k.tila_id=:id
GROUP BY k.ainetunnus
ORDER BY k.Alkupäivä";
$st2=$yhteys->prepare($sql); $st2->execute([":id"=>$id]); $kurssit=$st2->fetchAll(PDO::FETCH_ASSOC);

$kap = (int)$t['kapasiteetti'];
?>
<html><head><meta charset="utf-8"><title>Tila</title></head><body>
  <h2><?= htmlspecialchars($t['nimi']) ?></h2>
  <div>Kapasiteetti: <?= $kap ?></div>

  <h3>Kurssit tässä tilassa</h3>
  <?php if(!$kurssit){ echo "Ei kursseja."; } else {
    foreach($kurssit as $k){
      $warn = ((int)$k['osallistujat'] > $kap) ? " ⚠️" : "";
      echo htmlspecialchars($k['Nimi'])." — Opettaja: ".htmlspecialchars($k['opettaja_nimi']).
           " — Alku: ".htmlspecialchars($k['Alkupäivä']).", Loppu: ".htmlspecialchars($k['Loppupäivä']).
           " — Osallistujia: ".(int)$k['osallistujat'].$warn."<br>";
    }
  } ?>
  <p><a href="muokkaatila.php?id=<?=$id?>">Muokkaa</a> | <a href="listaatilat.php">Takaisin</a></p>

<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
