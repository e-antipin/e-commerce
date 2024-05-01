FROM php:8.3-fpm

# Surpresses debconf complaints of trying to install apt packages interactively
# https://github.com/moby/moby/issues/4032#issuecomment-192327844

ARG DEBIAN_FRONTEND=noninteractive

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


# Install useful tools and install important libaries
RUN apt-get -y update && \
    apt-get -y --no-install-recommends install \
    nano \
    wget \
    dialog \
    git \
    curl \
    libsqlite3-dev \
    zip \
    unzip \
    libssl-dev \
    libsqlite3-0 && \
    apt-get -y --no-install-recommends install \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing \
    build-essential \
    libonig-dev && \
    apt-get -y --no-install-recommends install --fix-missing \
    libcurl4 \
    libcurl4-openssl-dev \
    libmcrypt-dev \
    openssl && \
    apt-get -y --no-install-recommends install --fix-missing \
    imagemagick \
    libfreetype6-dev \
    libmagickwand-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libpng-dev && \
    rm -rf /var/lib/apt/lists/*


# Install xdebug
RUN pecl install xdebug-3.3.1 && \
    docker-php-ext-enable xdebug

# Install redis
RUN pecl install redis-5.3.4 && \
    docker-php-ext-enable redis

# Other PHP8 Extensions

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install opcache && \
    docker-php-ext-install bcmath && \
    docker-php-ext-configure zip && docker-php-ext-install zip && \
    docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl && \
   cd ~ && git clone https://github.com/longxinH/xhprof.git && cd ./xhprof/extension/ && \
    phpize && ./configure --with-php-config=/usr/local/bin/php-config && make && make install && cd ~ && rm -rf ./xhprof && \
    cd /var/www && docker-php-ext-enable xhprof && \
    docker-php-ext-enable xhprof && \
    cd ~ && git clone https://github.com/Imagick/imagick && cd imagick && phpize && ./configure &&\
    make && make install && cd ~ && rm -rf ./imagick && cd /var/www/html && \
    docker-php-ext-enable imagick
    
RUN apt-get update && apt-get install -y librabbitmq-dev \
    && pecl install amqp
#    && install-php-extensions amqp
#    && docker-php-ext-install amqp

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

    
RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

ARG uid
ARG gid
ARG uname

RUN groupadd --gid $gid $uname
RUN useradd -G www-data,root -s /bin/bash --uid $uid --gid $gid $uname --home-dir /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chown $uid:$gid /usr/local/bin/composer 

RUN mkdir -p /var/www/.composer
RUN mkdir -p /var/www/.composer/cache
RUN chown -R $uid:$gid /var/www
RUN chown -R $uid:$gid /var/www/.composer

RUN mkdir /tmp/xhprof \
    && chown $uid:$gid /tmp/xhprof



#RUN mkdir -p /opt
#RUN cd /opt
#RUN wget -P /opt https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
#RUN tar vxf /opt/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -C /opt
#RUN cp /opt/wkhtmltox/bin/wk* /usr/local/bin/
#RUN rm /opt/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz

ENV PHP_EXTRA_CONFIGURE_ARGS --enable-fpm --with-fpm-user=$uid --with-fpm-group=$gid

WORKDIR /var/www/html

CMD ["php-fpm"]

# Cleanup
RUN rm -rf /usr/src/*

USER $uname
