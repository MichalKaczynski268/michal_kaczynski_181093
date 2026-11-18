# VolleyShop — laboratorium 5

## Uruchomienie

Umieść katalog lab5 w folderze htdocs w XAMPP i uruchom Apache.

Adres strony:
http://localhost/lab5/index.php

## Punkt odniesienia przed zmianami

Kroki:
1. Skopiowano cały lab4 do lab5.
2. Uruchomiono Apache.
3. Otwarto http://localhost/lab5/index.html.
4. Sprawdzono filtr katalogu, zapis wyboru i AJAX do status.php.

Oczekiwany wynik: funkcje działają jak w lab4.

Rzeczywisty wynik: filtr i zapis wyboru działają.
Żądanie AJAX działa, a jego wynik pojawia się na stronie.

## Zadanie 1 — wspólny szablon

- index.html zmieniono na index.php.
- index.php zawiera wspólny szablon, style i skrypty.
- Identyfikator projektu jest zapisany w zmiennej i wypisywany przez echo w stopce.
- Treść strony głównej przeniesiono do html/glowna.html.
- Z html/produkt.html i html/kontakt.html usunięto powtórzony szablon.
- Ścieżki zasobów są przygotowane względem index.php.
- lab4.php zachowuje filtr, formularz, sesję i przekierowanie.
- Link powrotny z katalogu prowadzi do index.php.
- status.php pozostaje osobnym adresem AJAX.
- Wybieranie podstron przez idp zostanie dodane w zadaniu 2.

## Sprawdzenie po zadaniu 1

### Strona główna

Kroki: otwarto index.php i sprawdzono obrazy, motyw, zegar,
wyszukiwarkę i animacje.

Oczekiwany wynik: elementy strony działają jak przed zmianami.

Rzeczywisty wynik: elementy strony działają poprawnie.

### AJAX

Kroki: kliknięto „Sprawdź serwer”.

Oczekiwany wynik: wynik żądania do status.php pojawia się na stronie.

Rzeczywisty wynik: wynik pojawia się na stronie.

### Katalog i sesja

Kroki:
1. Otwarto Katalog PHP z menu.
2. Użyto filtra kategorii.
3. Zapisano poprawny wybór.
4. Wrócono linkiem do strony głównej.
5. Ponownie otwarto katalog.

Oczekiwany wynik: filtr działa, wybór zapisuje się, link powrotny
otwiera index.php, a zapisany wybór pozostaje widoczny.

Rzeczywisty wynik: wszystkie wymienione funkcje działają poprawnie.