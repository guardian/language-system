FROM php:8.2.21-apache

RUN apt-get -y update
RUN apt-get -y install apt-utils
RUN apt-get -y install git
RUN apt-get -y install ffmpeg
RUN apt-get -y install sudo
RUN apt-get -y install python3-pip
RUN apt-get -y install pipx
RUN apt-get -y install espeak
RUN apt-get -y install fonts-takao
RUN apt-get -y install fonts-arphic-ukai fonts-arphic-uming fonts-ipafont-mincho fonts-ipafont-gothic fonts-unfonts-core
RUN apt-get -y install fonts-indic
RUN apt-get -y install fonts-thai-tlwg
RUN apt-get -y install fonts-nafees
RUN apt-get -y install libpng-dev
RUN apt-get -y install python3-full
RUN python3 -m venv /opt/venv
RUN /opt/venv/bin/pip install git+https://github.com/agermanidis/autosub.git
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN apt-get install zip unzip
RUN sudo -H -u www-data bash -c 'php composer.phar require stichoza/google-translate-php'
RUN sudo -H -u www-data bash -c 'php composer.phar require moxiecode/plupload'
RUN sudo -H -u www-data bash -c 'php composer.phar require aws/aws-sdk-php'
RUN docker-php-ext-install mysqli gd
COPY src/* /var/www/html/
COPY src/images/* /var/www/html/images/
COPY src/jobs/* /var/www/html/jobs/
COPY setup/php.ini /usr/local/etc/php
RUN mkdir working
RUN mkdir subtitles
RUN mkdir renders
RUN mkdir uploads
RUN mkdir thumbnails
RUN mkdir json
RUN mkdir text
RUN chmod 0777 *
RUN cd /opt && git clone https://github.com/beotiger/justwave.git
