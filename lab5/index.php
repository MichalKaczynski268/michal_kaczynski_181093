<?php
$projekt = 'VolleyShop';

$widoki = [
    'glowna' => [
        'tytul' => 'Katalog',
        'plik' => 'html/glowna.html',
    ],
    'produkt' => [
        'tytul' => 'Produkt',
        'plik' => 'html/produkt.html',
    ],
    'kontakt' => [
        'tytul' => 'Kontakt',
        'plik' => 'html/kontakt.html',
    ],
    'filmy' => [
        'tytul' => 'Filmy',
        'plik' => 'html/filmy.html',
    ],
];

$idp = array_key_exists('idp', $_GET) ? $_GET['idp'] : '';
$plik = null;
$blad = '';
$tytul = 'Nie znaleziono podstrony';

if ($idp === '') {
    $idp = 'glowna';
}

if (!is_string($idp) || !array_key_exists($idp, $widoki)) {
    http_response_code(404);
    $blad = 'Nie znaleziono podstrony.';
} else {
    $tytul = $widoki[$idp]['tytul'];
    $sciezka = __DIR__ . '/' . $widoki[$idp]['plik'];

    if (!is_file($sciezka) || !is_readable($sciezka)) {
        http_response_code(500);
        $tytul = 'Błąd serwera';
        $blad = 'Nie można wczytać treści podstrony.';
    } else {
        $plik = $sciezka;
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
        echo htmlspecialchars($tytul . ' — ' . $projekt, ENT_QUOTES, 'UTF-8');
    ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
    <script src="js/vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>
<body>
<header>
    <p>VolleyShop — wszystko do siatkówki</p>

    <nav aria-label="Menu główne">
        <?php foreach ($widoki as $klucz => $widok): ?>
            <a href="index.php?idp=<?php echo htmlspecialchars($klucz, ENT_QUOTES, 'UTF-8'); ?>"
                <?php if ($idp === $klucz) echo 'aria-current="page"'; ?>>
                <?php echo htmlspecialchars($widok['tytul'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>

        <a href="lab4.php">Katalog PHP</a>

        <button type="button" id="theme-toggle" aria-pressed="false">
            Tryb ciemny
        </button>
    </nav>
</header>

<main>
<?php
if ($plik !== null) {
    include $plik;
} else {
    echo '<h1>' . htmlspecialchars($tytul, ENT_QUOTES, 'UTF-8') . '</h1>';
    echo '<p>' . htmlspecialchars($blad, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p><a href="index.php">Powrót do strony głównej</a></p>';
}
?>
</main>

<footer>
    <p><?php echo $projekt; ?> — projekt na laboratorium Programowania Aplikacji WWW.</p>
</footer>
</body>
</html>