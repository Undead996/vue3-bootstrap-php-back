FROM php:8.0.3-apache

ARG WORKDIR=/var/www/html/

ENV APACHE_DOCUMENT_ROOT $WORKDIR

RUN apt update && \
    apt install -y \
        git \
        libzip-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        mc && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) gd

WORKDIR $WORKDIR

COPY ./ ./

RUN a2enmod rewrite
RUN service apache2 restart

RUN composer update && \
    composer install && \
    mkdir -p tmpC && \ 
    chmod 777 tmpC && \
    chown www-data tmpC

RUN a2enmod rewrite
RUN service apache2 restart

RUN sed -ri -e 's!CipherString = DEFAULT@SECLEVEL=2!$CipherString = DEFAULT@SECLEVEL=1!g' /etc/ssl/openssl.cnf
#RUN composer install
    


