FROM ubuntu:focal

ARG PHP_SELECTED_VERSION

RUN locale-gen en_US.UTF-8 ru_RU.UTF-8 2> /dev/null \
    || ( \
        apt-get clean && apt-get update && apt-get install -y locales \
        && locale-gen en_US.UTF-8 ru_RU.UTF-8 \
        )

ENV DEBIAN_FRONTEND=noninteractive \
    LC_ALL=en_US.UTF-8 \
    LANG=en_US.UTF-8 \
    APT_INSTALL_OPTIONS="-y -q0 --no-install-recommends" \
    PHP_VERSION=${PHP_SELECTED_VERSION} \
    COMPOSER_GITHUB_TOKEN=${COMPOSER_GITHUB_TOKEN} \
    PHP_COMPOSER_VERSION=1.7.2 \
    RABBITMQ_CLI_CONSUMER_VERSION=1.4.2

#
## Fix bug common packages
###
RUN sed -i -e s/deb.debian.org/archive.debian.org/g /etc/apt/sources.list &&  \
    sed -i -e s/security.debian.org/archive.debian.org/g /etc/apt/sources.list &&  \
    sed -i -e '/stretch-updates/d' /etc/apt/sources.list

RUN apt-get update && apt-get install ${APT_INSTALL_OPTIONS} \
    build-essential \
    software-properties-common \
    apt-transport-https \
    less \
    bc \
    iputils-ping \
    iproute2 \
    vim \
    iftop \
    curl \
    blktrace \
    ncdu \
    lsof \
    tcpdump \
    sysstat \
    wget \
    telnet \
    mailutils \
    arping \
    mtr-tiny \
    htop \
    dnsutils \
    tmux \
    pv \
    binutils \
    supervisor \
    openssl \
    ca-certificates \
    libengine-gost-openssl1.1 \
    openssh-client \
    graphviz \
    git \
    php-yaml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set timezone
RUN ln -sf /usr/share/zoneinfo/Europe/Moscow /etc/localtime

# Configure OpenSSL GOST Algorithms
RUN  echo "Configure OpenSSL GOST Algorithms" \
    && sed -i '1 i openssl_conf = openssl_def' /etc/ssl/openssl.cnf \
    && echo "" >> /etc/ssl/openssl.cnf \
    && echo "openssl_conf = openssl_def" >> /etc/ssl/openssl.cnf \
    && echo "" >> /etc/ssl/openssl.cnf \
    && echo "[openssl_def]" >> /etc/ssl/openssl.cnf \
    && echo "engines = engine_section" >> /etc/ssl/openssl.cnf \
    && echo "" >> /etc/ssl/openssl.cnf \
    && echo "[engine_section]" >> /etc/ssl/openssl.cnf \
    && echo "gost = gost_section" >> /etc/ssl/openssl.cnf \
    && echo "" >> /etc/ssl/openssl.cnf \
    && echo "[gost_section]" >> /etc/ssl/openssl.cnf \
    && echo "engine_id = gost" >> /etc/ssl/openssl.cnf \
    && echo "default_algorithms = ALL" >> /etc/ssl/openssl.cnf \
    && echo "CRYPT_PARAMS = id-Gost28147-89-CryptoPro-A-ParamSet" >> /etc/ssl/openssl.cnf \
    && { echo -n "dynamic_path = " ; find / -name gost.so; } | cat >> /etc/ssl/openssl.cnf \
    && echo "" >> /etc/ssl/openssl.cnf

# Install Test CA Certificate
RUN echo "install ca-certificate esia-portal1.test.gosuslugi.ru" \
    && openssl s_client esia-portal1.test.gosuslugi.ru:443 | sed -r -e '1,/\-\-\-\-\-BEGIN CERTIFICATE\-\-\-\-\-/ d' -e '/\-\-\-\-\-END CERTIFICATE\-\-\-\-\-/,$ d' > /usr/local/share/ca-certificates/esia-portal1.test.gosuslugi.ru.crt \
    && sed -i -e '1 s/^/\-\-\-\-\-BEGIN CERTIFICATE\-\-\-\-\-\n/;' -e '$a -----END CERTIFICATE-----' /usr/local/share/ca-certificates/esia-portal1.test.gosuslugi.ru.crt \
    && dpkg-reconfigure ca-certificates && update-ca-certificates --fresh

# PHP related packages
RUN add-apt-repository ppa:ondrej/php && apt-get update && apt-get install ${APT_INSTALL_OPTIONS} \
    php${PHP_VERSION}-dev \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-imagick \
    php${PHP_VERSION}-apcu \
    php${PHP_VERSION}-amqp \
    php${PHP_VERSION}-xdebug \
    php${PHP_VERSION}-yaml \
    jpegoptim \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# XHPROF
RUN mkdir -p /var/www/xhprof \
    && cd /var/www/xhprof \
    && git clone https://github.com/longxinH/xhprof.git . \
    && cd extension \
    && phpize \
    && ./configure --with-php-config=/usr/bin/php-config7.4 \
    && make \
    && make install \
    && printf "extension=xhprof.so\nxhprof.output_dir=/var/www/xhprof/www" > /etc/php/7.4/mods-available/xhprof.ini \
    && ln -s /etc/php/7.4/mods-available/xhprof.ini /etc/php/7.4/cli/conf.d/20-xhprof.ini \
    && ln -s /etc/php/7.4/mods-available/xhprof.ini /etc/php/7.4/fpm/conf.d/20-xhprof.ini \
    && apt-get update && apt-get install graphviz

# PHP
RUN sed -i "s/www-data/root/g" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i "s/;pm.status_path/pm.status_path/g" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i "s/;listen.mode = 0660/;listen.mode = 0770/g" /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
	&& sed -i "s/DAEMON_ARGS=\"--daemonize/DAEMON_ARGS=\"--daemonize --allow-to-run-as-root/" /etc/init.d/php${PHP_VERSION}-fpm \
    && sed -i "s/memory_limit = 128M/memory_limit = -1/g" /etc/php/${PHP_VERSION}/cli/php.ini \
    && sed -i "s/memory_limit = 128M/memory_limit = 256M/g" /etc/php/${PHP_VERSION}/fpm/php.ini \
    && sed -i "s/; max_input_vars = 1000/max_input_vars = 1500/g" /etc/php/${PHP_VERSION}/fpm/php.ini \
    && sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 20M/g" /etc/php/${PHP_VERSION}/fpm/php.ini \
    && sed -i "s/post_max_size = 8M/post_max_size = 20M/g" /etc/php/${PHP_VERSION}/fpm/php.ini

# Set default php
RUN update-alternatives --set php /usr/bin/php${PHP_VERSION}


# Download Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& php -r "unlink('composer-setup.php');"

RUN sed -i "s/;date.timezone =/date.timezone = Europe\/Moscow/g" /etc/php/${PHP_VERSION}/cli/php.ini \
    && sed -i "s/;date.timezone =/date.timezone = Europe\/Moscow/g" /etc/php/${PHP_VERSION}/fpm/php.ini

COPY ./docker/php/root /
RUN chmod +x /docker-entrypoint.sh && mkdir -p /var/www && mkdir -p /run/php

RUN mkdir -p /root/.composer/
COPY ./docker/php/auth.json /root/.composer/auth.json

WORKDIR /var/www/pos

ENTRYPOINT ["/docker-entrypoint.sh"]
