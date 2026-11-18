<?php
$projekt = 'VolleyShop';
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VolleyShop — sklep siatkarski</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
    <script src="js/vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>
<body>
<header>
    <p>VolleyShop — wszystko do siatkówki</p>

    <nav aria-label="Menu główne">
        <a href="index.php" aria-current="page">Katalog</a>
        <a href="lab4.php">Katalog PHP</a>
        <button type="button" id="theme-toggle" aria-pressed="false">
            Tryb ciemny
        </button>
    </nav>
</header>

<main>
    <?php include __DIR__ . '/html/glowna.html'; ?>
</main>

<footer>
    <p><?php echo $projekt; ?> — projekt na laboratorium Programowania Aplikacji WWW.</p>
</footer>
</body>
</html>