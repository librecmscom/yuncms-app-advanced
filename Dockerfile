FROM xutongle/php:7.1-fpm

MAINTAINER XUTL <xutl@gmail.com>

#ENV GITHUB_API_TOKEN="2c041926c6f2e09e21467add2dacca39990b63e4"

ARG GITHUB_API_TOKEN

COPY . /app/
WORKDIR /app

RUN rm -rf /etc/nginx/conf.d/default.conf \
    && composer config -g github-oauth.github.com ${GITHUB_API_TOKEN} \
    && composer install --prefer-dist --optimize-autoloader -vvv \
    && chmod 700 docker-files/run.sh init

VOLUME ["/app/uploads"]

EXPOSE 80

CMD ["docker-files/run.sh"]