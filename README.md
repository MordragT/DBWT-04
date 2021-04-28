## DBWT

- diese Webseite wurde als Teil des Moduls Datenbanken und Webtechnologien entwickelt

### Installation

- Abhängigkeiten: php, mariadb

```
php artisan key:generate
# mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
# mysql -u root -p
MariaDB> CREATE USER 'monty'@'localhost' IDENTIFIED BY 'some_pass';
MariaDB> GRANT ALL PRIVILEGES ON dbwt_1.* TO 'monty'@'localhost';
MariaDB> FLUSH PRIVILEGES;
MariaDB> quit
```

- ich empfehle die migration des `Script.sql` mithilfe von DBeaver
- die Bilder unter `/public/img` müssen händisch in die Bilder Tabelle eingetragen werden
- es muss außerdem noch die eigenen `.env` Datei der eigenen Konfiguration entsprechend angepasst werden

### Starten

```
php artisan serve
```

### Präsentation

[![E-Mensa - Präsentation](https://res.cloudinary.com/marcomontalbano/image/upload/v1619630205/video_to_markdown/images/youtube--L9WE2DQoYbc-c05b58ac6eb4c4700831b2b3070cd403.jpg)](https://youtu.be/L9WE2DQoYbc "E-Mensa - Präsentation")