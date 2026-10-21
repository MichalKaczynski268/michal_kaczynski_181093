# Sprawozdanie z testów — VolleyShop (Lab 1)

* **Przeglądarka:** Brave 1.97.59 (arm64), Chromium: 155.0.8059.85
* **System:** macOS

---

## 1. Sprawdzenie kodu HTML (Nu HTML Checker i czytelność)
* **Co robiłem:** Wrzuciłem kod wszystkich trzech podstron (`index.html`, `produkt.html`, `kontakt.html`) do walidatora W3C Nu HTML Checker, a potem wyłączyłem w narzędziach styl CSS, żeby zobaczyć samą treść.
* **Co miało wyjść:** Zero błędów w walidatorze oraz czytelna strona od góry do dołu nawet bez żadnych kolorów i stylów.
* **Co faktycznie wyszło:** Walidator pokazał zielone światło (brak błędów). Po wyłączeniu CSS tekst i nagłówki czytają się logicznie jak normalny dokument.
* **Poprawki:** Nic nie trzeba było poprawiać.

---

## 2. Test responsywności (telefon 375 px vs komputer 1280 px)
* **Co robiłem:** Włączyłem tryb responsywny w DevTools i sprawdziłem stronę najpierw na małym ekranie (375 px), a potem rozszerzyłem powyżej 768 px i dobiłem do 1280 px.
* **Co miało wyjść:** 
  * Przy 375 px: produkty ułożone jeden pod drugim (1 kolumna), brak bocznego suwaka (poziomego scrolla).
  * Od 768 px w górę: produkty same przeskakują w 3 kolumny obok siebie.
* **Co faktycznie wyszło:** Dokładnie tak zadziałało. Na telefonie mamy jedną kolumnę, zdjęcia ładnie się zmniejszają i nic nie wystaje za ekran. Po przekroczeniu 768 px odpala się media query i wskakują 3 kolumny.
* **Poprawki:** Brak.

---

## 3. Test klawiatury i klikania w etykiety
* **Co robiłem:** Zostawiłem myszkę i klikałem po stronie samym klawiszem Tab (oraz Shift+Tab), a linki otwierałem Enterem. W formularzu klikałem myszką w same napisy obok pól.
* **Co miało wyjść:** Wyraźna ramka fokusu wokół zaznaczonych linków i pól, logiczna kolejność skakania Tabem, a kliknięcie w tekst etykiety miało od razu wrzucać kursor do danego pola.
* **Co faktycznie wyszło:** Tab przeskakuje po kolei po menu, kartach i formularzu. Obrys focus-visible jest dobrze widoczny. Kliknięcie w etykietę aktywuje właściwe pole formularza.
* **Poprawki:** Brak.

---

## 4. Test formularza i blokad walidacji (`kontakt.html`)
* **Co robiłem:** Próbowałem oszukać formularz na różne sposoby:
  1. Wysłać pusty formularz.
  2. Wpisać zły e-mail (bez małpy `@`).
  3. Wpisać ilość sztuk jako `0` oraz `6` (limit to 1–5).
  4. Wpisać za krótką wiadomość (mniej niż 10 znaków).
  5. Wpisać wszystko poprawnie i kliknąć przycisk.
* **Co miało wyjść:** Przy błędnych danych przeglądarka miała zablokować wysłanie i pokazać dymek z błędem. Przy dobrych danych miała przeładować stronę i dokleić wartości do linku (GET).
* **Co faktycznie wyszło:** Wszystkie ograniczenia zadziałały — przeglądarka nie puściła żadnego błędu. Po wpisaniu poprawnych danych strona się przeładowała, a w pasku adresu pojawiły się 4 parametry: email, produkt, ilosc i wiadomosc.
* **Poprawki:** Brak.

---

## 5. Eksperyment z atrybutem `name` w polu e-mail
* **Co robiłem:** Zgodnie z instrukcją skasowałem atrybut `name="email"` w polu e-maila (zostawiłem samo `id="email"` i `<label>`), po czym wysłałem poprawny formularz.
* **Co miało wyjść (przewidywanie):** Wpisany adres e-mail nie pojawi się w linku po wysłaniu strony.
* **Co faktycznie wyszło:** Formularz się wysłał, ale w pasku adresu były tylko parametry: `produkt`, `ilosc` i `wiadomosc`. E-mail całkowicie zniknął.
* **Wniosek:** Atrybut `id` służy tylko do wyglądu na stronie i połączenia z etykietą `label`. Żeby dane z pola w ogóle wysłały się dalej w adresie URL, pole obowiązkowo musi mieć atrybut `name`.
* **Poprawka:** Dodałem z powrotem `name="email"` do kodu.