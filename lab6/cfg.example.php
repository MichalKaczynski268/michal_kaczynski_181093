<?php

$host = '127.0.0.1';
$port = 3306;
$baza = 'moja_strona';
$uzytkownik = 'UZUPELNIJ_LOGIN';
$haslo = 'UZUPELNIJ_HASLO';

$dsn = "mysql:host=$host;port=$port;dbname=$baza;charset=utf8mb4";

$pdo = new PDO($dsn, $uzytkownik, $haslo, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);