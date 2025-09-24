<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)$_POST['id'];
  $st=$yhteys->prepare("UPDATE opettajat SET Etunimi=:e,Sukunimi=:s,Aine=:a WHERE opettajatunnus=:id");
  $st->execute([":e"=>$_POST['Etunimi'],":s"=>$_POST['Sukunimi'],":a"=>$_POST['Aine'],":id"=>$id]);
  echo "Tallennettu. <a href='naytaopettaja.php?id=$id'>Palaa</a>"; exit;
}

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$st=$yhteys->prepare("SELECT * FROM opettajat WHERE opettajatunnus=:id");
$st->execute([":id"=>$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
if(!$r){ die("Opettajaa ei löytynyt."); }
?>
<html><head><meta charset="utf-8"><title>Muokkaa opettajaa</title></head><body>
  <h2>Muokkaa opettajaa</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?=$id?>">
    Etunimi: <input name="Etunimi" value="<?=htmlspecialchars($r['Etunimi'])?>"><br><br>
    Sukunimi: <input name="Sukunimi" value="<?=htmlspecialchars($r['Sukunimi'])?>"><br><br>
    Aine: <input name="Aine" value="<?=htmlspecialchars($r['Aine'])?>"><br><br>
    <button type="submit">Tallenna</button>
  </form>
<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
