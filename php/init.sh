#!/bin/bash

cd /var/www/html/

until (cat < /dev/null > /dev/tcp/db/3306) 2> /dev/null
do
  echo "Waiting for mysql"
  sleep 1
done

php-fpm
