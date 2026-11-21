<?php
ini_set('display_errors', '0');
ini_set('log_errors', '1');

$projekt = 'VolleyShop v1.5';

require_once __DIR__ . '/showpage.php';

$idp = array_key_exists('idp', $_GET) ? $_GET['idp'] : '';

if ($idp === '') {
    $idp = 'glowna';
}

$poprawnyAlias = is_string($idp)
    && preg_match('/\A[a-z0-9-]{1,20}\z/', $idp) === 1;

$menu = [];
$strona = null;
$blad = '';
$tytul = 'Nie znaleziono podstrony';

try {
    require_once __DIR__ . '/cfg.php';

    $zapytanieMenu = $pdo->query(
        'SELECT alias, page_title
         FROM page_list
         WHERE status = 1
         ORDER BY id'
    );

    $menu = $zapytanieMenu->fetchAll(PDO::FETCH_ASSOC);

    if ($poprawnyAlias) {
        $strona = PokazPodstrone($pdo, $idp);
    }

    if ($strona === null) {
        http_response_code(404);
        $blad = 'Nie znaleziono podstrony.';
    } else {
        $tytul = $strona['page_title'];
    }
} catch (PDOException $e) {
    error_log('VolleyShop — błąd bazy danych: ' . $e->getMessage());

    http_response_code(500);
    $tytul = 'Błąd serwera';
    $blad = 'Strona jest chwilowo niedostępna. Spróbuj ponownie później.';
    $strona = null;
    $menu = [];
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
        <?php foreach ($menu as $pozycja): ?>
            <a href="index.php?idp=<?php
                echo htmlspecialchars(
                    rawurlencode($pozycja['alias']),
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>"
                <?php
                if ($idp === $pozycja['alias']) {
                    echo 'aria-current="page"';
                }
                ?>>
                <?php
                echo htmlspecialchars(
                    $pozycja['page_title'],
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
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
if ($strona !== null) {
    echo $strona['page_content'];
} else {
    echo '<h1>' . htmlspecialchars($tytul, ENT_QUOTES, 'UTF-8') . '</h1>';
    echo '<p>' . htmlspecialchars($blad, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p><a href="index.php">Powrót do strony głównej</a></p>';
}
?>
</main>

<footer>
    <p><?php
        echo htmlspecialchars($projekt, ENT_QUOTES, 'UTF-8');
    ?> — projekt na laboratorium Programowania Aplikacji WWW.</p>
</footer>
</body>
</html>