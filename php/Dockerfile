FROM docker.io/library/php:8-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions

RUN install-php-extensions pdo_mysql
RUN install-php-extensions zip

RUN apt-get update \
      && apt-get -y install python3 python3-pip \
      && pip install mysql-connector-python \
      && pip install bs4
