## instal apache

```bash
sudo apt-get update
sudo apt-get install apache2 libapache2-mod-php -y
```

## install mysql

```bash
sudo apt-get install mysql-server php-mysql -y
```

## buat database

```bash
mysql -uroot -p
```

```mysql
create database game;
create user 'aristore'@'localhost' IDENTIFIED with mysql_native_password by '4r1st0r3';
grant all privileges on *.* to 'aristore'@'localhost' ;
flush privileges;
exit
```

## install php

```bash
sudo apt-get install php libapache2-mod-php php-common php-mbstring php-xmlrpc php-soap php-gd php-xml php-mysql php-cli php-zip -y
sudo apt-get install php-curl -y
```

## Mcrypt php

```bash
sudo apt-get install php-dev libmcrypt-dev gcc make autoconf libc-dev pkg-config -y
sudo pecl install mcrypt-1.0.1
```

###### Ubah versi php sesuai php yg dipakai

```bash
echo "extension=mcrypt.so" | sudo tee -a /etc/php/7.4/apache2/conf.d/mcrypt.ini
sudo service apache2 restart
```

## install composer dan laravel

```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

## install ssl

```bash
sudo nano /etc/apache2/sites-available/aristore.conf
```

```conf
<VirtualHost *:80>

    DocumentRoot /var/www/html/ari_store/public
    ServerName mangari.store
    ServerAlias mangari.store

    <Directory /var/www/html/ari_store/public>
        Options FollowSymlinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

## SSL

```bash
sudo apt install software-properties-common -y
sudo apt-add-repository -r ppa:certbot/certbot
sudo apt update -y
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache
sudo certbot renew --dry-run
```

## Configurasi multi site

```bash
sudo a2dissite 000-default.conf
sudo a2ensite aristore.conf
sudo a2enmod rewrite
sudo service apache2 restart
```

## Install app

```shell
cd /var/www/html
sudo apt install git
git clone https://github.com/arisawali2014/ari_store.git
cd ari_store
composer update
composer install
cp .env.example .env
nano .env
```

```env
APP_URL=https://localhost

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game
DB_USERNAME=aristore # username database
DB_PASSWORD=4r1st0r3 # password database

QUEUE_CONNECTION=database


# LOGIN SOCIAL
FB_ID=fb_id_client
FB_SECRET=fb_client_secret

GOOGLE_ID=google_id_client
GOOGLE_SECRET=google_client_secret
```

## Finishing

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:refresh --seed
sudo chown -R www-data:www-data /var/www/html/ari_store/vendor
sudo chown -R www-data:www-data /var/www/html/ari_store/storage
chmod -R 775 /var/www/html/ari_store
chmod -R 777 /var/www/html/ari_store/public
crontab -e
```

##### CRON

```cron
* * * * * cd /var/www/html/ari_store && php artisan schedule:run >> /dev/null 2>&1
```
