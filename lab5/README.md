# VolleyShop — laboratorium 5

## Uruchomienie

Umieść katalog lab5 w folderze htdocs w XAMPP i uruchom Apache.

Adres strony:
http://localhost/lab5/index.php

Na macOS Apache można uruchomić poleceniem:

sudo /Applications/XAMPP/xamppfiles/xampp startapache

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
- Dane produktów pozostają w includes/produkty.php.
- Link powrotny z katalogu prowadzi do index.php.
- status.php pozostaje osobnym adresem AJAX.

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

## Pseudokod wyboru widoku

1. Zdefiniuj mapę identyfikatorów, tytułów i stałych ścieżek.
2. Odczytaj idp z GET.
3. Jeśli parametru nie ma lub jest pustym tekstem, wybierz glowna.
4. Jeśli idp nie jest tekstem lub nie istnieje w mapie:
   - ustaw HTTP 404;
   - przygotuj komunikat i link do strony głównej.
5. Dla poprawnego klucza:
   - pobierz tytuł i ścieżkę z mapy;
   - zbuduj ścieżkę względem __DIR__;
   - sprawdź is_file() i is_readable().
6. Jeśli plik nie istnieje lub nie jest czytelny:
   - ustaw HTTP 500;
   - przygotuj komunikat bez ścieżki systemowej.
7. Wygeneruj wspólny szablon i menu z mapy.
8. W main dołącz sprawdzony plik albo pokaż komunikat błędu.

## Zadanie 2 — podstrony i obsługa błędów

Dodałem mapę podstron: glowna, produkt, kontakt i filmy.
Każda podstrona ma w niej swój tytuł i ścieżkę do pliku.
Na podstawie tej mapy powstaje menu i tytuł w karcie przeglądarki.
Aktywna pozycja menu ma atrybut aria-current="page".

Parametr idp wybiera podstronę. Jeśli go nie ma albo jest pusty,
otwiera się strona główna. Nieznana wartość lub tablica daje błąd 404.

Przed wczytaniem fragmentu sprawdzam, czy plik istnieje i czy można
go odczytać. Jeśli nie, strona zwraca błąd 500 i pokazuje komunikat
bez ścieżki systemowej.

Ścieżki do plików pochodzą wyłącznie z mapy, a nie bezpośrednio z adresu.
Tytuły wypisywane w HTML przechodzą przez htmlspecialchars() z UTF-8.

### Adresy

- index.php — strona główna.
- index.php?idp=glowna — strona główna.
- index.php?idp=produkt — produkt.
- index.php?idp=kontakt — kontakt.
- index.php?idp=filmy — filmy.
- lab4.php — katalog z filtrem i zapisem wyboru.
- status.php — adres używany przez AJAX.

### Sprawdzenie działania

Testy wykonałem lokalnie w przeglądarce.
Kody odpowiedzi sprawdziłem w panelu Network.

| Co sprawdziłem | Co miało się stać | Wynik |
|---|---|---|
| Otworzyłem index.php i index.php?idp=. | Oba adresy otwierają stronę główną i zwracają 200. | Działa, oba adresy zwracają 200. |
| Przeszedłem przez menu oraz linki do produktu i kontaktu. | Otwierają się właściwe treści, zmienia się tytuł i oznaczenie aktywnej pozycji menu. | Wszystko działa poprawnie. |
| Wpisałem index.php?idp=nieznana. | Błąd 404, komunikat i link do strony głównej, bez ostrzeżeń PHP. | Wynik zgodny z oczekiwanym. |
| Wpisałem index.php?idp[]=filmy. | Błąd 404, komunikat i link powrotny, bez ostrzeżeń PHP. | Wynik zgodny z oczekiwanym. |
| Wpisałem index.php?idp=..%2Fstatus.php. | Błąd 404, bez wczytania zawartości status.php. | Działa, plik nie został dołączony. |
| Tymczasowo zmieniłem nazwę html/filmy.html i otworzyłem podstronę Filmy. | Błąd 500 i komunikat bez ścieżki systemowej. Po przywróceniu nazwy znowu 200. | Wszystko zgodnie z oczekiwaniem. Przywróciłem nazwę pliku. |
| Sprawdziłem stronę główną i kliknąłem „Sprawdź serwer”. | Zasoby strony działają, status.php zwraca 200, a wynik pojawia się na stronie. | Działa poprawnie. |
| W katalogu użyłem filtra i zapisałem wybór. Potem przeszedłem na stronę główną, do Filmów i z powrotem do katalogu. | Po zapisie POST 303, potem GET 200. Wybór nadal jest widoczny po powrocie. | Filtr działa, kody się zgadzają i wybór został zapamiętany. |

### Najważniejsze różnice

- idp wybiera podstronę, a kategoria filtruje produkty w katalogu.
- 404 oznacza, że podana podstrona nie istnieje lub identyfikator jest niepoprawny.
- 500 oznacza problem po stronie serwera, np. brak pliku podstrony zapisanej w mapie.

## Co zostało do zrobienia

Podstrona Filmy jest już w menu i ma swój plik.
W zadaniu 3 dodam trzy filmy i sprawdzę odtwarzanie, linki
oraz wygląd strony przy szerokości 360 px.



## Zadanie 3 — filmy

Dodałem w html/filmy.html trzy filmy związane z siatkówką:
podstawy odbicia dołem, zagrywkę i podstawowe umiejętności siatkarskie.

Każdy film jest osadzony przez iframe, ma nagłówek, opisowy atrybut
title oraz osobny link do materiału na YouTube.
Autoodtwarzanie jest wyłączone.

Odtwarzacze dopasowują szerokość do kontenera.
Użyłem aspect-ratio oraz minimalnych wymiarów 200 × 200 px.

### Sprawdzenie działania

| Co sprawdziłem | Co miało się stać | Wynik |
|---|---|---|
| Otworzyłem Filmy z menu i uruchomiłem każdy materiał. | Wszystkie trzy filmy można odtworzyć bez wychodzenia ze strony. | Wszystkie trzy działają. |
| Sprawdziłem stronę przed kliknięciem odtwarzania. | Filmy nie uruchamiają się automatycznie. | Żaden film nie uruchamia się sam. |
| Kliknąłem link pod każdym odtwarzaczem. | Każdy link otwiera odpowiedni materiał na YouTube. | Wszystkie linki działają poprawnie. |
| Ustawiłem szerokość widoku na 360 px. | Odtwarzacze mieszczą się na stronie i nie ma przewijania w poziomie. | Wszystko mieści się w widoku, bez przewijania na boki. |
| Przeszedłem po stronie klawiszem Tab. | Można dotrzeć do linków pod filmami. | Linki są dostępne z klawiatury. |

## Stan końcowy

W lab5 pozostają trzy osobne wejścia:
- index.php — podstrony ze wspólnym szablonem;
- lab4.php — katalog z filtrem, formularzem i sesją;
- status.php — odpowiedź dla AJAX.

Treści podstron są w html/, a dane produktów w includes/produkty.php.
Kolejną podstronę można dodać przez utworzenie fragmentu
i dopisanie go do mapy w index.php.