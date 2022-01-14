web: vendor/bin/heroku-php-apache2 public/
sqs: php artisan queue:work --timeout=1800
scheduler: php -d memory_limit=512M artisan schedule:cron