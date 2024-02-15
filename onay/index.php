<?php
$db = new mysqli("localhost", "root", "", "ders");
$db->query("SET CHARACTER SET UTF8");
$db->query("SET NAMES UTF8");

if ($_POST) {
    $eposta = $_POST["eposta"];
    uret:
    $kod = date("YmdHis");
    $kod = md5($kod);
    $kod = substr($kod, 0, 10);
    echo $kod;

    $query = $db->query("SELECT * FROM eposta WHERE onaykodu='$kod' ");
    if ($query->num_rows) {
        goto uret;
    } else {
        $insert = $db->query("INSERT INTO eposta SET 
        mail ='$eposta', onaykodu ='$kod', onaylandi = 0");
    }
}
if ($_GET["onay"]) {
    $kod = $_GET["onay"];
    $query = $db->query("SELECT * FROM eposta WHERE onaykodu= '$kod' && onaylandi=0 ");
    if ($query->num_rows) {
        $update = $db->query("UPDATE eposta SET onaylandi= 1 WHERE onaykodu= '$kod' ");
        if ($update) {
            echo "Başarılı";
        }
    }
    else {
       echo "Başarısız";
   }
}

?>
<form action="" method="POST">
    <input type="text" name="eposta" placeholder="Mail Adresi">
    <input type="submit" value="Kaydol">
</form>