
FROM phpdockerio/php72-fpm:latest
WORKDIR "/var/www"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install essentials tools for build
RUN apt-get update \
    && apt-get -y --no-install-recommends install -y build-essential curl software-properties-common

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.2 php7.2-cli php7.2-curl php7.2-dev php7.2-intl php7.2-json php7.2-mbstring php7.2-xml php7.2-mysql php7.2-mongodb php-pear php-redis php-xdebug composer \
    && apt-get update \
    && pecl install mongodb \
    && echo "extension=mongodb.so" >> /etc/php/7.2/apache2/php.ini \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Node.js and NPM
RUN apt-get update \
    && apt-get -y --no-install-recommends install nodejs npm \
    && apt-get clean;

# Install Git
RUN apt-get update \
    && apt-get -y --no-install-recommends install git tig \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*