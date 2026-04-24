# Web aplikacija za strimovanje i reprodukciju muzike

Ova web aplikacija predstavlja full-stack rešenje za strimovanje i reprodukciju muzike. Projekat je fokusiran na dinamičku interakciju sa korisnikom, efikasno upravljanje bazom podataka i asinhronu obradu podataka bez osvežavanja stranice.

## 🚀 Ključne Funkcionalnosti

* **Audio Player:** Potpuno funkcionalan plejer sa kontrolama za reprodukciju, pauziranje i navigaciju kroz pesme.
* **AJAX Tracking:** Implementiran sistem za automatsko brojanje pregleda (view count). Svaki put kada se pesma pusti, AJAX poziv ažurira broj slušanja u bazi podataka u realnom vremenu.
* **Upravljanje Sadržajem:** Pretraga pesama, filtriranje po žanrovima i organizacija muzike kroz bazu podataka.
* **Korisničke Liste:** Logika za kreiranje i prikaz plejlisti prilagođenih korisniku.
* **Dinamički UI:** Interfejs koji se menja na osnovu podataka iz baze, koristeći PHP za renderovanje sadržaja.

## 🛠️ Tehnološki Stack

* **Backend:** Native PHP (logika aplikacije, sesije, komunikacija sa bazom).
* **Baza Podataka:** MySQL (relaciono modelovanje tabela za pesme, autore, žanrove i korisnike).
* **Frontend:** HTML5, CSS3, JavaScript.
* **Asinhrona Komunikacija:** AJAX (za ažuriranje pregleda i dinamičko učitavanje podataka).
* **Server:** Apache (XAMPP/WAMP okruženje).
---
*Ovaj projekat služi kao demonstracija rada sa native PHP tehnologijom i asinhronim procesima u web okruženju.*
