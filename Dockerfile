FROM php:5.6-apache

RUN apt-get -y update && apt-get -y install ffmpeg
COPY src/* /var/www/html
COPY setup/php.ini /usr/local/etc/php
