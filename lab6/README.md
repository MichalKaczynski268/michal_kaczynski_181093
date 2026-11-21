# VolleyShop — lab 6, część 1

Wersja projektu: v1.5.

Projekt rozwija lab5. Treści podstron są odczytywane z tabeli
page_list, a wspólny szablon pozostaje w index.php.

Zachowane zostały katalog lab4.php, includes/produkty.php,
sesja i status.php. Panel admin/admin.php zawiera nagłówek
„Panel CMS w przygotowaniu” i link do strony głównej.

## Uruchomienie i odtworzenie środowiska

### 1. Pliki i usługi

Umieść folder lab6 w katalogu htdocs środowiska XAMPP.
Wymagane są PHP ze sterownikiem pdo_mysql oraz MariaDB/MySQL.

Na moim Macu uruchamiam usługi poleceniami:

```bash
sudo /Applications/XAMPP/xamppfiles/xampp startapache
sudo /Applications/XAMPP/xamppfiles/xampp startmysql
```

Adres strony:

```text
http://localhost/lab6/index.php
```

Adres panelu CMS:

```text
http://localhost/lab6/admin/admin.php
```

### 2. Baza danych

W phpMyAdmin, korzystając z konta administracyjnego, utwórz
pustą bazę moja_strona z kodowaniem utf8mb4
i porównywaniem utf8mb4_unicode_ci.

Wybierz tę bazę i zaimportuj kolejno:

1. sql/schema.sql — strukturę tabeli.
2. sql/seed.sql — dane podstron.

Import wykonuj do pustej bazy. Nie importuj ponownie danych
do wypełnionej tabeli.

### 3. Lokalny użytkownik

Dla nowego konta wykonaj jako administrator poniższe polecenia.
Zastąp UZUPELNIJ_LOKALNE_HASLO własnym hasłem.

```sql
CREATE USER 'volley_reader'@'localhost'
IDENTIFIED BY 'UZUPELNIJ_LOKALNE_HASLO';

GRANT SELECT ON moja_strona.page_list
TO 'volley_reader'@'localhost';
```

Jeżeli konto już istnieje, pomiń CREATE USER i użyj jego
właściwego hasła.

### 4. Konfiguracja

Skopiuj cfg.example.php jako cfg.php i uzupełnij lokalnie:

- host: 127.0.0.1,
- port: 3306,
- baza: moja_strona,
- użytkownik: volley_reader,
- hasło: ustawione dla tego konta.

Zachowaj charset=utf8mb4, PDO::ERRMODE_EXCEPTION
i wyłączone PDO::ATTR_EMULATE_PREPARES.

cfg.php musi być wykluczony przez .gitignore.
Do repozytorium trafia cfg.example.php bez prawdziwych
danych dostępu.

Otwórz stronę główną i sprawdź podstrony oraz polskie znaki.

## Pseudokod odczytu strony

Opis przepływu działania aplikacji:

```text
Odczytaj parametr idp.

Jeżeli parametru nie ma lub jest pustym tekstem:
    ustaw alias glowna.

Jeżeli parametr nie jest tekstem lub ma błędny format:
    przygotuj odpowiedź HTTP 404.
W przeciwnym razie:
    spróbuj:
        wczytać konfigurację i utworzyć połączenie PDO;

        pobrać stronę przez prepare() i execute(),
            przekazując alias jako parametr,
            z warunkiem status = 1 i LIMIT 1;

        pobrać osobnym zapytaniem opublikowane strony do menu,
            uporządkowane według id;

        jeżeli strony nie znaleziono:
            przygotuj HTTP 404 i link powrotny;
        w przeciwnym razie:
            przygotuj tytuł i treść strony.

    w razie wyjątku połączenia lub któregokolwiek zapytania:
        zapisz szczegóły w lokalnym logu;
        przygotuj HTTP 500 i ogólny komunikat.

Przed wysłaniem HTML ustaw odpowiedni status HTTP.

Wyświetl wspólny szablon:
    tytuł i etykiety menu przez htmlspecialchars() z UTF-8;
    aktywny link z aria-current="page";
    treść jako własny, sprawdzony fragment HTML z bazy,
        bez wykonywania PHP.
```

## Testy — kroki i wyniki

Kody HTTP sprawdzałem w DevTools → Network.
Przy sprawdzaniu przekierowania włączyłem Preserve log.

| Próba i kroki | Oczekiwany wynik | Rzeczywisty wynik |
|---|---|---|
| Po skopiowaniu lab5 otworzyłem stronę główną, podstrony i panel CMS. | Strony działają, stopka zawiera v1.5, panel ma wymagany nagłówek i link powrotny. | Wszystkie wymienione elementy działały poprawnie. |
| Otworzyłem index.php i index.php?idp=. | Oba adresy otwierają glowna z HTTP 200. | Oba adresy otworzyły stronę główną z HTTP 200. |
| Zmieniłem treść istniejącej strony w phpMyAdmin i odświeżyłem przeglądarkę. | Zmiana jest widoczna bez edycji PHP i HTML. | Po odświeżeniu nowa treść była widoczna bez edycji plików PHP i HTML. |
| Dodałem opublikowany rekord o-sklepie i kliknąłem nowy link w menu. | Link i treść pojawiają się bez zmiany PHP, aktywny link jest oznaczony. | Link pojawił się, strona miała HTTP 200, treść była poprawna, a link wyróżniony. |
| Sprawdziłem szkic, następnie opublikowałem go przez zmianę statusu. | Status 0 ukrywa stronę w menu i daje 404; status 1 udostępnia stronę. | Szkic nie był widoczny w menu, a bezpośredni adres dawał 404. Po publikacji strona była dostępna i widoczna w menu. Po teście przywróciłem status 0. |
| Spróbowałem dodać rekord z identycznym aliasem. | Baza odrzuca duplikat. | Baza odrzuciła próbę dodania rekordu z identycznym aliasem. |
| Sprawdziłem ?idp=nieznana, ?idp[]=filmy oraz wartości ../cfg.php i ' OR 1=1-- przekazane jako idp. | HTTP 404 bez ostrzeżeń PHP. | Wszystkie próby dały HTTP 404 bez ostrzeżeń PHP. |
| Ustawiłem tymczasowo błędny port bazy w cfg.php. | HTTP 500 i ogólny komunikat; szczegóły tylko w lokalnym logu. | Strona zwróciła HTTP 500 bez szczegółów technicznych. Log zawierał SQLSTATE[HY000] [2002] Connection refused. Przywróciłem port 3306. |
| Sprawdziłem style, obrazy i animacje po migracji. | Działają jak przed migracją. | Style, obrazy i animacje działały poprawnie po migracji. |
| Kliknąłem „Sprawdź serwer” i uruchomiłem trzy filmy. | AJAX zwraca odpowiedź, wszystkie filmy działają. | AJAX i trzy filmy działały poprawnie. |
| Użyłem filtra i zapisałem wybór w katalogu PHP. | Filtr działa; zapis daje POST 303, następnie GET 200. | Filtr działał poprawnie. Zapis dał POST 303, następnie GET 200. |
| Po zapisaniu wyboru przeszedłem na stronę główną, „O sklepie” i wróciłem do katalogu. | Wybór pozostaje zapisany. | Wybór został zachowany. |
| Utworzyłem pustą bazę moja_strona_test, zaimportowałem sql/schema.sql i sql/seed.sql, nadałem użytkownikowi SELECT do jej page_list i przełączyłem nazwę bazy w cfg.php. | Strona działa na odtworzonej bazie, polskie znaki są poprawne. | Importy zakończyły się sukcesem, tabela zawierała 6 rekordów, strona działała poprawnie, a polskie znaki były wyświetlane prawidłowo. Po próbie przywróciłem w cfg.php bazę moja_strona. |