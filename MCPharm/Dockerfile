FROM php:8.3-cli

LABEL Name=mcpharm Version=0.0.1

RUN apt-get -y update && apt-get install -y \
git \
&& apt-get clean

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
