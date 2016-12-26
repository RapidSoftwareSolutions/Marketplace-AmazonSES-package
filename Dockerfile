FROM alpine:edge

ENV LANG="en_US.UTF-8" \
    LC_ALL="en_US.UTF-8" \
    LANGUAGE="en_US.UTF-8" \
    TERM="xterm"

COPY /conf/run.sh /usr/local/bin/run.sh

# Bundle app source 
COPY . .

RUN echo "http://dl-4.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories && \
    apk --update add \
        curl \
        git \
        nginx \
        php7.1 \
        php7.1-curl \
        php7.1-xml \
        php7.1-zip \
        php7.1-gd \
        php7.1-mbstring \
    && rm -rf /var/cache/apk/* \
    && ln -s /usr/bin/php7 /usr/bin/php \
    && ln -s /usr/sbin/php-fpm7 /usr/bin/php-fpm \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && ln -s /root/.composer/vendor/bin/phpunit /usr/local/bin/phpunit \
    && chmod a+x /usr/local/bin/run.sh

# Install app dependencies
RUN composer install --no-interaction

COPY /conf/php.ini /etc/php7/conf.d/50-setting.ini
COPY /conf/www.conf /etc/php7/php-fpm.d/www.conf
COPY /conf/nginx.conf /etc/nginx/nginx.conf

EXPOSE 8080

CMD ["/usr/local/bin/run.sh"]
