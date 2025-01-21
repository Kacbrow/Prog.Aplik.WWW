<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: rgb(10, 231, 255);
		
    }

    h2 {
        color: red;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: rgb(10,200,150);
        border: 1px solid rgb(255, 255, 255);
		
    }

    table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid rgb(221, 221, 22);
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }

    a {
        text-decoration: none;
        color: rgb(179, 81, 0);
        font-weight: bold;
    }

    a:hover {
        color: rg(0, 86, 179);
    }

    button {
        background-color: rgb(0, 255, 217);
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 14px;
        border-radius: 5px;
    }

    button:hover {
        background-color: rgb(134, 0, 179);
    }

    input[type="text"], textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid rgb(221, 221, 221);
        border-radius: 5px;
        margin-bottom: 10px;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    label {
        font-weight: bold;
    }

    .actions b {
        margin-left: 10px;
    }
</style>



<?php


include("../cfg.php");

session_start();

//---------------------------------------------------------------//
//                Panel do logowania się jako admin              //
//---------------------------------------------------------------//

function FormularzLogowania($error = '') {
    $wynik = '
    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logowanie</title>
        <link rel="stylesheet" href="../css/styleadmin.css">
    </head>
    <body>
	<center>
    <div>
      <h1>Panel CMS:</h1>
      ' . ($error ? '<p class="error">' . htmlspecialchars($error) . '</p>' : '') . '
      <div>
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'">
          <table>
            <tr><td>Login</td><td><input type="text" name="login_email"  required /></td></tr>
            <tr><td>Hasło</td><td><input type="password" name="login_pass"  required /></td></tr>
            <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit"  value="Zaloguj" /></td></tr>
          </table>
        </form>
      </div>
    </div>
	</center>
    </body>
    </html>';
    echo $wynik;
}


//---------------------------------------------------------------//
//                     Obsługa logowania i sesji                 //
//---------------------------------------------------------------//

if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['login'] = true;
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
        exit();
    } else {
        FormularzLogowania('Błąd logowania: Niepoprawne hasło lub login');
        exit();
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
    exit();
}

//---------------------------------------------------------------//
//                        Lista podstron                          //
//---------------------------------------------------------------//

function listaPodstron($link) {
    echo "<a href='?add_new=true'><b>Dodaj nową podstronę</b></a>";
    echo "<a href='?logout=true' style='margin-left: 20px;'><b>Wyloguj</b></a>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>";

    $result = $link->query("SELECT id, page_title FROM page_list LIMIT 10");
    while ($row = $result->fetch_array()) {
        $id = htmlspecialchars($row['id']);
        $title = htmlspecialchars($row['page_title']);
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['page_title']}</td>
                <td>
                    <a href='?edit_id={$row['id']}&type=page'><b>Edytuj</b></a> <b>|</b>
                    <a href='?delete_id={$row['id']}&type=page'><b>Usuń</b></a>
                </td>
              </tr>";
    }
    echo "</table>";
}

//---------------------------------------------------------------//
//					Metoda do edycji podstron  					 //
//---------------------------------------------------------------//

function EdytujPodstrone($id, $link) {
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        FormularzLogowania('Warunkiem jest zalogowanie się aby mieć dostęp.');
        return;
    }

    $id_clear = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $result = $link->query("SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1");

    if ($result->num_rows === 0) {
        echo "<p>Nie znaleziono podstrony o podanym ID.</p>";
        return;
    }

    $row = $result->fetch_assoc();

    
    $title = $row['page_title'] ?? '';
    $content = $row['page_content'] ?? '';
    $active = $row['status'] ?? 0;

    echo "
    <h2>Edytuj podstronę</h2>
    <form method='post' action=''>
        <label for='page_title'><b>Tytuł:</b></label><br>
        <input type='text' name='page_title' id='page_title' value='".htmlspecialchars($title, ENT_QUOTES)."' required><br><br>
        <label for='page_content'><b>Treść:</b></label><br>
        <textarea name='page_content' id='page_content' rows='10' cols='50'>".htmlspecialchars($content, ENT_QUOTES)."</textarea><br><br>
        <label>
            <input type='checkbox' name='active' ".($active ? "checked" : "")."> Aktywna
        </label><br><br>
        <button type='submit' name='save_changes'>Zapisz</button>
    </form>";

    if (isset($_POST['save_changes'])) {
        $new_title = $_POST['page_title'];
        $new_content = $_POST['page_content'];
        $new_active = isset($_POST['active']) ? 1 : 0;

        $stmt = $link->prepare("UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param("ssii", $new_title, $new_content, $new_active, $id_clear);

        if ($stmt->execute()) {
            //header("Location: " . $_SERVER['PHP_SELF']);
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=page");
            exit();
        } else {
            echo "<p>Błąd podczas aktualizacji podstrony: " . $stmt->error . "</p>";
        }
    }
}

//---------------------------------------------------------------//
//		  Metoda do obsługi dodawnia podstron nowych			 //
//---------------------------------------------------------------//

function DodajNowaPodstrone($link) {
    echo "
    <h2>Dodaj nową podstronę</h2>
    <form method='post' action=''>
        <label for='page_title'><b>Tytuł:</b></label><br>
        <input type='text' name='page_title' id='page_title' required><br><br>
        <label for='page_content'><b>Treść:</b></label><br>
        <textarea name='page_content' id='page_content' rows='10' cols='50' required></textarea><br><br>
        <label>
            <input type='checkbox' name='active'> Aktywna
        </label><br><br>
        <button type='submit' name='save_new_page'>Dodaj</button>
    </form>";

    if (isset($_POST['save_new_page'])) {
        $new_title = $_POST['page_title'];
        $new_content = $_POST['page_content'];
        $new_active = isset($_POST['active']) ? 1 : 0;

        $stmt = $link->prepare("INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $new_title, $new_content, $new_active);

        if ($stmt->execute()) {
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=page");
            exit();
        } else {
            echo "<p>Błąd podczas dodawania podstrony: " . $stmt->error . "</p>";
        }
    }
}


//---------------------------------------------------------------//
//					Metoda do usuwania podstron   				 //
//---------------------------------------------------------------//

function UsunPodstrone($id, $link) {
    $stmt = $link->prepare("DELETE FROM page_list WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // header("Location: " . $_SERVER['PHP_SELF']);
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=page");
        exit();
    } else {
        echo "<p>Błąd podczas usuwania: " . $stmt->error . "</p>";
    }
}

//--------------------------------------------------------------------------------------------------------------------//

//---------------------------------------------------------------//
//        			 Metoda do wyświetlania kategorii      		 //
//---------------------------------------------------------------//
function listaKategorii($link) {
    echo "<a href='?add_new=true&type=category'><b>Dodaj nową kategorię</b></a>";
    echo "<a href='?logout=true' style='margin-left: 20px;'><b>Wyloguj</b></a>";

    echo "<h2>Lista kategorii</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nazwa</th><th>Matka</th><th>Akcje</th></tr>";

    $result = $link->query("SELECT id, nazwa, matka FROM kategoria");
    while ($row = $result->fetch_assoc()) {
        $id = htmlspecialchars($row['id']);
        $nazwa = htmlspecialchars($row['nazwa']);
        $matka = htmlspecialchars($row['matka']);

        echo "<tr>
                <td>{$id}</td>
                <td>{$nazwa}</td>
                <td>{$matka}</td>
                <td>
                    <a href='?edit_id={$id}&type=category'><b>Edytuj</b></a> | 
                    <a href='?delete_id={$id}&type=category'><b>Usuń</b></a>
                </td>
              </tr>";
    }
    echo "</table>";

    // Wyświetlenie drzewa 
    echo "<h2>Hierarchia kategorii</h2>";

    $result = $link->query("SELECT id, nazwa, matka FROM kategoria ORDER BY matka, id");

    $kategorie = [];
    while ($row = $result->fetch_assoc()) {
        $row['nazwa'] = htmlspecialchars($row['nazwa']);
        $kategorie[$row['matka']][] = $row;
    }

    function wyswietlDrzewo($parent_id, $kategorie, $level = 0) {
        if (!isset($kategorie[$parent_id])) {
            return;
        }

        foreach ($kategorie[$parent_id] as $kategoria) {
            $id = $kategoria['id'];
            $nazwa = $kategoria['nazwa'];

            echo str_repeat("&nbsp;&nbsp;&nbsp;", $level) . "|-- <b>{$nazwa}</b> ";
            echo "<a href='?edit_id={$id}&type=category'>Edytuj</a> | ";
            echo "<a href='?delete_id={$id}&type=category'>Usuń</a><br>";

            wyswietlDrzewo($id, $kategorie, $level + 1);
        }
    }
    wyswietlDrzewo(0, $kategorie);
}

//---------------------------------------------------------------//
//              Metoda do dodawania nowych kategorii             //
//---------------------------------------------------------------//

function DodajNowaKategorie($link) {
    echo "
    <h2>Dodaj nową kategorię</h2>
    <form method='post' action=''>
        <label for='nazwa'><b>Nazwa:</b></label><br>
        <input type='text' name='nazwa' id='nazwa' required><br><br>
        <label for='matka'><b>Matka (ID):</b></label><br>
        <input type='number' name='matka' id='matka' required><br><br>
        <button type='submit' name='save_new_category'>Dodaj</button>
    </form>";

    if (isset($_POST['save_new_category'])) {
        $new_nazwa = $_POST['nazwa'];
        $new_matka = $_POST['matka'];

        $stmt = $link->prepare("INSERT INTO kategoria (nazwa, matka) VALUES (?, ?)");
        $stmt->bind_param("si", $new_nazwa, $new_matka);

        if ($stmt->execute()) {
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=category");
            exit(); 
        } else {
            echo "<p>Błąd podczas dodawania kategorii: " . $stmt->error . "</p>";
        }
    }
}

//---------------------------------------------------------------//
//            Metoda do edycji istniejących kategorii            //
//---------------------------------------------------------------//

function EdytujKategorie($id, $link) {
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        FormularzLogowania('Wymagane zalogowanie, aby mieć dostęp.');
        return;
    }

    $id_clear = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $result = $link->query("SELECT * FROM kategoria WHERE id='$id_clear' LIMIT 1");

    if ($result->num_rows === 0) {
        echo "<p>Nie znaleziono kategorii o podanym ID.</p>";
        return;
    }

    $row = $result->fetch_assoc();
    $nazwa = htmlspecialchars($row['nazwa']);
    $matka = $row['matka'];

    echo "
    <h2>Edytuj kategorię</h2>
    <form method='post' action=''>
        <label for='nazwa'><b>Nazwa:</b></label><br>
        <input type='text' name='nazwa' id='nazwa' value='$nazwa' required><br><br>
        <label for='matka'><b>Matka (ID):</b></label><br>
        <input type='number' name='matka' id='matka' value='$matka' required><br><br>
        <button type='submit' name='save_changes'>Zapisz</button>
    </form>";

    if (isset($_POST['save_changes'])) {
        $new_nazwa = $_POST['nazwa'];
        $new_matka = $_POST['matka'];

        $stmt = $link->prepare("UPDATE kategoria SET nazwa = ?, matka = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param("sii", $new_nazwa, $new_matka, $id_clear);

        if ($stmt->execute()) {
            
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=category");
            exit(); 
        } else {
            echo "<p>Błąd podczas aktualizacji kategorii: " . $stmt->error . "</p>";
        }
    }
}

//---------------------------------------------------------------//
//         Metoda do usuwania isntniejących kategorii            //
//---------------------------------------------------------------//

function UsunKategorie($id, $link) {
    $stmt = $link->prepare("DELETE FROM kategoria WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
	$update_stmt = $link->prepare("UPDATE kategoria SET matka = 0 WHERE matka = ?");
	$update_stmt->bind_param("i", $id);
	$update_stmt->execute();

    if ($stmt->execute()) {
 
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=category");
        exit(); 
    } else {
        echo "<p>Błąd podczas usuwania kategorii: " . $stmt->error . "</p>";
    }
}


//----------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------//
//                Metoda wyświetlająca produkty                  //
//---------------------------------------------------------------//

function listaProduktow($link) {
    echo "<h2>Lista Produktów</h2>";
    echo "<a href='?type=product&add_new=true'><b>Dodaj Nowy Produkt</b></a>";
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Data dodania</th>
            <th>Data modyfikacji</th>
            <th>Data wygaśnięcia</th>
            <th>Cena netto</th>
            <th>VAT</th>
            <th>Dostępna ilość</th>
            <th>Status dostępności</th>
            <th>Rozmiar</th>
            <th>Obrazek</th>
            <th>Akcje</th>
          </tr>";

    $result = $link->query("SELECT * FROM products LIMIT 20");

    while ($row = $result->fetch_assoc()) {
        
        $id = htmlspecialchars($row['id']);
        $title = htmlspecialchars($row['title']);
        $description = htmlspecialchars($row['description']);
        $creation_date = htmlspecialchars($row['creation_date']);
        $modification_date = htmlspecialchars($row['modification_date']);
        $expiration_date = htmlspecialchars($row['expiration_date']);
        $net_price = htmlspecialchars($row['net_price']);
        $vat_tax = htmlspecialchars($row['vat_tax']);
        $available_quantity = htmlspecialchars($row['available_quantity']);
        $availability_status = htmlspecialchars($row['availability_status']);
        $size = htmlspecialchars($row['size']);
        $image = htmlspecialchars($row['image']); 


        echo "<tr>
                <td>{$id}</td>
                <td>{$title}</td>
                <td>{$description}</td>
                <td>{$creation_date}</td>
                <td>{$modification_date}</td>
                <td>{$expiration_date}</td>
                <td>{$net_price} PLN</td>
                <td>{$vat_tax} %</td>
                <td>{$available_quantity}</td>
                <td>{$availability_status}</td>
                <td>{$size}</td>
               <td>";
					if ($image) {
						echo "<img src='{$image}' alt='Product Image' width='100' height='100'>";
					} else {
						echo "<span>Brak obrazka</span>";
					}
				echo "</td>
                <td>
                    <a href='?type=product&edit_id={$id}'><b>Edytuj</b></a> |
                    <a href='?type=product&delete_id={$id}'><b>Usuń</b></a>
					<a href='koszyk.php?action=add&product_id={$id}&quantity=1'>Dodaj do koszyka</a>
                </td>
              </tr>";
    }

    echo "</table>";
}

//---------------------------------------------------------------//
//                Metoda dodająca produkt do bazy                //
//---------------------------------------------------------------//

function DodajNowyProdukt($link) {
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        FormularzLogowania('Wymagane zalogowanie, aby dodać produkt.');
        return;
    }

    echo "<h2>Dodaj Nowy Produkt</h2>";
    echo "<form method='post' enctype='multipart/form-data'>
        <label for='title'><b>Tytuł:</b></label><br>
        <input type='text' name='title' id='title' required><br><br>

        <label for='description'><b>Opis:</b></label><br>
        <textarea name='description' id='description' rows='5' cols='50'></textarea><br><br>

        <label for='net_price'><b>Cena netto:</b></label><br>
        <input type='number' name='net_price' id='net_price' required><br><br>

        <label for='vat_tax'><b>VAT:</b></label><br>
        <input type='number' name='vat_tax' id='vat_tax' required><br><br>

        <label for='available_quantity'><b>Dostępna ilość:</b></label><br>
        <input type='number' name='available_quantity' id='available_quantity' required><br><br>

        <label for='availability_status'><b>Status dostępności:</b></label><br>
        <select name='availability_status' id='availability_status'>
            <option value='in_stock'>Dostępny</option>
            <option value='out_of_stock'>Brak w magazynie</option>
            <option value='discontinued'>Wycofany</option>
        </select><br><br>

        <label for='size'><b>Rozmiar:</b></label><br>
        <input type='text' name='size' id='size'><br><br>

        <label for='image'><b>Ścieżka do obrazka (URL):</b></label><br>
		<input type='text' name='image' id='image'><br><br>

        <label for='creation_date'><b>Data dodania:</b></label><br>
        <input type='datetime-local' name='creation_date' id='creation_date' value='" . date('Y-m-d\TH:i') . "' required><br><br>

        <label for='expiration_date'><b>Data wygaśnięcia:</b></label><br>
        <input type='datetime-local' name='expiration_date' id='expiration_date'><br><br>

        <button type='submit' name='save_new_product'>Zapisz Nowy Produkt</button>
    </form>";

    if (isset($_POST['save_new_product'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $net_price = $_POST['net_price'];
        $vat_tax = $_POST['vat_tax'];
        $available_quantity = $_POST['available_quantity'];
        $availability_status = $_POST['availability_status'];
        $size = $_POST['size'];
        $creation_date = $_POST['creation_date'];
        $expiration_date = $_POST['expiration_date'];
        
        $upload_dir = "uploads/";
		if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $target_file = $upload_dir . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $image = $target_file;
            } else {
                echo "<p>Błąd podczas przesyłania pliku.</p>";
                return;
            }
        } elseif (!empty($_POST['image'])) {
            $image = $_POST['image'];
        } else {
            $image = null;
        }
		
        // aktualizacja produktu w bazie
        $stmt = $link->prepare("INSERT INTO products (title, description, creation_date, modification_date, expiration_date, net_price, vat_tax, available_quantity, availability_status, size, image)
        VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssisisss", $title, $description, $creation_date, $expiration_date, $net_price, $vat_tax, $available_quantity, $availability_status, $size, $image);

        if ($stmt->execute()) {
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=product");
            exit();
        } else {
            echo "<p>Błąd podczas dodawania produktu: " . $stmt->error . "</p>";
        }
    }
}

//---------------------------------------------------------------//
//        Metoda wyświetlająca formularz edycji produktu         //
//---------------------------------------------------------------//

function EdytujProdukt($id, $link) {
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        FormularzLogowania('Wymagane zalogowanie, aby edytować produkt.');
        return;
    }

    $id_clear = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $result = $link->query("SELECT * FROM products WHERE id='$id_clear' LIMIT 1");

    if ($result->num_rows === 0) {
        echo "<p>Nie znaleziono produktu o podanym ID.</p>";
        return;
    }

    $row = $result->fetch_assoc();
    $title = htmlspecialchars($row['title']);
    $description = htmlspecialchars($row['description']);
    $creation_date = htmlspecialchars($row['creation_date']);
    $modification_date = htmlspecialchars($row['modification_date']);
    $expiration_date = htmlspecialchars($row['expiration_date']);
    $net_price = htmlspecialchars($row['net_price']);
    $vat_tax = htmlspecialchars($row['vat_tax']);
    $available_quantity = htmlspecialchars($row['available_quantity']);
    $availability_status = htmlspecialchars($row['availability_status']);
    $size = htmlspecialchars($row['size']);
    $image = $row['image']; 

    echo "
    <h2>Edytuj Produkt</h2>
    <form method='post' enctype='multipart/form-data'>
        <label for='title'><b>Tytuł:</b></label><br>
        <input type='text' name='title' id='title' value='{$title}' required><br><br>

        <label for='description'><b>Opis:</b></label><br>
        <textarea name='description' id='description' rows='5' cols='50'>{$description}</textarea><br><br>

        <label for='net_price'><b>Cena netto:</b></label><br>
        <input type='number' name='net_price' id='net_price' value='{$net_price}' required><br><br>

        <label for='vat_tax'><b>VAT:</b></label><br>
        <input type='number' name='vat_tax' id='vat_tax' value='{$vat_tax}' required><br><br>

        <label for='available_quantity'><b>Dostępna ilość:</b></label><br>
        <input type='number' name='available_quantity' id='available_quantity' value='{$available_quantity}' required><br><br>

        <label for='availability_status'><b>Status dostępności:</b></label><br>
        <select name='availability_status' id='availability_status'>
            <option value='in_stock' ".($availability_status == 'in_stock' ? 'selected' : '').">Dostępny</option>
            <option value='out_of_stock' ".($availability_status == 'out_of_stock' ? 'selected' : '').">Brak w magazynie</option>
            <option value='discontinued' ".($availability_status == 'discontinued' ? 'selected' : '').">Wycofany</option>
        </select><br><br>

        <label for='size'><b>Rozmiar:</b></label><br>
        <input type='text' name='size' id='size' value='{$size}'><br><br>
		
		<label for='image'><b>Ścieżka do obrazka (URL):</b></label><br>
		<input type='text' name='image' id='image' value='{$image}><br><br>


        <label for='creation_date'><b>Data dodania:</b></label><br>
        <input type='datetime-local' name='creation_date' id='creation_date' value='" . date('Y-m-d\TH:i', strtotime($creation_date)) . "' required><br><br>

        <label for='expiration_date'><b>Data wygaśnięcia:</b></label><br>
        <input type='datetime-local' name='expiration_date' id='expiration_date' value='" . date('Y-m-d\TH:i', strtotime($expiration_date)) . "'><br><br>

        <button type='submit' name='save_changes'>Zapisz zmiany</button>
    </form>";

    if (isset($_POST['save_changes'])) {
		$new_title = $_POST['title'];
		$new_description = $_POST['description'];
		$new_net_price = $_POST['net_price'];
		$new_vat_tax = $_POST['vat_tax'];
		$new_available_quantity = $_POST['available_quantity'];
		$new_availability_status = $_POST['availability_status'];
		$new_size = $_POST['size'];
		$new_creation_date = $_POST['creation_date'];
		$new_expiration_date = $_POST['expiration_date'];
		
		$upload_dir = "uploads/";
		if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $target_file = $upload_dir . basename($_FILES['image_file']['name']);
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $image = $target_file;
            } else {
                echo "<p>Błąd podczas przesyłania pliku.</p>";
                return;
            }
        } elseif (!empty($_POST['image'])) {
            $image = $_POST['image'];
        } else {
            $image = null;
        }

		// Aktualizacja danych w bazie
		$stmt = $link->prepare("UPDATE products SET title = ?, description = ?, creation_date = ?, expiration_date = ?, net_price = ?, vat_tax = ?, available_quantity = ?, availability_status = ?, size = ?, image = ? WHERE id = ?");
		$stmt->bind_param("ssssisisssi", $new_title, $new_description, $new_creation_date, $new_expiration_date, $new_net_price, $new_vat_tax, $new_available_quantity, $new_availability_status, $new_size, $image, $id_clear);

		if ($stmt->execute()) {
			header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?type=product");
			exit();
		} else {
			echo "<p>Błąd podczas aktualizacji produktu: " . $stmt->error . "</p>";
		}
	}

}

//---------------------------------------------------------------//
//                  Metoda usuwająca produkt                     //
//---------------------------------------------------------------//

function UsunProdukt($id, $link) {
    $stmt = $link->prepare("DELETE FROM products WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p>Błąd podczas usuwania produktu: " . $stmt->error . "</p>";
    }
}


echo "<p><a href='koszyk.php?action=show'><b>Pokaż koszyk</b></a></p>";
//-------------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------//
//                 	Formularz wyboru typu          	             //
//---------------------------------------------------------------//


echo "
<form method='get'>
    <label for='type'><b>Wybierz typ:</b></label><br>
    <select name='type' id='type'>
        <option value='page' " . (isset($_GET['type']) && $_GET['type'] == 'page' ? 'selected' : '') . ">Podstrony</option>
        <option value='category' " . (isset($_GET['type']) && $_GET['type'] == 'category' ? 'selected' : '') . ">Kategorie</option>
        <option value='product' " . (isset($_GET['type']) && $_GET['type'] == 'product' ? 'selected' : '') . ">Produkty</option>
        <option value='cart' " . (isset($_GET['type']) && $_GET['type'] == 'cart' ? 'selected' : '') . ">Koszyk</option>
    </select>
    <button type='submit'>Wybierz</button>
</form>
";

//-------------------------------------------------------------------------------------------------------------------------------------------//
// Sprawdź, czy użytkownik jest zalogowany i Obsługa


if (isset($_SESSION['login']) && $_SESSION['login']) {
	
    //  czy ustawiony jest parametr 'type' ?
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    } else {
        $type = 'page';  
    }

    // Obsługuje kategorie
    if ($type === 'category') {
        if (isset($_GET['edit_id'])) {
            EdytujKategorie($_GET['edit_id'], $link);
        } elseif (isset($_GET['add_new'])) {
            DodajNowaKategorie($link);
        } elseif (isset($_GET['delete_id'])) {
            UsunKategorie($_GET['delete_id'], $link);
        } else {
            listaKategorii($link);  

        }
    } 
    // Obsługuje podstrony
    elseif ($type === 'page') {
        if (isset($_GET['edit_id'])) {
            EdytujPodstrone($_GET['edit_id'], $link);
        } elseif (isset($_GET['add_new'])) {
            DodajNowaPodstrone($link);
        } elseif (isset($_GET['delete_id'])) {
            UsunPodstrone($_GET['delete_id'], $link);
        } else {
            listaPodstron($link);  
        }
	} 
	// Obsługuje produkty
	elseif ($type === 'product') {
        if (isset($_GET['edit_id'])) {
            EdytujProdukt($_GET['edit_id'], $link);
        } elseif (isset($_GET['add_new'])) {
            DodajNowyProdukt($link);
        } elseif (isset($_GET['delete_id'])) {
            UsunProdukt($_GET['delete_id'], $link);
        } else {
            listaProduktow($link);
        }
    } else {
        echo "<p>Wybierz typ do zarządzania.</p>";
    }
} else {
    FormularzLogowania();
}

?>




