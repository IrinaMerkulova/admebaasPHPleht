<?php
require_once ('connect.php');
global $yhendus;
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}
// andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare(
        "INSERT INTO loomad(loomanimi, vanus, pilt) Values (?,?,?)"
    );
    $paring->bind_param("sis", $_REQUEST["nimi"], $_REQUEST["vanus"], $_REQUEST["pilt"]);
    //"s" - string, $_REQUEST["nimi"] - tekstkasti nimega nimi pöördumine
    //sdi, s-string, d-double, i-integer
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");

}
// kustutamine tabelist



?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomad</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Loomad</h1>
<div id="meny">
    <ul>
    <?php
    //näitab loomade loetelu tabelist loomad
    $paring=$yhendus->prepare("SELECT id, loomanimi FROM loomad");
    $paring->bind_result($id, $nimi);
    $paring->execute();

        while($paring->fetch()) {
        echo "<li><a href='$_SERVER[PHP_SELF]?id=$id'>$nimi</a></li>";
        }
        echo "</ul>";
        echo "<a href='$_SERVER[PHP_SELF]?lisaloom=jah'>Lisa Loom</a>";
    ?>

</div>
<div id="sisu">

    <?php
    if(isset($_REQUEST["id"])){
        $paring=$yhendus->prepare("
SELECT loomanimi, vanus, pilt, silmadevarv FROM loomad WHERE id=?");
        $paring->bind_param("i", $_REQUEST["id"]);
        //? küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result($nimi, $vanus, $pilt, $silmadevarv);
        $paring->execute();
        if($paring->fetch()){
            echo "<div><strong>".htmlspecialchars($nimi)."</strong>, vanus ";
            echo htmlspecialchars($vanus). " aastat.";
            echo "<br><img src='$pilt' alt='pilt'>";
            echo "<br>Silmadevärv ".htmlspecialchars($silmadevarv);
            echo "</div>";

        }
        echo "<a href='$_SERVER[PHP_SELF]?kustuta=$id'>Kustuta</a>";
    }


        if(isset($_REQUEST["lisaloom"])){
            ?>
    <h2>Uue looma lisamine</h2>
    <form name="uusloom" method="post" action="<?=$_SERVER["PHP_SELF"] ?>">
    <input type="hidden" name="lisamisvorm" value="jah">
    <input type="text" name="nimi" placeholder="Looma nimi">
    <br>
    <input type="number" name="vanus"  max="30" placeholder="Looma vanus">
    <br>
    <textarea name="pilt">Siia lisa pildi aadress</textarea>
    <input type="submit" value="OK">
    </form>
<?php
        }
        else {
            echo " <h3>Siia tuleb loomade info...</h3>";
        }
    $yhendus->close();
    ?>
</div>
</body>
</html>
