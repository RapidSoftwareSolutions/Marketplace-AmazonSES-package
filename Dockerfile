FROM alpine:3.4

ENV LANG="en_US.UTF-8" \
    LC_ALL="en_US.UTF-8" \
    LANGUAGE="en_US.UTF-8" \
    TERM="xterm"

COPY /conf/run.sh /usr/local/bin/run.sh

# Bundle app source 
COPY . .

RUN echo "http://dl-4.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories


RUN apk update && \
    apk add nginx bash ca-certificates s6 curl ssmtp php7 php7-phar php7-curl \
    php7-fpm php7-json php7-zlib php7-xml php7-dom php7-ctype php7-opcache php7-zip php7-iconv \
    php7-pdo php7-pdo_mysql php7-pdo_sqlite php7-pdo_pgsql php7-mbstring php7-session \
    php7-gd php7-mcrypt php7-openssl php7-sockets php7-posix php7-ldap php7-timezonedb && \
    && rm -rf /var/cache/apk/* \
    && ln -s /usr/bin/php7 /usr/bin/php \
    && ln -s /usr/sbin/php-fpm7 /usr/bin/php-fpm \
    && chmod a+x /usr/local/bin/run.sh
    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN ln -s /root/.composer/vendor/bin/phpunit /usr/local/bin/phpunit

# Install app dependencies
RUN composer install --no-interaction

COPY /conf/php.ini /etc/php7/conf.d/50-setting.ini
COPY /conf/www.conf /etc/php7/php-fpm.d/www.conf
COPY /conf/nginx.conf /etc/nginx/nginx.conf

EXPOSE 8080

CMD ["/usr/local/bin/run.sh"]
