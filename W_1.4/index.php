

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Languege" content="pl" >
    <meta name="Author" content="Kacper Browarek" >
    <title>Hodowla żółwia wodnego</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
	
</head>
<body >
		<body onload="startclock()">
            <span id="zegarek"></span> <span id="data"></span>
        </body>
        <FORM METHOD="POST" NAME="background">
           <INPUT TYPE="button" VALUE="żółty" ONCLICK="changeBackground('#FFF000')">
           <INPUT TYPE="button" VALUE="czarny" ONCLICK="changeBackground('#000000')">
           <INPUT TYPE="button" VALUE="biały" ONCLICK="changeBackground('#FFFFFF')">
           <INPUT TYPE="button" VALUE="zielony" ONCLICK="changeBackground('#00FF00')">
           <INPUT TYPE="button" VALUE="niebieski" ONCLICK="changeBackground('#0000FF')">
           <INPUT TYPE="button" VALUE="pomarańczowy" ONCLICK="changeBackground('#FF8000')">
           <INPUT TYPE="button" VALUE="szary" ONCLICK="changeBackground('#c0c0c0')">
           <INPUT TYPE="button" VALUE="czerwony" ONCLICK="changeBackground('#FF0000')">
        </FORM>

    <table>
        <tr>
            <td colspan="3" class="header">
                <h1>Hodowla żółwia wodnego</h1>
                <nav>
                    <ul class="menu">
                                
                        <li><a href="index.php?idp=glowna" class="list-item">Strona Główna</a></li>
                        <li><a href="index.php?idp=Atlas" class="list-item">Atlas</a></li>
                        <li><a href="index.php?idp=hodowla" class="list-item">Sklepy</a></li>
                        <li><a href="index.php?idp=Poradnik" class="list-item">Poradniki</a></li>
						<li><a href="index.php?idp=Filmiki" class="list-item">Filmy</a></li>
                        <li><a href="index.php?idp=kontakt" class="list-item">Kontakt</a></li>
                        <li><a href="index.php?idp=Galeria" class="list-item">Galeria</a></li>
                        <li><a href="index.php?idp=Lab3" class="list-item">Lab3</a></li>
						
                    </ul>
                </nav>
            </td>
        </tr>
		<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING);
	/* po tym komentarzu będzie kod do dynamicznego ładowania stron */
 
	


	$idp = $_GET['idp'];
	if ($idp == '' || $idp == 'glowna') {
		$page = 'html/glowna.html';
		$title = "Strona główna";
	}elseif ($idp == 'Atlas') {
		$page = 'html/Atlas.html';
		$title = "Atlas żółwi";
	}elseif ($idp == 'hodowla') {
		$page = 'html/hodowla.html';
		$title = "Hodowcy";
	}elseif ($idp == 'Lab3') {
		$page = 'html/lab3.html';
		$title = "lab3";
	}elseif ($idp == 'Poradnik') {
		$page = 'html/Poradnik.html';
		$title = "Poradniki";
	}elseif ($idp == 'Galeria') {
		$page = 'html/galeria.html';
		$title = "Galeria";
    }elseif ($idp == 'kontakt') {
		$page = 'html/kontakt.html';
		$title = "Kontakt";
	}elseif ($idp == 'Pierwsze') {
		$page = 'html/Pierwsze.html';
		$title = "Pierwsze";
	}elseif ($idp == 'Filmiki') {
		$page = 'html/filmy.html';
		$title = "Filmiki";
	}
	if (file_exists($page)) {
		include($page);
	}else {
		echo "Strona nie istnieje!";
	}

  
?>
		
        
    </table>
	<?php
	$nr_indeksu='169223';
	$nr_grupy='1';
	echo 'Kacper Browarek ' .$nr_indeksu.' grupa '.$nr_grupy.' <br /><br />';
	?>
</body>
