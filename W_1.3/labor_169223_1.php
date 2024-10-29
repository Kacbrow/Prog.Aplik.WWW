<?php

echo 'Kacper Browarek <br /><br />';


$nr_indeksu = '169223';
$nrGrupy = '1';
echo 'Kacper Browarek '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';




echo 'Warunki if, else, elseif, switch <br />';

$liczba = 10;
if ($liczba < 5) {
    echo 'Liczba jest mniejsza niż 5 <br />';
} elseif ($liczba == 10) {
    echo 'Liczba jest równa 10 <br />';
} else {
    echo 'Liczba jest większa niż 5 <br />';
}

$kolor = 'czerwony';
switch ($kolor) {
    case 'niebieski':
        echo 'Kolor to niebieski <br />';
        break;
    case 'czerwony':
        echo 'Kolor to czerwony <br />';
        break;
    default:
        echo 'Kolor jest nieznany <br />';
}


echo 'Pętla while i for <br />';


$i = 1;
while ($i <= 5) {
    echo 'Liczba z pętli while: '.$i.' <br />';
    $i++;
}


for ($j = 1; $j <= 5; $j++) {
    echo 'Liczba z pętli for: '.$j.' <br />';
}


echo 'if <br />';
$a = 15;

if ($a == 2 || $a == 3 || $a == 4 || $a == 5 || $a == 6 || $a == 15) {
  echo "$a to liczba z zakresu od 2 do 15<br />";
}
echo '<br />';
if ($a > 10) {
  echo "Powyżej 10";
  if ($a > 20) {
    echo " a także powyżej 20<br />";
  } else {
    echo " ale nie powyżej 20 <br />";
  }
}

$favcolor = "red";
echo '<br />';
switch ($favcolor) {
  case "red":
    echo "Twój ulubiony kolor to czerwony!<br />";
    break;
  case "blue":
    echo "Twój ulubiony kolor to niebieski!<br />";
    break;
  case "green":
    echo "Twój ulubiony kolor to zielony!<br />";
    break;
  default:
    echo "Twój ulubiony kolor nie jest ani czerwony, ani niebieski, ani zielony!<br />";
}
$d = 4;
echo '<br />';
switch ($d) {
  case 6:
    echo "Dziś jest sobota<br />";
    break;
  case 0:
    echo "Dziś jest niedziela<br />";
    break;
  default:
    echo "Nie mogę się doczekać weekendu<br />";
}
echo '<br />';
$i = 1;
while ($i < 6) {
  echo $i;
  $i++;
}


echo 'Typy zmiennych $_GET, $_POST, $_SESSION <br />';


if (isset($_GET['nazwa'])) {
    echo 'Dane z $_GET: '.$_GET['nazwa'].' <br />';
} else {
    echo 'Brak danych w $_GET <br />';
}


if (isset($_POST['nazwa'])) {
    echo 'Dane z $_POST: '.$_POST['nazwa'].' <br />';
} else {
    echo 'Brak danych w $_POST <br />';
}

session_start(); 
if (!isset($_SESSION['odwiedziny'])) {
    $_SESSION['odwiedziny'] = 1;
} else {
    $_SESSION['odwiedziny']++;
}
echo 'Liczba odwiedzin: '.$_SESSION['odwiedziny'].'<br />';


?>
