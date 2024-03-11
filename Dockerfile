ARG ALPINE_VERSION=3.17
FROM alpine:${ALPINE_VERSION}

ENV PHP_DIR=/usr/bin
ENV PHP_BIN=$PHP_DIR/php
ENV PHP8_BIN=$PHP_DIR/php82

# make sure you can use HTTPS
RUN apk --update-cache add ca-certificates
# Add application (--chown=nobody)
COPY / /var/www
WORKDIR /var/www

# Install packages and remove default server definition
RUN apk -U upgrade && apk add --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/community/ \
  busybox-suid \
  curl \
  nginx \
  php82 \
  php82-curl \
  php82-dom \
  php82-fpm \
  php82-mbstring \
  php82-pdo_pgsql \
  php82-pdo_sqlite \
  php82-openssl \
  php82-phar \
  php82-session \
  php82-xml \
  php82-xmlreader \
  php82-xmlwriter \
  php82-simplexml \
  php82-zip \
  php82-tokenizer \
  php82-sodium \
  php82-fileinfo \
  libpq-dev \
  libzip-dev \
  unzip \
  supervisor \
  && ln -s $PHP8_BIN $PHP_BIN \
  && rm -rf /var/cache/apk/* /tmp/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --2

# Configure nginx - http
COPY stack/nginx.conf /etc/nginx/nginx.conf
# Configure nginx - default server
COPY stack/conf.d /etc/nginx/conf.d/

# Configure PHP-FPM
COPY stack/fpm-pool.conf /etc/php82/php-fpm.d/root.conf
COPY stack/php.ini /etc/php82/conf.d/custom.ini

# Conf crontab
#COPY stack/cron.d /etc/cron.d/
#RUN chmod 0644 /etc/cron.d/*

# Configure supervisord
COPY stack/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Make sure files/folders needed by the processes are accessable when they run under the nobody user (chown -R nobody.nobody)
RUN chown -R root.root /var/www /run /var/lib/nginx /var/log/nginx

# Switch to use a non-root user from here on
#USER nobody

#RUN echo '* * * * *    cd /var/www/ && php artisan schedule:run >> /dev/stdout 2>&1' > /var/spool/cron/crontabs/nobody
#RUN echo '* * * * *    cd /var/www/ && php artisan schedule:run >> /dev/stdout 2>&1' > /etc/crontabs/nobody

# (--chown=nobody)
COPY /stack/cron.d /var/spool/cron/crontabs/root
COPY /stack/cron.d /etc/crontabs/root

# Expose the port nginx is reachable on
EXPOSE 2070

#RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader

RUN composer install --no-progress --no-interaction --optimize-autoloader

# Let supervisord start nginx & php-fpm
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Run entrypoint
RUN chmod +x /var/www/entrypoint.sh
ENTRYPOINT ["/var/www/entrypoint.sh"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:2070/fpm-ping
