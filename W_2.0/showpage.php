<?php
//---------------------------------------------------------------//
//	         Wyświetlanie treści strony WWW                	 //
//---------------------------------------------------------------//
// Funkcja służy do wyświetlania treści podstron na podstawie ich id

function PokazPodstrone($id) {
	
    // Ładowanie pliku konfiguracyjnego
    include 'cfg.php';
    
    // czyścimy $id, aby przez GET ktoś nie próbował wykonać ataku SQL INJECTION
    $id_clear = htmlspecialchars($id);
    
    // Wykonanie zapytania do bazy danych z limitem wyników
    $result =
      $link->query("SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1");
    
    // Obsługa wyniku zapytania
    $web = 'nie znaleziono strony'; // Domyślny komunikat
    while($record = mysqli_fetch_array($result)) {
        $web = $record;
    }
    
    return $web[2];
}



?>
