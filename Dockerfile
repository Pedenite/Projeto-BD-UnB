FROM php:5.6-apache
RUN docker-php-ext-install mysqli
COPY . /var/www/html
EXPOSE 80

# docker run -d -p [hostport]:80 -v [path]/Projeto-BD-UnB:/var/www/html bd-proj