<?php


include("../cfg.php");

session_start();

//---------------------------------------------------------------//
//				Panel do logowania się jako admin 				 //
//---------------------------------------------------------------//

function FormularzLogowania($error = '') {
    $wynik = '
    <div class="logowanie">
      <h1 class="heading">Panel CMS:</h1>
      <div class="logowanie">
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'">
          <table class="logowanie">
            <tr><td class="log4_t">[login]</td><td><input type="text" name="login_email" class="logowanie" required /></td></tr>
            <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" required /></td></tr>
            <tr><td>&nbsp</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
          </table>
        </form>
      </div>
    </div>';
    echo $wynik;
}

//---------------------------------------------------------------//
//		             Obsługa logowania i sesji    	             //
//---------------------------------------------------------------//

if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['login'] = true;
        // header("Location: " . $_SERVER['PHP_SELF']);
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
        exit();
    } else {
        FormularzLogowania('Błąd logowania: Niepoprawne hasło lub login');
        exit();
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    // header("Location: " . $_SERVER['PHP_SELF']);
    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
    exit();
}

//---------------------------------------------------------------//
//                        Lista podstron                           //
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
                    <a href='?edit_id={$row['id']}'><b>Edytuj</b></a> <b>|</b>
                    <a href='?delete_id={$row['id']}'><b>Usuń</b></a>
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
        FormularzLogowania('Wymagane zalogowanie aby mieć dostęp.');
        return;
    }

    $id_clear = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $result = $link->query("SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1");

    if ($result->num_rows === 0) {
        echo "<p>Nie znaleziono podstrony o podanym ID.</p>";
        return;
    }

    $row = $result->fetch_assoc();

    
    // $title = $row['page_title'] ?? '';
    // $content = $row['page_content'] ?? '';
    $title = htmlspecialchars($row['page_title']);
    $content = htmlspecialchars($row['page_content']);
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
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
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
            //header("Location: " . $_SERVER['PHP_SELF']);
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
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
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
        exit();
    } else {
        echo "<p>Błąd podczas usuwania: " . $stmt->error . "</p>";
    }
}

//---------------------------------------------------------------//
//              Metoda do dodawania nowych kategorii             //
//---------------------------------------------------------------//

function DodajKategorie($link)
{
  if(empty($_SESSION['login']))
  {
    return;
  }

  if(isset($_POST['dodaj']))
  {
    $matka = mysqli_real_escape_string($link, $_POST['matka']);
    $nazwa = mysqli_real_escape_string($link, $_POST['nazwa']);

    $zapytanieDodaj = "INSERT INTO kategoria (matka, nazwa) VALUES ('$matka', '$nazwa')";

    // Sprawdzenie, czy zapytanie się powiodło 
    if(mysqli_query($link, $zapytanieDodaj))
    {
      echo "<p> Kategoria dodana </p>";
    }
    else
    {
      echo "<p> Błąd przy dodaniu Kategorii: " . mysqli_error($link) . "</p>";
    }
  }

  // Formularz 
  echo "
  <h2> Dodaj Kategorię </h2>
  <form method = 'post' action='' >
    <label for ='matka' > Matka: </label><br>
    <input type ='number' name='matka' id = 'matka' required><br>
    
    <label for = 'nazwa'>Nazwa kategorii: </label><br>
    <textarea name ='nazwa' id = 'nazwa' row ='5' cols='40' required> </textarea><br>
    
    <button type='submit' name='dodaj' > Dodaj Kategorię</button>
  </form>
  ";

}

//---------------------------------------------------------------//
//         Metoda do usuwania isntniejących kategorii            //
//---------------------------------------------------------------//
function UsunKategorie($link)
{
  if(empty($_SESSION['login']))
  {
    return;
  }

  if(isset($_POST['Usun_kategorie']) && !empty($_POST['kategoria_id']))
  {
    $id = mysqli_real_escape_string($link, $_POST['kategoria_id']);

    // Sprawdzenie czy kategoria ma podkategorie, nie można jej usunąć
    $zapytanieKategoria = "SELECT id FROM kategoria WHERE matka = '$id'";
    $wynikKategorii = mysqli_query($link,$zapytanieKategoria);
    
    if(mysqli_num_rows($wynikKategorii) > 0)
    {
      echo "<p> Nie można usunąć kategorii, która posiada podkategorie. Usuń podkategorie. </p>";
      return;
    }

    // Zapytanie do usunięcia 
    $zapytanieUsuwanie = "DELETE FROM kategoria WHERE id = '$id'";
    // Sprawdzenie, czy zapytanie się powiodło 
    if(mysqli_query($link, $zapytanieUsuwanie))
    {
      echo "<p> Kategoria o ID $id została usunięta. </p>"; 
    }
    else
    {
      echo "<p> Błąd przy usuwaniu kategorii: " . mysqli_error($link) . "</p>";
    }

  }
  // Formularz 
  echo "
  <h2> Usuń Kategorię </h2>
  <form method = 'post' action=''>
    <label for = 'kategoria_id'> ID Kategorii: </label>
    <input type ='text' name='kategoria_id'> <br>
    <input type ='submit' name='Usun_kategorie' value='Usuń Kategorię'>
  </form>
  ";

}

//---------------------------------------------------------------//
//            Metoda do edycji istniejących kategorii            //
//---------------------------------------------------------------//

function EdytujKategorie($link)
{
  if(empty($_SESSION['login']))
  {
    return;
  }
  
  if(isset($_POST['zapisz']) && !empty($_POST['kategoria_id']) && !empty($_POST['nowa_nazwa']))
  {
    $id = mysqli_real_escape_string($link, $_POST['kategoria_id']);
    $nowa_nazwa = mysqli_real_escape_string($link, $_POST['nowa_nazwa']);

    $zapytanieEdycja = "UPDATE kategoria SET nazwa = '$nowa_nazwa' WHERE id = '$id'";

    // Sprawdzenie, czy zapytanie się powiodło 
    if(mysqli_query($link, $zapytanieEdycja))
    {
      echo "<p> Kategoria o ID $id została zmieniona. </p>";
    }
    else
    {
      echo "<p> Błąd edycji: " . mysqli_error($link) . "</p>";
    }
  }

  // Formularz 
  echo "
  <h2> Edytuj Kategorię </h2>
  <form method ='post' action=''>
    <label for='kategoria_id'>ID Kategorii: </label><br>
    <input type='number' name='kategoria_id' id='kategoria_id' required> <br><br>
    
    <label for='nowa_nazwa'>Nowa nazwa: </label><br>
    <input type = 'text' name ='nowa_nazwa' id='nowa_nazwa' required> <br><br>
    
    <button type ='submit' name='zapisz' > Zapisz</button>
  </form>
  ";


}

//---------------------------------------------------------------//
//         Metoda do wyświetlania kategorii i podkategorii       //
//---------------------------------------------------------------//

function PokazKategorie($link)
{
  if(empty($_SESSION['login']))
  {
    return;
  }

  $pokazKategorie = isset($_POST['pokazKategorie']);

  // Pobranie kategorii z bazy danych, postortowanych według matki i ID 
  $zapytanie = "SELECT * FROM kategoria ORDER BY matka, id";
  $wynik = $link->query($zapytanie);

  if(!$wynik)
  {
    die("Bład zapytania: " . $link->error);
  }

  $kategorie = [];
  while($row = $wynik->fetch_assoc())
  {
    $kategorie[$row['matka']][] = $row;
  }
  // Button do wyświetlenie kategorii 
  echo "<h1> Pokaż kategorie </h1>";
  echo "<form method = 'post' action = ''>
          <button type = 'submit' name='pokazKategorie' > Pokaż </button>
        </form>
  ";

  if($pokazKategorie)
  {
    echo "<h2>KATEGORIE</h2>";
    
    // Pętla po głownych kategoriach 
    if(isset($kategorie[0])){
      echo "<ul>";
      foreach ($kategorie[0] as $kategoria)
      {
        echo "<li>" . htmlspecialchars($kategoria['nazwa'], ENT_QUOTES) . "</li>";
        // Jeżeli dana kategoria posiada podkategorie, zatem wyświetla je  
        if(isset($kategorie[$kategoria['id']]))
        {
          echo "<ul>";
          foreach($kategorie[$kategoria['id']] as $podkategoria)
          {
            echo "<li>" . htmlspecialchars($podkategoria['nazwa'], ENT_QUOTES) . "</li>";
    
          }
          echo "</ul>";
        }
      }
      echo "</ul>";
    } else {
        echo "<p> Brak kategorii głownych </p>";
    }
  }
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////


//---------------------------------------------------------------//
//                  Obsługa dodawania produktu                   //
//---------------------------------------------------------------//

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'DodajProdukt') {
        DodajProdukt();
    } elseif ($_POST['action'] === 'EdytujProdukt') {
        EdytujProdukt($_POST['id']);
    }
}

//---------------------------------------------------------------//
//            Obsługa dodawania produktu do koszyka              //
//---------------------------------------------------------------//

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'DodajProdukt') {
        DodajProdukt();
    } elseif ($_POST['action'] === 'EdytujProdukt') {
        EdytujProdukt($_POST['id']);
    } 
}



//---------------------------------------------------------------//
//                Metoda dodająca produkt do bazy                //
//---------------------------------------------------------------//

function DodajProdukt()
{
   // global $link;

    // Pobranie danych z formularza
    $title = $_POST['title'];
    $description = $_POST['description'];
    $expiration_date = $_POST['expiration_date'];
    $net_price = $_POST['net_price'];
    $vat_tax = $_POST['vat_tax'];
    $available_quantity = $_POST['available_quantity'];
    $availability_status = $_POST['availability_status'];
    $category = $_POST['category'];
    $size = $_POST['size'];

    // Sprawdzenie, czy plik został przesłany
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Obsługa przesłanego pliku
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
        $image_data = base64_encode($image_data);
    } else {
        // Jeśli plik nie został przesłany - ignorowanie
        $image_data = '';
    }

    $creation_date = date('Y-m-d');
    $modification_date = $creation_date;

    // Wstawienie produktu do bazy danych
    $insert_query = "
    INSERT INTO products (
        title, description, creation_date, modification_date, expiration_date, net_price, vat_tax, available_quantity,
        availability_status, category, size, image
    )
    VALUES (
        '$title', '$description', '$creation_date', '$modification_date', '$expiration_date', '$net_price', '$vat_tax',
        '$available_quantity', '$availability_status', '$category', '$size', '$image_data'
    )
    ";

    $link->query($insert_query);

    header('Location: products.php');
    exit();
}

//---------------------------------------------------------------//
//                Metoda wyświetlająca produkty                  //
//---------------------------------------------------------------//

function PokazProdukty()
{
    global $link;

    $query = "SELECT * FROM products";
    $result = $link->query($query);

    echo '<h1>Lista Produktów</h1>';

    // Formularz 
    echo '<form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="action" value="DodajProdukt">
            <label>Tytuł:</label>
            <input type="text" name="title" required><br><br>
            <label>Opis:</label>
            <textarea name="description" required></textarea><br><br>
            <label>Data Wygaśnięcia:</label>
            <input type="date" name="expiration_date" required><br><br>
            <label>Cena Netto:</label>
            <input type="text" name="net_price" required><br><br>
            <label>Podatek VAT:</label>
            <input type="text" name="vat_tax" required><br><br>
            <label>Ilość Dostępnych Sztuk:</label>
            <input type="text" name="available_quantity" required><br><br>
            <label>Status Dostępności:</label>
            <input type="text" name="availability_status" required><br><br>
            <label>Kategoria:</label>
            <input type="text" name="category" required><br><br>
            <label>Gabaryt Produktu:</label>
            <select name="size" required>
                <option value="small">Mały</option>
                <option value="medium">Średni</option>
                <option value="large">Duży</option>
            </select><br><br>
            <label>Zdjęcie:</label>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" name="DodajProdukt_submit" value="Dodaj Produkt">
          </form>';

    if ($result->num_rows > 0) {
        // Zamiast tabeli, używamy divów do wyświetlania produktów w pionie
        while ($row = $result->fetch_assoc()) {
            $sql = 'SELECT * FROM categories WHERE id=' . $row['category'];
            $result2 = $link->query($sql);
            $cat = "";
            while ($row2 = $result2->fetch_assoc()) {
                $cat = $row2['name'];
            }

            // Wyświetlanie danych produktu w pionie
            echo '<div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 15px;">';
            echo '<p><strong>ID:</strong> ' . $row['id'] . '</p>';
            echo '<p><strong>Tytuł:</strong> ' . $row['title'] . '</p>';
            echo '<p><strong>Opis:</strong> ' . $row['description'] . '</p>';
            echo '<p><strong>Data Utworzenia:</strong> ' . $row['creation_date'] . '</p>';
            echo '<p><strong>Data Modyfikacji:</strong> ' . $row['modification_date'] . '</p>';
            echo '<p><strong>Data Wygaśnięcia:</strong> ' . $row['expiration_date'] . '</p>';
            echo '<p><strong>Cena Netto:</strong> ' . $row['net_price'] . '</p>';
            echo '<p><strong>Podatek VAT:</strong> ' . $row['vat_tax'] . '</p>';
            echo '<p><strong>Ilość Dostępnych Sztuk:</strong> ' . $row['available_quantity'] . '</p>';
            echo '<p><strong>Status Dostępności:</strong> ' . $row['availability_status'] . '</p>';
            echo '<p><strong>Kategoria:</strong> ' . $cat . '</p>';
            echo '<p><strong>Gabaryt Produktu:</strong> ' . $row['size'] . '</p>';
            echo '<p><strong>Zdjęcie:</strong> <img src="data:image/jpeg;base64,' . $row['image'] . '" alt="' . $row['title'] . '" style="max-width: 200px;"></p>';

            // Akcje (Edytuj, Usuń, Dodaj do koszyka)
            echo '<div>';
            echo '<a href="?action=delete&id=' . $row['id'] . '">Usuń</a> | ';
            echo '<a href="?action=edit&id=' . $row['id'] . '">Edytuj</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'Brak produktów.';
    }
   
}

//---------------------------------------------------------------//
//                    Obsługa Usuwania produkt                   //
//---------------------------------------------------------------//

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    UsunProdukt($product_id);

    // Przekierowywanie na stronę z listą produktów po usunięciu
    header('Location: products.php');
    exit();
}

//---------------------------------------------------------------//
//                  Metoda usuwająca produkt                     //
//---------------------------------------------------------------//

function UsunProdukt($product_id)
{
    global $link;

    // Usunięcie produktu o konkretnym ID
    $delete_query = "DELETE FROM products WHERE id = $product_id";
    $link->query($delete_query);
}

// Obsługa edycji produktu
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    EdytujProduktForm($_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'EdytujProdukt') {
        EdytujProdukt($_POST['id']);
    }
}

//---------------------------------------------------------------//
//        Metoda wyświetlająca formularz edycji produktu         //
//---------------------------------------------------------------//

function EdytujProduktForm($id)
{
    global $link;

    $query = "SELECT * FROM products WHERE id = $id LIMIT 1";
    $result = $link->query($query);
    $row = $result->fetch_assoc();

    //  Formularz edycji
    echo '<h2>Edytuj Produkt</h2>';
    echo '<form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="action" value="EdytujProdukt">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <label>Tytuł:</label>
            <input type="text" name="title" value="' . $row['title'] . '" required>
            <label>Opis:</label>
            <textarea name="description" required>' . $row['description'] . '</textarea>
            <label>Data Wygaśnięcia:</label>
            <input type="date" name="expiration_date" value="' . $row['expiration_date'] . '" required>
            <label>Cena Netto:</label>
            <input type="text" name="net_price" value="' . $row['net_price'] . '" required>
            <label>Podatek VAT:</label>
            <input type="text" name="vat_tax" value="' . $row['vat_tax'] . '" required>
            <label>Ilość Dostępnych Sztuk:</label>
            <input type="text" name="available_quantity" value="' . $row['available_quantity'] . '" required>
            <label>Status Dostępności:</label>
            <input type="text" name="availability_status" value="' . $row['availability_status'] . '" required>
            <label>Kategoria:</label>
            <input type="text" name="category" value="' . $row['category'] . '" required>
            <label>Gabaryt Produktu:</label>
            <select name="size" value="' . $row['size'] . '" required>
                <option value="small">Mały</option>
                <option value="medium">Średni</option>
                <option value="large">Duży</option>
            </select>
            <label>Zdjęcie:</label>
            <input type="file" name="new_image" accept="image/*">
            <input type="submit" name="EdytujProdukt_submit" value="Zapisz zmiany">
          </form>';
}

//---------------------------------------------------------------//
//                Metoda obsługująca edycję produktu             //
//---------------------------------------------------------------//

function EdytujProdukt($id)
{
    global $link;

    // Pobranie danych z formularza
    $title = $_POST['title'];
    $description = $_POST['description'];
	$expiration_date = $_POST['expiration_date'];
    $net_price = $_POST['net_price'];
    $vat_tax = $_POST['vat_tax'];
    $available_quantity = $_POST['available_quantity'];
    $availability_status = $_POST['availability_status'];
    $category = $_POST['category'];
    $size = $_POST['size'];
	// Pobranie aktualnego zdjęcia
    $query = "SELECT image FROM products WHERE id = $id LIMIT 1";
    $result = $link->query($query);
    $row = $result->fetch_assoc();
    $current_image = $row['image'];

    // Sprawdzenie, czy użytkownik przesłał nowe zdjęcie
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        // Obsługa przesłanego nowego pliku (zdjęcia)
        $new_image_data = file_get_contents($_FILES['new_image']['tmp_name']);
        $new_image_data = base64_encode($new_image_data);
    } else {
        // Jeśli użytkownik nie przesłał nowego zdjęcia, zachowaj aktualne zdjęcie
        $new_image_data = $current_image;
    }

	
	$modification_date = date('Y-m-d');
    $update_query = "
    UPDATE products
    SET
        title = '$title',
        description = '$description',
        expiration_date = '$expiration_date',
        net_price = '$net_price',
        vat_tax = '$vat_tax',
        available_quantity = '$available_quantity',
        availability_status = '$availability_status',
        category = '$category',
        size = '$size',
        modification_date = '$modification_date',
        image = '$new_image_data'
    WHERE id = $id
    ";

    $link->query($update_query);

    // Przekierowywanie na stronę z listą produktów po zaktualizowaniu
    header('Location: products.php');
    exit();
}





//////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_SESSION['login']) && $_SESSION['login']) {
    if (isset($_GET['edit_id'])) {
        EdytujPodstrone($_GET['edit_id'], $link);
    } elseif (isset($_GET['add_new'])) {
        DodajNowaPodstrone($link);
    } elseif (isset($_GET['delete_id'])) {
        UsunPodstrone($_GET['delete_id'], $link);
    } else {
        listaPodstron($link);
    }
} else {
    FormularzLogowania();
}

//---------------------------------------------------------------//
//           Wywoływanie funkcji do obsługi Kategorii            //
//---------------------------------------------------------------//

PokazKategorie($link);
DodajKategorie($link);
UsunKategorie($link);
EdytujKategorie($link);


PokazProdukty();


?>