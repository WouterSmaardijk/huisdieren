# Huisdieren Project

Dit is een opdracht om een kleine webapplicatie te maken voor het beheren van huisdieren. Ik heb gebruik gemaakt van Laravel, Composer en JavaScript. De styling is gedaan met Bulma.

Er is een index pagina met een overzicht van alle huisdieren, met paginering en mogelijkheid huisdieren te verwijderen, en een overzicht met hoeveel huisdieren er van ieder type zijn.
Verder is er een pagina om een nieuw huisdier toe te voegen.

## Benodigdheden

- PHP >= 8.2
- Composer
- Database Server

## Installatievereisten

### PHP installeren

Zorg ervoor dat PHP geïnstalleerd is. Voor installatie-instructies, zie de [officiële PHP website](https://www.php.net/manual/en/install.php).

### Composer installeren

**Download en installeer Composer van de [officiële Composer website](https://getcomposer.org/download/).**

**Clone de repository:**
```bash
git clone https://github.com/WouterSmaardijk/huisdieren.git
```

**Installeer Composer dependencies**
```bash
cd huisdieren
composer install
```

**Kopieer het voorbeeld .env.example bestand en hernoem dit naar .env**
```bash
cp .env.example .env
```

**Stel de database in:**
- Werk het `.env` bestand bij met je databasegegevens
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=huidieren
DB_USERNAME=root
DB_PASSWORD=root
```      

**Maak eventueel een database aan met de naam `huisdieren` als dit bij de migratie niet automatisch gedaan wordt**

**Voer de database migraties uit en seed de database**
```bash
php artisan migrate --seed
```  

**Genereer een application key:**
```bash
php artisan key:generate
```

**Start de applicatie:**
```bash
php artisan serve
```
