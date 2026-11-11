# VolleyShop — Laboratorium 4

Katalog PHP z filtrem GET, formularzem POST i sesją.

## Uruchomienie

Umieść projekt w `htdocs/lab4`, uruchom Apache w XAMPP
i otwórz `http://localhost/lab4/`. Wybierz „Katalog PHP”.

## Organizacja i działanie

- `lab4.php` — katalog, formularze, walidacja i sesja.
- `includes/produkty.php` — cztery produkty; wczytywanie przez `require_once`.
- `includes/naglowek.php` — nagłówek dołączany przez `include`.
- `index.html`, `status.php` — katalog główny.
- `html/`, `css/`, `js/`, `img/` — podstrony i zasoby.

`include` dołącza nagłówek, a `require_once` wczytuje wymagane dane
tylko raz. Ścieżki PHP korzystają z `__DIR__`.

GET filtruje kategorie: `wszystkie`, `ksiazki`, `akcesoria`.
Błędny filtr pokazuje pełną listę i komunikat.

POST sprawdza pola, całkowite wartości, istnienie produktu
oraz ilość 1–5 nieprzekraczającą stanu.
Błąd daje 400 i nie zmienia sesji.
Poprawny wybór trafia do `$_SESSION['ostatni_wybor']`,
po czym następuje przekierowanie 303 i `exit`.

Widok pokazuje nazwę z katalogu i ilość albo komunikat o braku wyboru.
Dynamiczny tekst zabezpiecza `htmlspecialchars()` z UTF-8.

Zastosowano `while` do katalogu, `if/elseif/else` do stanu,
`switch` do kategorii i `for` do opcji ilości.

## Pseudokod

Sesja → dane → sprawdzenie POST → walidacja.
Błąd: 400 i komunikat, bez zmiany sesji.
Sukces: zapis sesji → 303 → exit.
Następnie: filtr GET → katalog, formularze i podsumowanie.

## Testy

Środowisko: Apache/XAMPP, Chrome, DevTools.
Kroki prób: `TESTY.md`.

| Próba | Oczekiwane | Rzeczywiste |
|---|---|---|
| Filtr książek | Dwie książki | Zgodne |
| Nieznana kategoria i tablica GET | Pełna lista i komunikat | Zgodne |
| Mikasa, 2 sztuki | POST 303 → GET 200, zapis | Zgodne po poprawce |
| Odświeżenie i zmiana filtra | Zapis pozostaje, brak ponownego POST | Zgodne |
| Ilości 0, 6, 2.5, 2abc | 400, komunikat, zapis bez zmian | Zgodne |
| Brak ilości, tablica, ID 999 | 400, komunikat, zapis bez zmian | Zgodne |
| Stan 1/ilość 2 oraz stan 0/ilość 1 | 400, zapis bez zmian | Zgodne |
| Nowa sesja | Brak wyboru; stara sesja bez zmian | Zgodne |
| Nazwa `<b>Test</b>` | Dosłowny tekst | Zgodne |
| Klawiatura | Widoczny fokus, obsługa formularzy | Zgodne |
| Strony, zasoby, linki, animacje | Poprawne działanie | Zgodne |
| `status.php` | 200 i wynik na stronie | Zgodne |
| Limit 3: ilości 3 i 4 | 3 przyjęte, 4 odrzucone | Zgodne |

Po testach przywrócono limit 5 i oryginalną nazwę piłki.

## Poprawiony błąd

POST początkowo zwracał 400: tekstowe ID porównywano przez `===`
z liczbą w katalogu. Dodano walidację ID przez `FILTER_VALIDATE_INT`.
Ponowny test zapisu przeszedł poprawnie.