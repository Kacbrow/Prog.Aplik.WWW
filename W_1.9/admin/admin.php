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


?>