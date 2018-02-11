FROM yuncms/php:7.1-nginx

LABEL maintainer="xutongle@gmail.com"

ENV APP_ENV=Staging \
	YII_DB_HOST=127.0.0.1 \
	YII_DB_NAME=yuncms_stage \
	YII_DB_USERNAME=yuncms \
	YII_DB_PASSWORD=123456

COPY . /app/

WORKDIR /app

RUN set -xe \
	&& composer install --prefer-dist --no-dev --optimize-autoloader --no-progress \
	&& chown -R www-data:www-data /app \
	&& chmod 700 /app/run.sh

VOLUME ["/storage"]

CMD ["/app/run.sh"]