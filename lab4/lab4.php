<?php
session_start();
require_once __DIR__ . '/includes/produkty.php';

$bladProduktu = '';
$bladIlosci = '';
$produktDoZapisu = null;
$ilosc = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produktTekst = $_POST['produkt'] ?? null;
    $iloscTekst = $_POST['ilosc'] ?? null;

    if (!is_string($produktTekst)) {
        $bladProduktu = 'Prześlij identyfikator produktu jako pojedynczą wartość.';
    } else {
        $idProduktu = filter_var($produktTekst, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]);

        if ($idProduktu !== false) {
            foreach ($produkty as $szukanyProdukt) {
                if ($szukanyProdukt['id'] === $idProduktu) {
                    $produktDoZapisu = $szukanyProdukt;
                    break;
                }
            }
        }

        if ($produktDoZapisu === null) {
            $bladProduktu = 'Wybierz istniejący produkt o całkowitym identyfikatorze.';
        }
    }

    if (!is_string($iloscTekst)) {
        $bladIlosci = 'Prześlij ilość jako pojedynczą wartość.';
    } else {
        $ilosc = filter_var($iloscTekst, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 5],
        ]);

        if ($ilosc === false) {
            $bladIlosci = 'Ilość musi być liczbą całkowitą od 1 do 5.';
        }
    }

    if ($produktDoZapisu !== null && $ilosc !== false) {
        if ($produktDoZapisu['stan'] === 0) {
            $bladProduktu = 'Ten produkt jest niedostępny.';
        } elseif ($ilosc > $produktDoZapisu['stan']) {
            $bladIlosci = 'Ilość przekracza dostępny stan produktu.';
        }
    }

    if ($bladProduktu === '' && $bladIlosci === '') {
        $_SESSION['ostatni_wybor'] = [
            'produkt' => $produktDoZapisu['id'],
            'ilosc' => $ilosc,
        ];

        header('Location: lab4.php', true, 303);
        exit;
    }

    http_response_code(400);
}

$kategoria = 'wszystkie';
$bladKategorii = '';

if (isset($_GET['kategoria'])) {
    if (
        is_string($_GET['kategoria'])
        && in_array($_GET['kategoria'], ['wszystkie', 'ksiazki', 'akcesoria'], true)
    ) {
        $kategoria = $_GET['kategoria'];
    } else {
        $bladKategorii = 'Niepoprawna kategoria. Wyświetlono wszystkie produkty.';
    }
}

$zapisanyProdukt = null;
$zapisanaIlosc = null;

if (isset($_SESSION['ostatni_wybor']['produkt'], $_SESSION['ostatni_wybor']['ilosc'])) {
    $zapisanaIlosc = $_SESSION['ostatni_wybor']['ilosc'];

    foreach ($produkty as $produktSesji) {
        if ($produktSesji['id'] === $_SESSION['ostatni_wybor']['produkt']) {
            $zapisanyProdukt = $produktSesji;
            break;
        }
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog PHP — VolleyShop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/naglowek.php'; ?>

<main>
<?php
$grupa = 'WWW-01';

echo '<h1>Katalog PHP</h1>';
echo '<p>Grupa: ' . $grupa . '</p>';
?>

<p><a href="index.html">Powrót do strony głównej</a></p>

<form action="lab4.php" method="get">
    <p>
        <label for="kategoria">Kategoria:</label>
        <select id="kategoria" name="kategoria">
            <option value="wszystkie"<?php if ($kategoria === 'wszystkie') echo ' selected'; ?>>Wszystkie</option>
            <option value="ksiazki"<?php if ($kategoria === 'ksiazki') echo ' selected'; ?>>Książki</option>
            <option value="akcesoria"<?php if ($kategoria === 'akcesoria') echo ' selected'; ?>>Akcesoria</option>
        </select>
    </p>
    <p><button type="submit">Filtruj</button></p>
</form>

<?php
if ($bladKategorii !== '') {
    echo '<p>' . htmlspecialchars($bladKategorii, ENT_QUOTES, 'UTF-8') . '</p>';
}
?>

<section class="products-grid" aria-label="Katalog produktów PHP">
<?php
$i = 0;

while ($i < count($produkty)) {
    $produkt = $produkty[$i];
    $i++;

    if ($kategoria !== 'wszystkie' && $produkt['kategoria'] !== $kategoria) {
        continue;
    }

    switch ($produkt['kategoria']) {
        case 'ksiazki':
            $etykieta = 'Książki';
            break;
        case 'akcesoria':
            $etykieta = 'Akcesoria';
            break;
        default:
            $etykieta = 'Nieznana kategoria';
    }

    echo '<article class="product-card">';
    echo '<h2>' . htmlspecialchars($produkt['nazwa'], ENT_QUOTES, 'UTF-8') . '</h2>';
    echo '<p>Kategoria: ' . htmlspecialchars($etykieta, ENT_QUOTES, 'UTF-8') . '</p>';

    if ($produkt['stan'] === 0) {
        echo '<p>Niedostępny</p>';
    } elseif ($produkt['stan'] <= 5) {
        echo '<p>Niski stan</p>';
    } else {
        echo '<p>Dostępny</p>';
    }

    echo '</article>';
}
?>
</section>

<section aria-labelledby="wybor-title">
    <h2 id="wybor-title">Wybierz produkt</h2>

<?php
if ($zapisanyProdukt !== null) {
    echo '<p>Ostatni poprawny wybór: '
        . htmlspecialchars($zapisanyProdukt['nazwa'], ENT_QUOTES, 'UTF-8')
        . ' — ilość: '
        . htmlspecialchars((string) $zapisanaIlosc, ENT_QUOTES, 'UTF-8')
        . '.</p>';
} else {
    echo '<p>Nie zapisano jeszcze żadnego wyboru.</p>';
}
?>

    <form action="lab4.php" method="post">
        <p>
            <label for="produkt">Produkt:</label>
            <select id="produkt" name="produkt" required>
<?php
foreach ($produkty as $produktOpcji) {
    echo '<option value="' . $produktOpcji['id'] . '">'
        . htmlspecialchars($produktOpcji['nazwa'], ENT_QUOTES, 'UTF-8')
        . '</option>';
}
?>
            </select>

<?php
if ($bladProduktu !== '') {
    echo '<span role="alert">'
        . htmlspecialchars($bladProduktu, ENT_QUOTES, 'UTF-8')
        . '</span>';
}
?>
        </p>

        <p>
            <label for="ilosc">Liczba sztuk:</label>
            <select id="ilosc" name="ilosc" required>
<?php
for ($iloscOpcji = 1; $iloscOpcji <= 5; $iloscOpcji++) {
    echo '<option value="' . $iloscOpcji . '">' . $iloscOpcji . '</option>';
}
?>
            </select>

<?php
if ($bladIlosci !== '') {
    echo '<span role="alert">'
        . htmlspecialchars($bladIlosci, ENT_QUOTES, 'UTF-8')
        . '</span>';
}
?>
        </p>

        <p><button type="submit">Zapisz wybór</button></p>
    </form>
</section>
</main>

<footer>
    <p>VolleyShop — projekt na laboratorium Programowania Aplikacji WWW.</p>
</footer>
</body>
</html>