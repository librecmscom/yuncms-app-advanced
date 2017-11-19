FROM xutongle/php:7.1-fpm

MAINTAINER XUTL <xutl@gmail.com>

COPY . /app/
WORKDIR /app

RUN rm -rf /etc/nginx/conf.d/default.conf \
    && composer install --prefer-dist --optimize-autoloader -vvv \
    && chmod 700 docker-files/run.sh init

VOLUME ["/app/uploads"]

EXPOSE 80

CMD ["docker-files/run.sh"]