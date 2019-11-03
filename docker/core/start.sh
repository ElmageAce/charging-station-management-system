#!/usr/bin/env bash

chown www-data /var/www/bootstrap/cache
chown -R www-data /var/www/storage
chmod -R uog+rw /var/www/bootstrap/cache
chmod -R uog+rw /var/www/storage

service inetutils-syslogd restart

service nginx stop
service nginx start

php-fpm&

tail -f /var/log/messages
