FROM php:5.6-fpm

RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         && docker-php-ext-install zip
         
# Install application dependencies
RUN curl --silent --show-error --fail --location \
      --header "Accept: application/tar+gzip, application/x-gzip, application/octet-stream" -o - \
      "https://caddyserver.com/download/linux/amd64?plugins=http.expires,http.realip&license=personal" \
    | tar --no-same-owner -C /usr/bin/ -xz caddy \
    && chmod 0755 /usr/bin/caddy \
    && /usr/bin/caddy -version \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
    && docker-php-ext-install mbstring pdo pdo_mysql

# CMD ["/usr/bin/caddy", "--conf", "/etc/Caddyfile", "--log", "stdout"]