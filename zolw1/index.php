<?php
 error_reporting(E_ALL^E_NOTICE^E_WARNING);
 /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
 
 // dołączenie zewnętrznych plików cfg i showpage
 include 'cfg.php';
 include 'showpage.php'; // Funkcja odpowiedzialna za dynamiczne wyświetlanie podstron
 
// ==========================//
// Walidacja zmiennej $_GET  //
// ==========================//
 $idp = $_GET['idp']; // zmienna, która pobiera dane. Służy do przysyłania danych pomiędzy stronami
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Languege" content="pl" >
    <meta name="Author" content="Kacper Browarek" >
    <title>Hodowla żółwia wodnego</title>
    <link rel="stylesheet" href="css/style.css">
        <script src="js/kolorujtlo.js" type="text/javascript"></script>
        <script src="js/timedate.js" type="text/javascript"></script>
</head>
<body onload="startclock()" >
    <div class="top-bar">
        <div class="left">
            <span id="zegarek"></span>  <span id="data"></span>
        </div>
        <div class="right">
            <FORM METHOD="POST" NAME="background" class="color-buttons">
                <INPUT TYPE="button" VALUE="żółty" ONCLICK="changeBackground('#FFF000')">
                <INPUT TYPE="button" VALUE="czarny" ONCLICK="changeBackground('#000000')">
                <INPUT TYPE="button" VALUE="biały" ONCLICK="changeBackground('#FFFFFF')">
                <INPUT TYPE="button" VALUE="zielony" ONCLICK="changeBackground('#00FF00')">
                <INPUT TYPE="button" VALUE="niebieski" ONCLICK="changeBackground('#0000FF')">
                <INPUT TYPE="button" VALUE="pomarańczowy" ONCLICK="changeBackground('#FF8000')">
                <INPUT TYPE="button" VALUE="szary" ONCLICK="changeBackground('#c0c0c0')">
                <INPUT TYPE="button" VALUE="czerwony" ONCLICK="changeBackground('#FF0000')">
            </FORM>
        </div>
    </div>
    <table>
        <tr>
            <td  class="header">
                <h1>Hodowla żółwia wodnego</h1>
                <nav>
                    <ul class="menu">
                        <li><a href="index.php?idp=1" class="list-item">Strona Główna</a></li>
                        <li><a href="index.php?idp=2" class="list-item">Atlas</a></li>
                        <li><a href="index.php?idp=3" class="list-item">Hodowcy żółwi</a></li>
                        <li><a href="index.php?idp=4" class="list-item">Poradniki</a></li>
                        <li><a href="index.php?idp=5" class="list-item">Filmy</a></li>
                        <li><a href="index.php?idp=6" class="list-item">Kontakt</a></li>
                        <li><a href="index.php?idp=8" class="list-item">Lab3</a></li>
                        <li><a href="index.php?idp=7" class="list-item">Sklep online</a></li>
                    </ul>
                </nav>
            </td>
        </tr>
   </table>


<?php
      if($idp) {
        echo PokazPodstrone($idp); // Wyświetla podstronę na podstawie idp
      } elseif (true) {
        include("glowna.html"); // Domyślnie wyświetla stronę główną
      }else{
		  echo "Strona nie istnieje!";
	  }
		  
      ?>
<br>
<br>
<center>
<?php
    $nr_indeksu='169223';
    $nr_grupy='1';
    echo 'Kacper Browarek ' .$nr_indeksu.' grupa '.$nr_grupy.' <br /><br />';
?>
</center>

</body>
