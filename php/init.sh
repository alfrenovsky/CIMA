#!/bin/bash

cd /var/www/html/
tar xvfz /moodle/moodle-latest-311.tgz

until (cat < /dev/null > /dev/tcp/db/3306) 2> /dev/null
do
  echo "Waiting for mysql"
  sleep 1
done

cd moodle
php admin/cli/install.php \
   --agree-license \
   --non-interactive \
   --lang=es \
   --wwwroot=http://localhost/moodle \
   --dataroot=/var/www/moodledata \
   --dbtype=mariadb \
   --dbhost=db \
   --dbname=moodle_db \
   --dbpass=moodle_pass \
   --dbuser=moodle_user \
   --dbport=3306 \
   "--fullname=Moodle Site" \
   --shortname=MS \
   --adminuser=admin \
   --adminpass=pass \
   --adminemail=nobody@example.com

php-fpm
