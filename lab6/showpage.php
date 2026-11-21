<?php

function PokazPodstrone($pdo, $alias)
{
    $zapytanie = $pdo->prepare(
        'SELECT id, page_title, page_content
         FROM page_list
         WHERE alias = :alias AND status = 1
         LIMIT 1'
    );

    $zapytanie->execute(['alias' => $alias]);

    $strona = $zapytanie->fetch(PDO::FETCH_ASSOC);

    return $strona === false ? null : $strona;
}