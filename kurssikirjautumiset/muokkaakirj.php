<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)$_POST['id'];
  $st=$yhteys->prepare("UPDATE kurssikirjautumiset SET kirjautumispaiva=:p WHERE kirjautumistunnus=:id");
  $st->execute([":p"=>$_POST['kirjautumispaiva'],":id"=>$id]);
  echo "Tallennettu. <a href='listaakurssikirj.php'>Palaa</a>"; exit;
}

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$st=$yhteys->prepare("SELECT * FROM kurssikirjautumiset WHERE kirjautumistunnus=:id");
$st->execute([":id"=>$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
if(!$r){ die("Kirjautumista ei löytynyt."); }
?>
<html><head><meta charset="utf-8"><title>Muokkaa kirjautumista</title></head><body>
  <h2>Muokkaa kurssikirjautumista</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?=$id?>">
    Kirjautumispäivä: <input type="date" name="kirjautumispaiva" value="<?=htmlspecialchars($r['kirjautumispaiva'])?>"><br><br>
    <button type="submit">Tallenna</button>
  </form>
<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
