# Use php:7.4-apache Image
FROM php:7.4-apache

# Settingup ENV variables
# ENV ETCDHOSTS="127.0.0.1:2379"
# ENV ETCDDIR="bi"
# ENV BI_DB_USER="bisys_user"
# ENV BI_DB_PASS="W2h6344ss458"
# ENV BI_DB_LOG="bi_opt_logs"
# ENV BI_DB_USER_LOG="log_user"
# ENV BI_DB_PASS_LOG="arrisportal"
# COPY ./db_conf_with_env/environment /etc/environment

WORKDIR  /var/www/html

# adding log dir
RUN mkdir -p /var/log/wibip
RUN mkdir -p /var/opt/scripts
# RUN touch /var/log/wibip/etcdscript.txt

# add web content to DocumentRoot
ADD ./ /var/www/html
# COPY ./Ex-Portal /var/www/html
# COPY ./campaign_portal /var/www/html
# COPY ./tenant /var/www/html

# copy vhost file
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# copy php.ini configuration
COPY ./php.ini-production /usr/local/etc/php/php.ini

# copy the multi CMD file
# COPY ./run_multi_cmd.sh /var/opt/scripts/run_multi_cmd.sh
# COPY ./etcd_config.php /var/opt/scripts/etcd_config.php
# COPY ./test.php /var/opt/scripts/test.php

RUN apt-get update && \
    apt-get -yq install \
        vim \
        javascript-common \
        mariadb-server && \
    docker-php-ext-install \
        pdo_mysql \
        sockets \
        gettext \
        opcache \
        mysqli \
        calendar \
        exif \
        pcntl \
        shmop \
        sysvmsg \
        sysvsem \
        sysvshm  && \
    chown -R root:staff /usr/local/etc/php/php.ini* && \
    chown -R root:www-data /var/www && \
    chown -R root:www-data /var/log/wibip && \
    chown -R root:www-data /var/opt/scripts && \
    chmod 755 -R /var/www/html/ && \
#    chmod 755 /var/opt/scripts/run_multi_cmd.sh && \
#    chmod 755 /var/opt/scripts/etcd_config.php && \
#    chmod 755 /var/opt/scripts/test.php && \
    a2enmod rewrite headers

# Remove conf and ini from doc root
RUN rm -rf /var/www/html/000-default.conf /var/www/html/php.ini-production /var/www/html/Dockerfile /var/www/html/.dockerignore

# expose port 80
EXPOSE 80
EXPOSE 443

# Start Apache
# CMD ./wrapper_script.sh
# ENTRYPOINT ["/bin/sh","-c","/var/www/html/docker_sql_exec.sh"]
CMD ["/usr/sbin/apache2ctl","-D","FOREGROUND"]
# CMD [ "php", "-f", "./var/www/html/campaign_portal/config/etcd_config.php", "$ETCDHOSTS", "$ETCDDIR" ]
