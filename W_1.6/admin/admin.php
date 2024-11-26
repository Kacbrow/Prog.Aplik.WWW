<?php
include("../cfg.php");

session_start();

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


if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['login'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        FormularzLogowania('Błąd logowania: Niepoprawne hasło lub login');
        exit();
    }
}


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


function listaPodstron($link) {
    echo "<a href='?add_new=true'><b>Dodaj nową podstronę</b></a>";
    echo "<a href='?logout=true' style='margin-left: 20px;'><b>Wyloguj</b></a>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>";

    $result = $link->query("SELECT id, page_title FROM page_list LIMIT 10");
    while ($row = $result->fetch_array()) {
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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<p>Błąd podczas aktualizacji podstrony: " . $stmt->error . "</p>";
        }
    }
}


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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<p>Błąd podczas dodawania podstrony: " . $stmt->error . "</p>";
        }
    }
}


function UsunPodstrone($id, $link) {
    $stmt = $link->prepare("DELETE FROM page_list WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p>Błąd podczas usuwania: " . $stmt->error . "</p>";
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
?>
