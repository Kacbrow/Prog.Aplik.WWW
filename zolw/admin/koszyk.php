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
//	       Metoda do dodawania produktu do koszyka 		         //
//---------------------------------------------------------------//
function addToCart($productId, $quantity, $link) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $stmt = $link->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p>Produkt o podanym ID nie istnieje.</p>";
        return;
    }

    $product = $result->fetch_assoc();

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'title' => $product['title'],
            'net_price' => $product['net_price'],
            'vat_tax' => $product['vat_tax'],
            'quantity' => $quantity
        ];
    }

    header("Location: koszyk.php?action=show");
    exit();
}

//---------------------------------------------------------------//
//					Metoda do usuwania podstron  		     	 //
//---------------------------------------------------------------//
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]); // Usuń produkt z koszyka
        echo "<p>Produkt został usunięty z koszyka.</p>";
    } else {
        echo "<p>Produkt nie znajduje się w koszyku.</p>";
    }
}


// Wyświetl koszyk
function showCart($link) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Koszyk jest pusty.</p>";
        return;
    }

    echo "<h2>Zawartość Koszyka</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Cena brutto</th>
                <th>Łączna cena brutto</th>
                <th>Akcje</th>
            </tr>";

    $total = 0;

    foreach ($_SESSION['cart'] as $id => $item) {
        $gross_price = $item['net_price'] * (1 + $item['vat_tax'] / 100);
        $total_price = $gross_price * $item['quantity'];
        $total += $total_price;

        echo "<tr>
                <td>{$id}</td>
                <td>{$item['title']}</td>
                <td>{$item['quantity']}</td>
                <td>{$item['net_price']} PLN</td>
                <td>{$item['vat_tax']}%</td>
                <td>" . number_format($gross_price, 2) . " PLN</td>
                <td>" . number_format($total_price, 2) . " PLN</td>
                <td><a href='koszyk.php?action=remove&product_id={$id}'>Usuń</a></td>
              </tr>";
    }


    echo "</table>";
    echo "<p><b>Łączna wartość brutto: " . number_format($total, 2) . " PLN</b></p>";
}

//---------------------------------------------------------------//
//							 Obsługa akcji	  					 //
//---------------------------------------------------------------//

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
                $productId = intval($_GET['product_id']);
                $quantity = intval($_GET['quantity']);
                addToCart($productId, $quantity, $link);
            }
            break;

        case 'remove':
            if (isset($_GET['product_id'])) {
                $productId = intval($_GET['product_id']);
                removeFromCart($productId);
            }
            break;

        case 'show':
        default:
            showCart($link);
            break;
    }
}
?>
