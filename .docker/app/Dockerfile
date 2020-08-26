FROM php:7.3.11-apache

# enable rewrite mod
RUN a2enmod rewrite \
    && a2enmod headers \
    && a2enmod remoteip

COPY .docker/app/etc/10-xdebug.ini /usr/local/etc/php/conf.d/
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/10-expose_php.ini

# need gnupg for adding apt repo
RUN apt-get update \
    && apt-get install -y gnupg

# add nodesource
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

# install node js for theme
RUN apt-get update \
    && apt-get install -y nodejs \
    && npm install -g grunt

# install WK
RUN apt-get update \
    && apt-get install -y fontconfig libfreetype6 libjpeg62-turbo libpng16-16 libx11-6 libxcb1 libxext6 libxrender1 xfonts-75dpi xfonts-base \
    && curl -sLO https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.5/wkhtmltox_0.12.5-1.stretch_amd64.deb \
    && dpkg -i wkhtmltox_0.12.5-1.stretch_amd64.deb \
    && rm *.deb

# install tools
RUN apt-get update \
    && apt-get install -y nano mc

# deps for app
RUN docker-php-ext-install -j $(nproc) pdo_mysql
RUN docker-php-ext-install -j $(nproc) bcmath
RUN apt-get update \
    && apt-get install -y libpng-dev\
    && docker-php-ext-install -j $(nproc) gd
RUN apt-get update \
    && apt-get install -y zlib1g-dev libzip-dev \
    && docker-php-ext-install -j $(nproc) zip
RUN apt-get update \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install -j $(nproc) soap

ARG debug
# xdebug for dev
RUN  if [ $debug ]; then \
    pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug; \
fi

ARG XDEBUG_HOST
RUN echo xdebug.remote_host=$XDEBUG_HOST >> /usr/local/etc/php/conf.d/10-xdebug.ini

# improved auth with libsodium
RUN apt-get update \
    && apt-get install -y libsodium-dev \
    && pecl install libsodium-2.0.21 \
    && docker-php-ext-enable sodium

# configure apache as late as possible to avoid unnecessary cache invalidations
COPY .docker/app/apache-site.conf /etc/apache2/sites-enabled/00-default.conf

RUN ln -sf /usr/share/zoneinfo/Europe/London /etc/localtime \
    && echo "Europe/London" > /etc/timezone \
    && echo 'date.timezone=Europe/London' > /usr/local/etc/php/conf.d/settimezone.ini \
    && echo 'post_max_size = 15M' > /usr/local/etc/php/conf.d/filesize.ini \
    && echo 'upload_max_filesize = 15M' >> /usr/local/etc/php/conf.d/filesize.ini

# grab composer
RUN apt-get update \
    && apt-get install -y git zip unzip
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer global require hirak/prestissimo

WORKDIR /var/www

# install composer dependencies
COPY composer.json composer.lock ./
RUN if [ $debug ]; then \
	composer install --no-scripts; \
else \
	composer install --no-scripts --no-dev; \
fi

# build theme
COPY html ./html
COPY themes ./themes
#RUN cd themes/admin && npm install && grunt

# copy rest of fileset
COPY fuel ./fuel
COPY oil ./

# finish fuel install
RUN php oil r install

ARG version
# record version if available
RUN if [ $version ]; then \
    echo $version > VERSION; \
fi
