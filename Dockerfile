FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \ 
    git \ 
    curl \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev 

#устанавливаем PHP-расширения
RUN docker-php-ext-install pdo_mysql mbstring xml curl zip

#настройка праув доступа
RUN chown -R www-data:www-data /var/www/html

#запуск PHP-FPM
CMD ["php-fpm"]