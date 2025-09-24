<?php
@ini_set("display_errors",1); @ini_set("error_reporting",E_ALL);
include("../yhteys.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)$_POST['id'];
  $st=$yhteys->prepare("UPDATE tilat SET nimi=:n,kapasiteetti=:k WHERE tilatunnus=:id");
  $st->execute([":n"=>$_POST['nimi'],":k"=>(int)$_POST['kapasiteetti'],":id"=>$id]);
  echo "Tallennettu. <a href='naytatila.php?id=$id'>Palaa</a>"; exit;
}

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$st=$yhteys->prepare("SELECT * FROM tilat WHERE tilatunnus=:id");
$st->execute([":id"=>$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
if(!$r){ die("Tilaa ei löytynyt."); }
?>
<html><head><meta charset="utf-8"><title>Muokkaa tilaa</title></head><body>
  <h2>Muokkaa tilaa</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?=$id?>">
    Nimi: <input name="nimi" value="<?=htmlspecialchars($r['nimi'])?>"><br><br>
    Kapasiteetti: <input type="number" name="kapasiteetti" value="<?= (int)$r['kapasiteetti'] ?>"><br><br>
    <button type="submit">Tallenna</button>
  </form>
<p><a href="/kurssienhallinta">Takaisin etusivulle</a></p>
</body></html>
