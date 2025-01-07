<?php
include("../cfg.php");
//-------------------------------------------------------------------------------//
//		Formularz do wypełniania takie jak temat, Treść wiadomości , email  	 //
//-------------------------------------------------------------------------------//
// Funkcja zwraca formularz kontaktowy

function PokazKontakt() {
    $show = '
    <form method="POST" action="">
        <label for="temat">[Temat]:</label><br>
        <input type="text" id="temat" name="temat" required><br><br>

        <label for="tresc">[Treść]:</label><br>
        <textarea id="tresc" name="tresc" rows="4" cols="50" required>Tu wpisz swoją wiadomość.</textarea><br><br>

        <label for="email">[E-mail]:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" name="formularzKontaktowy" value="Wyślij wiadomość"> // Button zatwierdzanie, że wysyłamy 
    </form>
    ';
    return $show;
}
//-------------------------------------------------------//
//		Wysyłanie danych poprzez formularz kontaktowy 	 //
//-------------------------------------------------------//
/// Funkcja wysyła e-mail na wskazany adres odbiorcy

function WyslijMailaKontakt($odbiorca) {

    if(empty($_POST['temat']) ||  empty($_POST['tresc']) ||  empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt(); // Ponowne wywołanie formularza 
    } else {
        // Walidacja danych wejściowych
        // $mail['subject'] = $_POST['temat'];
        // $mail['body'] = $_POST['tresc'];
        // $mail['sender'] = $_POST['email'];
        $mail['subject'] = htmlspecialchars($_POST['temat']);
        $mail['body'] = htmlspecialchars($_POST['tresc']);
        $mail['sender'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $mail['reciptient'] = $odbiorca;  // Czyli my jesteśmy odbiorcą, jeżeli tworzymy formularz kontaktowy

        //  nagłówki wiadomości
        $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\n";
        $header .= "X-Sender: <".$mail['sender'].">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <".$mail['sender'].">\n";

        // Wysyłanie e-maila
        mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}

//---------------------------------------------------------------//
//		Jeśli nie pamietamy hasła i potrzebujemy resert hasła  	 //
//---------------------------------------------------------------//
// Funkcja wysyła e-mail z przypomnieniem hasła

function PrzypomnijHaslo($odbiorca, $pass) {
    $mail['subject'] = "Przypomnienie hasla";
    // $mail['body'] = "Twoje haslo to: ".$pass;
    $mail['body'] = "Twoje hasło to: " . htmlspecialchars($pass);
    $mail['reciptient'] = $odbiorca;
    
    //  nagłówki wiadomości
    $header = "From: Formularz kontaktowy <email@wp.pl>\n";
    $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/".phpversion()."\n";
    $header .= "X-Priority: 3\n";

    // Wysyłanie e-maila
    mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

    header("Location: ?");
    echo '[wysłano_przypomnienie]';
}

//---------------------------------------------------------------//
//		                Obsługa żądań POST  	                 //
//---------------------------------------------------------------//

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['formularzKontaktowy'])) {
        WyslijMailaKontakt("kacperbrowarek@wp.pl");
    }
    elseif(isset($_POST['przypomnijHaslo'])) {
        PrzypomnijHaslo("kacperbrowarek@wp", $pass);
    }

} else {
    // Wyświetlenie formularzy
    echo '<h1>Wyślij maila</h1>';
    echo PokazKontakt();

    echo '
    <h1>Przypomnij haslo</h1>
    <form method="POST" action="">
    [email]:<input type="email" name="email" required><br><br>
    <input type="submit" name="przypomnijHaslo" value="Przypomnij hasło">
    </form>
    ';

}

?>
