<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $id=(int)$_POST['id'];
  $sql="UPDATE kurssit SET Nimi=:n,Kuvaus=:k,Alkupäivä=:a,Loppupäivä=:l,opettaja_id=:o,tila_id=:t WHERE ainetunnus=:id";
  $st=$yhteys->prepare($sql);
  $st->execute([
    ":n"=>$_POST['Nimi'],":k"=>$_POST['Kuvaus'],":a"=>$_POST['Alkupäivä'],":l"=>$_POST['Loppupäivä'],
    ":o"=>(int)$_POST['opettaja_id'],":t"=>(int)$_POST['tila_id'],":id"=>$id
  ]);
  echo "Tallennettu. <a href='naytakurssi.php?id=$id'>Palaa</a>"; exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$st=$yhteys->prepare("SELECT * FROM kurssit WHERE ainetunnus=:id");
$st->execute([":id"=>$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
if(!$r){ die("Kurssia ei löytynyt."); }
?>
<html><head><meta charset="utf-8"><title>Muokkaa kurssia</title></head><body>
  <h2>Muokkaa kurssia</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?=$id?>">
    Nimi: <input type="text" name="Nimi" value="<?=htmlspecialchars($r['Nimi'])?>"><br><br>
    Kuvaus: <input type="text" name="Kuvaus" value="<?=htmlspecialchars($r['Kuvaus'])?>"><br><br>
    Alku: <input type="date" name="Alkupäivä" value="<?=htmlspecialchars($r['Alkupäivä'])?>"><br><br>
    Loppu: <input type="date" name="Loppupäivä" value="<?=htmlspecialchars($r['Loppupäivä'])?>"><br><br>
    Opettaja ID: <input type="number" name="opettaja_id" value="<?= (int)$r['opettaja_id'] ?>"><br><br>
    Tila ID: <input type="number" name="tila_id" value="<?= (int)$r['tila_id'] ?>"><br><br>
    <button type="submit">Tallenna</button>
  </form>
<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
