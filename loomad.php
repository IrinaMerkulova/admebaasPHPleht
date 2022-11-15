<?php
require_once ('connect.php');
global $yhendus;
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
//kustutamine
if(isset($_REQUEST["kustuta"])){

    $paring=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta"]);
    $paring->execute();
    //aadressi ribas eemaldatakse php käsk
    header("Location: $_SERVER[PHP_SELF]");
}

//tabeli sisu näitamine
$paring=$yhendus->prepare("SELECT id, loomanimi, vanus, pilt FROM loomad");
$paring->bind_result($id, $nimi, $vanus, $pilt);
$paring->execute();



?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomad</title>
</head>
<body>
<h1>Loomade tabel</h1>
<table>
    <tr>
        <th>id</th>
        <th>Loomanimi</th>
        <th>Vanus</th>
        <th>Pilt</th>
        <th>Kustuta</th>
    </tr>
    <?php
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>". htmlspecialchars($id)."</td>";
        //htmlspecialchars($id) - <käsk> - käsk nurksulgudes mis ei loetakse
        echo "<td>". htmlspecialchars($nimi)."</td>";
        echo "<td>". htmlspecialchars($vanus)."</td>";
        echo "<td><img src='$pilt' alt='pilt' width='50%'></td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<h2>Uue looma lisamine</h2>
<form name="uusloom" method="post" action="?">
    <input type="hidden" name="lisamisvorm">
    <input type="text" name="nimi" placeholder="Looma nimi">
    <br>
    <input type="number" name="vanus"  max="30" placeholder="Looma vanus">
    <br>
    <textarea name="pilt">Siia lisa pildi aadress</textarea>
    <input type="submit" value="OK">
</form>

</body>
<?php
$yhendus->close();
//lisa tabelisse veerg silmadeVarv ja täida värvidega inglise keeles
//veebilehel kõik Nimed(tekst) värvida silmadeVärviga
?>
</html>
