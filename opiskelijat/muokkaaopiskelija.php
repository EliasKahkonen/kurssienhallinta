<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)$_POST['id'];
  $st=$yhteys->prepare("UPDATE opiskelijat SET Etunimi=:e,Sukunimi=:s,Syntymäpäivä=:p,Vuosikurssi=:v WHERE opiskelijatunnus=:id");
  $st->execute([":e"=>$_POST['Etunimi'],":s"=>$_POST['Sukunimi'],":p"=>$_POST['Syntymäpäivä'],":v"=>(int)$_POST['Vuosikurssi'],":id"=>$id]);
  echo "Tallennettu. <a href='naytaopiskelija.php?id=$id'>Palaa</a>"; exit;
}

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$st=$yhteys->prepare("SELECT * FROM opiskelijat WHERE opiskelijatunnus=:id");
$st->execute([":id"=>$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
if(!$r){ die("Opiskelijaa ei löytynyt."); }
?>
<html><head><meta charset="utf-8"><title>Muokkaa opiskelijaa</title></head><body>
  <h2>Muokkaa opiskelijaa</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?=$id?>">
    Etunimi: <input name="Etunimi" value="<?=htmlspecialchars($r['Etunimi'])?>"><br><br>
    Sukunimi: <input name="Sukunimi" value="<?=htmlspecialchars($r['Sukunimi'])?>"><br><br>
    Syntymäpäivä: <input type="date" name="Syntymäpäivä" value="<?=htmlspecialchars($r['Syntymäpäivä'])?>"><br><br>
    Vuosikurssi: <input type="number" name="Vuosikurssi" value="<?= (int)$r['Vuosikurssi'] ?>"><br><br>
    <button type="submit">Tallenna</button>
  </form>
<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
