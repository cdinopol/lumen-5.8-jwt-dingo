# Base image
FROM php:7.4-apache

# Set main params
ENV APP_HOME /var/www/html

# Install all the dependencies and enable PHP modules
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
      procps \
      nano \
      git \
      unzip \
      libicu-dev \
      zlib1g-dev \
      libxml2 \
      libxml2-dev \
      libreadline-dev \
      supervisor \
      cron \
      libzip-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
      pdo_mysql \
      sockets \
      intl \
      opcache \
      zip \
    && rm -rf /tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# Disable default site and delete all default files inside APP_HOME
RUN a2dissite 000-default.conf
RUN rm -r $APP_HOME

# Create document root
RUN mkdir -p $APP_HOME/public

# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN chown -R www-data:www-data $APP_HOME

# Put apache and php config for Laravel, enable sites
COPY conf/docker/php.ini /usr/local/etc/php/php.ini
COPY conf/docker/laravel.conf /etc/apache2/sites-available/laravel.conf
RUN a2ensite laravel.conf

# Enable apache modules
RUN a2enmod rewrite
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf && a2enconf fqdn

# Install composer
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Set working directory
WORKDIR $APP_HOME

# Create composer folder for user www-data
RUN mkdir -p /var/www/.composer && chown -R www-data:www-data /var/www/.composer

# Switch user www-data
USER www-data

# Copy source files and config file
COPY --chown=www-data:www-data ./lumen $APP_HOME/
COPY --chown=www-data:www-data .env $APP_HOME/.env

# Install all PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress --no-dev

# Switch user root
USER root

# Run migration
RUN php artisan migrate
