# Raport z testów - Lab 2

- Sprzęt i przeglądarka: macOS, Brave / Chrome
- Serwer: Python http.server (port 8000)

1. Motyw i pamięć w przeglądarce
- Jak testowałem: Kliknąłem tryb ciemny, odświeżyłem stronę i przeszedłem do kontaktu.
- Wynik: Ciemny motyw nie znika po F5 ani po zmianie podstrony. Atrybuty na stronie zmieniają się tak, jak powinny.
- Działa: Tak.

2. Klikanie Startu zegara na pałę
- Jak testowałem: Kliknąłem „Start zegara” 3 razy z rzędu, potem Stop i znowu Start.
- Wynik: Zegar nie oszalał i sekundy nie lecą za szybko. Stop zatrzymuje odliczanie, a ponowny Start od razu pobiera aktualną godzinę.
- Działa: Tak.

3. Szukanie z dziwnym tekstem (spacje, duże litery)
- Jak testowałem: Wpisałem w wyszukiwarkę `   MIKASA   `.
- Wynik: Skrypt obcina spacje, olewa wielkość liter i zostawia tylko piłkę Mikasa. Licznik pokazuje 1 wynik.
- Działa: Tak.

4. Wpisanie bzdur w szukajkę i czyszczenie
- Jak testowałem: Wpisałem `xyz`, a potem skasowałem to Backspacem.
- Wynik: Przy `xyz` wszystko znika, licznik pokazuje 0 i wyskakuje napis, że nic nie ma. Po skasowaniu wracają wszystkie 3 produkty.
- Działa: Tak.

5. Test samej funkcji liczącej w konsoli
- Jak testowałem: Wbiłem w konsolę DevTools `calculateTotalGrosze(1999, 3)`.
- Wynik: Zwróciło 5997 groszy, a na stronie ładnie formatuje to jako 59,97 zł. Zero błędów zaokrągleń.
- Działa: Tak.

6. Wpisywanie złych ilości (0, 6, 1.5, puste pole)
- Jak testowałem: Wpisywałem po kolei bzdury w pole liczby sztuk.
- Wynik: Zamiast ceny pojawia się komunikat, żeby podać liczbę od 1 do 5. Formularz nie pozwala wysłać zamówienia.
- Działa: Tak.

7. Test spacji i znacznika HTML w wiadomości
- Jak testowałem: Wpisałem 10 spacji, a w drugiej próbie tekst z tagiem `<b>Test</b>`.
- Wynik: Same spacje odrzuca i każe poprawić. Przy tagu HTML wyświetla dosłownie tekst `<b>Test</b>`, zamiast go pogrubiać (dzięki textContent nic się nie wstrzykuje).
- Działa: Tak.

8. Przeklikanie klawiaturą i wyłączenie JS
- Jak testowałem: Leciłem po stronie samym Tabem na małym i dużym ekranie, a potem wyłączyłem JavaScript w DevTools.
- Wynik: Da się wszystko obsłużyć klawiszem Tab i Enterem. Bez JS strona, produkty i menu nadal normalnie się wyświetlają.
- Działa: Tak.