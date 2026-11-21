# Testy — Laboratorium 4

Chrome, Apache/XAMPP, DevTools Network z „Keep log”.
Wyniki oczekiwane i rzeczywiste znajdują się w README.md.

## Wykonane próby

1. GET: wybrano książki, następnie otwarto katalog z
   `?kategoria=nieznana` i `?kategoria[]=ksiazki`.

2. POST: zapisano piłkę Mikasa z ilością 2; sprawdzono
   POST 303 → GET 200, odświeżenie i zmianę filtra.

3. Błędne dane: w Elements zmieniano ilość na 0, 6, 2.5, 2abc,
   usunięto `name="ilosc"`, użyto `ilosc[]` i ID produktu 999.
   Każda próba dała 400 i zachowała poprzedni wybór.

4. Magazyn: wysłano „Trening siatkarski” z ilością 2
   oraz „Podstawy siatkówki” z ilością 1.
   Oba wybory odrzucono kodem 400.

5. Sesja: w nowej sesji incognito nie było wyboru;
   w zwykłym oknie wcześniejszy wybór pozostał.

6. HTML: tymczasowa nazwa `<b>Test</b>` była dosłownym tekstem
   na karcie, liście i w podsumowaniu.

7. Klawiatura: oba formularze obsłużono przez Tab, strzałki i Enter;
   fokus był widoczny.

8. Ścieżki: sprawdzono strony, obrazy, style, linki i animacje.
   Pobranie `status.php` dało 200 i wynik na stronie.

9. Limit: tymczasowo zmieniono maksimum na 3 w walidacji,
   komunikacie i pętli opcji. Mikasa/3 dała 303 → 200,
   a Mikasa/4 przesłana po edycji opcji — 400 bez zmiany zapisu.

Po próbach przywrócono limit 5 i oryginalną nazwę piłki.