FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    cron \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    libmcrypt-dev \
    libonig-dev \
    zlib1g-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    graphviz \
    curl \
    supervisor

RUN apt-get update
RUN apt-get install -y libcurl4-openssl-dev
RUN apt-get install -y pkg-config
RUN apt-get install -y libssl-dev
RUN apt-get install -y libmagickwand-dev --no-install-recommends
RUN docker-php-ext-install -j$(nproc) iconv
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install imagick
RUN docker-php-ext-enable imagick
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pcntl
#RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN docker-php-ext-install intl

RUN docker-php-ext-install pdo_mysql pdo mysqli zip

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /var/www
RUN usermod -a -G www-data root

# Install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

#RUN apt-get install -y gnupg2
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN npm install pm2 -g
RUN cp /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
RUN apt-get install redis-tools -y

ENV MODES=$XDEBUG_MODES
ENV CLIENT_HOST=$REMOTE_HOST
ENV CLIENT_PORT=$REMOTE_PORT
ENV IDEKEY=$IDE_KEY

RUN touch /var/log/cron.log
COPY ./_docker/php/cron.txt /etc/cron.d/web
RUN chmod 0644 /etc/cron.d/web
RUN crontab /etc/cron.d/web


COPY ./_docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./_docker/queue/queue.example.yml /queue/queue.example.yml
COPY ./ /var/www/html/

CMD ["sh", "-c", "cron && php-fpm"]