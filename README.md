# Huisdieren Project

Dit is een opdracht om een kleine webapplicatie te maken voor het beheren van huisdieren. Ik heb gebruik gemaakt van Laravel, Composer en JavaScript.

Er is een index pagina met een overzicht van alle huisdieren, met pagination en mogelijkheid huisdieren te verwijderen, en een overzicht met hoeveel huisdieren er van ieder type zijn.
Er is ook een pagina om een nieuw huisdier toe te voegen.

## Benodigdheden

- PHP >= 8.2
- Composer
- Laravel 11

## Installatievereisten

### PHP installeren

Zorg ervoor dat PHP >= 8.2 geïnstalleerd is. Voor installatie-instructies, zie de [officiële PHP website](https://www.php.net/manual/en/install.php).

### Composer installeren

**Download en installeer Composer van de [officiële Composer website](https://getcomposer.org/download/).**

### Laravel installeren

***Installeer Laravel 11 via Composer:**
```bash
composer global require laravel/installer
```

**Clone de repository:**
```bash
git clone https://github.com/WouterSmaardijk/huisdieren.git
```

**Installeer Composer dependencies**
```bash
cd huisdieren
```

**Kopieer het voorbeeld .env.example bestand en hernoem dit naar .env**
```bash
cp .env.example .env
```

**Stel de database in:**
    - Maak een database genaamd `huisdieren`.
    - Werk het `.env` bestand bij met je databasegegevens:
        
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=huidieren
        DB_USERNAME=root
        DB_PASSWORD=root
        ```
        
**Voer de database migraties uit en seed de database:**
```bash
php artisan migrate --seed
```

**Start de applicatie:**
```bash
php artisan serve
```
