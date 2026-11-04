
# VolleyShop — Laboratorium 3

Projekt sklepu siatkarskiego rozwijany na zajęciach Programowanie
Aplikacji WWW. Laboratorium 3 rozszerza projekt z laboratorium 2
o animacje jQuery oraz komunikację AJAX z serwerem PHP.

## Uruchomienie

1. Zainstaluj XAMPP.
2. Umieść katalog lab3 w folderze htdocs w katalogu instalacji XAMPP.
3. Uruchom Apache w panelu XAMPP.
4. Otwórz w przeglądarce:
   http://localhost/lab3/

Test PHP jest dostępny pod adresem:
http://localhost/lab3/status.php

Projekt należy uruchamiać przez HTTP, a nie przez bezpośrednie
otwieranie plików HTML.

## Biblioteki i technologie

- HTML i CSS.
- JavaScript.
- jQuery 4.0.0 — pełna wersja, zapisana lokalnie jako
  vendor/jquery-4.0.0.min.js.
- PHP uruchamiane przez Apache w XAMPP.

## Funkcje projektu

- Funkcje sklepu z laboratorium 2: zmiana motywu, zegar,
  wyszukiwarka produktów i formularz.
- Animacja A: przełączanie rozmiaru po kliknięciu.
- Animacja B: zmiana rozmiaru po najechaniu lub uzyskaniu fokusu.
- Animacja C: powiększanie po kolejnych kliknięciach,
  maksymalnie do pięciu kroków.
- Reset animacji A i C.
- Obsługa preferencji ograniczenia ruchu.
- Przycisk „Sprawdź serwer”, pobierający odpowiedź z status.php
  bez przeładowania strony.

## Pseudokody animacji

### Animacja A

1. Po kliknięciu zmień stan powiększenia na przeciwny.
2. Zaktualizuj aria-pressed.
3. Zatrzymaj bieżącą animację i usuń kolejkę.
4. Animuj do rozmiaru wynikającego z nowego stanu.

### Animacja B

1. Zapamiętuj, czy kursor znajduje się nad przyciskiem.
2. Zapamiętuj, czy przycisk ma fokus.
3. Powiększ przycisk, jeśli przynajmniej jeden z tych stanów jest aktywny.
4. Przywróć rozmiar bazowy dopiero po utracie obu stanów.
5. Przed zmianą rozmiaru zatrzymaj animację i usuń kolejkę.

### Animacja C

1. Po kliknięciu sprawdź, czy animacja jest w toku.
2. Jeśli trwa animacja lub osiągnięto pięć kroków, pomiń kliknięcie.
3. Zwiększ licznik kroków.
4. Oblicz rozmiar na podstawie rozmiaru bazowego i licznika.
5. Zaktualizuj licznik na stronie i wykonaj animację.

### Reset A i C

1. Zatrzymaj animacje A i C oraz usuń ich kolejki.
2. Przywróć bazowe wymiary obu przycisków.
3. Przywróć bazowy stan A i aria-pressed="false".
4. Wyzeruj licznik kroków C i zaktualizuj go na stronie.

## Testy AJAX i PHP

### Bezpośredni test PHP

Kroki: Otwarcie http://localhost/lab3/status.php.

Oczekiwany wynik: Napis „PHP działa”.

Wynik rzeczywisty: Wyświetlono „PHP działa”.

### Poprawna odpowiedź AJAX

Kroki: Kliknięcie „Sprawdź serwer” i sprawdzenie żądania w Network.

Oczekiwany wynik: Metoda GET, status 200, odpowiedź „PHP działa”,
bez przeładowania strony.

Wynik rzeczywisty: Wysłano żądanie GET, otrzymano status 200
i odpowiedź „PHP działa”. Strona nie przeładowała się.

### Brak pliku

Kroki: Tymczasowa zmiana nazwy status.php na status-test.php
i kliknięcie „Sprawdź serwer”.

Oczekiwany wynik: Status 404, komunikat błędu i ponowne
odblokowanie przycisku.

Wynik rzeczywisty: Otrzymano status 404 i wyświetlono komunikat
błędu. Przycisk ponownie stał się aktywny.

### Ponowna próba

Kroki: Przywrócenie nazwy status.php i ponowne kliknięcie przycisku.

Oczekiwany wynik: Status 200 i odpowiedź „PHP działa”.

Wynik rzeczywisty: Otrzymano status 200 i wyświetlono „PHP działa”.

### Wolna sieć

Kroki: Włączenie profilu 3G w Network i kliknięcie „Sprawdź serwer”.

Oczekiwany wynik: Stan „Ładowanie…”, wyłączenie przycisku na czas
żądania i ponowne włączenie po jego zakończeniu. Po otrzymaniu
odpowiedzi wyświetlenie jej treści.

Wynik rzeczywisty: Pojawił się stan „Ładowanie…”, a przycisk był
nieaktywny podczas oczekiwania. Po zakończeniu wyświetlono
„PHP działa”, a przycisk ponownie stał się aktywny.
Strona nie przeładowała się.

### Liczba żądań

Kroki: Sprawdzenie liczby nowych żądań status.php po jednym kliknięciu.

Oczekiwany wynik: Jedno kliknięcie wysyła jedno żądanie.

Wynik rzeczywisty: Jedno kliknięcie przycisku wysyłało jedno
żądanie do status.php.

## Testy animacji i wcześniejszych funkcji

### Szybkie kliknięcia A

Kroki: Reset, a następnie 10 szybkich kliknięć A.

Oczekiwany wynik: Stan bazowy, aria-pressed="false", brak odtwarzania
zaległej kolejki animacji.

Wynik rzeczywisty: Po resecie i 10 szybkich kliknięciach przycisk A
wrócił do rozmiaru bazowego, a aria-pressed miało wartość "false".
Nie odtwarzał zaległej kolejki animacji.

### Kursor i fokus B

Kroki: Ustawienie fokusu na B, najechanie i wyjście kursorem,
a następnie przeniesienie fokusu poza B.

Oczekiwany wynik: B pozostaje powiększony przy zachowanym fokusie.
Po utracie fokusu i wyjściu kursora wraca do rozmiaru bazowego.

Wynik rzeczywisty: Przycisk B pozostawał powiększony po wyjściu
kursora, gdy nadal miał fokus. Po utracie fokusu i przy kursorze
poza przyciskiem wracał do rozmiaru bazowego.

### Limit i reset C

Kroki: Wykonanie pięciu kroków C, próba dalszego powiększenia
oraz reset podczas animacji.

Oczekiwany wynik: Maksymalny rozmiar 260 × 140 px i licznik 5.
Dalsze kliknięcia nie powiększają przycisku.
Reset natychmiast przywraca rozmiar bazowy i zeruje licznik.

Wynik rzeczywisty: Po pięciu krokach przycisk C osiągnął rozmiar
260 × 140 px, a licznik wskazywał 5. Kolejne kliknięcia nie
powiększały przycisku. Reset podczas animacji przywracał rozmiar
bazowy i zerował licznik.

### Klawiatura

Kroki: Nawigacja klawiszem Tab oraz użycie Enter i Spacji.

Oczekiwany wynik: Widoczny fokus i działanie przycisków A, C oraz resetu.

Wynik rzeczywisty: Klawisz Tab przenosił fokus między przyciskami.
Fokus był widoczny. Enter i Spacja poprawnie uruchamiały
przyciski A, C oraz reset.

### Ograniczenie ruchu

Kroki: Włączenie preferencji ograniczenia ruchu w narzędziach
przeglądarki, przeładowanie strony i sprawdzenie przycisków.

Oczekiwany wynik: Zmiany rozmiarów są natychmiastowe,
a funkcje nadal działają.

Wynik rzeczywisty: Po włączeniu preferencji ograniczenia ruchu
i przeładowaniu strony zmiany rozmiarów były natychmiastowe.
Przyciski nadal działały poprawnie.

### Wąski ekran

Kroki: Ustawienie szerokości widoku na 360 px.

Oczekiwany wynik: Przyciski zawijają się i mieszczą na ekranie.

Wynik rzeczywisty: Przy szerokości widoku 360 px przyciski
zawijały się i mieściły na ekranie.

### Funkcje z laboratorium 2

Kroki: Sprawdzenie motywu, zegara, wyszukiwarki i formularza.

Oczekiwany wynik: Wcześniejsze funkcje nadal działają.

Wynik rzeczywisty: Motyw, zegar, wyszukiwarka i formularz
nadal działały poprawnie.

## Źródła grafik

Zdjęcia produktów wykorzystane w celach edukacyjnych:
* https://sportplus.pl/pilki-siatkowe-mikasa/2613-pilka-do-siatkowki-mikasa-v200w-rozmiar-5.html?srsltid=AU7gw4WiGHZB66HUvasi1wnCH0MvQxCi-kqVaCxZoQDVwpC0o9hx8ect
* https://zaksa.pl/kategoria-produktu/kolekcja-sportowa/koszulki-meczowe/

* [img/nakolannikimizuno.jpg — materiały produktowe nakolanników siatkarskich Mizuno.](https://www.studio-sport.pl/nakolanniki-siatkarskie-mizuno-vs-1-cz?srsltid=AU7gw4XlTkhD0Q58QRif16__ORAsNNzQ08y2dhgtyKKLkHYLTpKizOhH)
