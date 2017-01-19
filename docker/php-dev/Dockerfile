FROM php:7-fpm

RUN docker-php-ext-install \
    pdo_mysql
    
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
    
RUN apt-get update && \
    apt-get install libldap2-dev -y && \
    apt-get install libicu-dev -y && \
    apt-get install -y zlib1g-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap && \
    docker-php-ext-install intl && \
     docker-php-ext-install zip
     
COPY ./xdebug.ini /usr/local/etc/php/conf.d/