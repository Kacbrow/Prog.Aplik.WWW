<?php
// --------------------------------------------------------------- //
//                    Konfiguracja bazy danych                     //
// --------------------------------------------------------------- //

    $dbhost = 'localhost';  // Adres hosta bazy danych
    $dbuser = 'root';       // Użytkownik bazy danych
    $dbpass = '';           // Hasło do bazy danych
    $baza = 'moja_strona';  // Nazwa bazy danych
    
    // Dodatkowe dane
	$login = 'Kacper';      // Login admin
	$pass = '9104';         // Hasło admin
 
// --------------------------------------------------------------- //
//                Połączenie z bazą danych MySQL                   //
// --------------------------------------------------------------- //

    $link = new mysqli($dbhost, $dbuser, $dbpass,$baza);

    // Sprawdzanie połączenia z bazą danych
	if (!$link) echo '<b>przerwane połączenie</b>';
	if (!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';
?>
