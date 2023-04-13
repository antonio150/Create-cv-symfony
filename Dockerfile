# FROM debian:9
# RUN apt-get update -yq \
# && apt-get upgrade -yq \
# && apt-get install curl gnupg -yq \

FROM php:8.0.5-fpm-alpine

#Install Apk
RUN apk --no-cache update && apk --no-cache add bash git

# Install pdo
RUN docker-php-ext-install pdo_mysql

#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
   && php composer-setup.php \
   && php -r "unlink('composer-setup.php');" \
   && mv composer.phar /usr/local/bin/composer
 
# Install Symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash \
   && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony


COPY . /var/www/html
 
WORKDIR /var/www/html