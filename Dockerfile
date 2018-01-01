# 第一阶段编译
FROM yuncms/php:7.1-build AS builder

ARG APP_ENV=Production

ENV GITHUB_API_TOKEN="eb517cd26e59740490c099850cbd74c951c7e030"

COPY . /app/

WORKDIR /app

RUN composer config -g github-oauth.github.com ${GITHUB_API_TOKEN} && \
    composer install --prefer-dist --optimize-autoloader -v && \
    php init --env=${APP_ENV} --overwrite=y

# 第二阶段打包程序
FROM yuncms/php:7.1-nginx

MAINTAINER XUTL <xutl@gmail.com>

COPY --from=builder /app /app/

WORKDIR /app

RUN rm -f /usr/local/etc/nginx/sites/default.conf \
	&& ln -s /app/nginx.conf /usr/local/etc/nginx/sites/nginx.conf \
	&& mkdir /storage \
	&& chown -R www-data:www-data /app

# Add configuration files
COPY docker-files/ /

VOLUME ["/app/storage"]
