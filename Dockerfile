FROM php:5.6-apache

RUN apt-get -y update
RUN apt-get -y install apt-utils
RUN apt-get -y install git
RUN apt-get -y install ffmpeg
RUN apt-get -y install sudo
RUN apt-get -y install python-pip
RUN apt-get -y install espeak
RUN apt-get -y install fonts-takao
RUN apt-get -y install fonts-arphic-ukai fonts-arphic-uming fonts-ipafont-mincho fonts-ipafont-gothic fonts-unfonts-core
RUN apt-get -y install fonts-indic
RUN apt-get -y install fonts-thai-tlwg
RUN apt-get -y install fonts-nafees
RUN apt-get -y install libpng-dev
RUN pip install autosub
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN sudo -H -u www-data bash -c 'php composer.phar require stichoza/google-translate-php'
RUN sudo -H -u www-data bash -c 'php composer.phar require moxiecode/plupload'
RUN sudo -H -u www-data bash -c 'php composer.phar require aws/aws-sdk-php'
RUN docker-php-ext-install mysqli gd
COPY src/* /var/www/html/
COPY src/images/* /var/www/html/images/
COPY src/jobs/* /var/www/html/jobs/
COPY setup/php.ini /usr/local/etc/php
COPY fix/TranslateClient.php /var/www/html/vendor/stichoza/google-translate-php/src/Stichoza/GoogleTranslate
RUN mkdir working
RUN mkdir subtitles
RUN mkdir renders
RUN mkdir uploads
RUN mkdir thumbnails
RUN mkdir json
RUN mkdir text
RUN chmod 0777 *
RUN cd /opt && git clone https://github.com/beotiger/justwave.git
