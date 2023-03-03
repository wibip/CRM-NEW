# Use php:7.4-apache Image
FROM php:7.4-apache


WORKDIR  /var/www/html

# adding log dir
RUN mkdir -p /var/log/wibipcrmnew
RUN mkdir -p /var/opt/scripts


# add web content to DocumentRoot
ADD ./ /var/www/html


# copy vhost file
#COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# copy php.ini configuration
#COPY ./php.ini-production /usr/local/etc/php/php.ini



RUN apt-get update \ 
    && apt-get -yq install \
        vim \
        javascript-common \
        default-mysql-client \
    && docker-php-ext-install \
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
        sysvshm \
    && chown -R root:root /usr/local/etc/php/php.ini* \
    && chown -R root:root /var/www \
    && chown -R root:root /var/log/wibipcrmnew \
    && chown -R root:root /var/opt/scripts \
    && chmod 755 -R /var/www/html/ \
    && a2enmod rewrite headers

# copy db_config file
RUN cp -f /var/www/html/db_config.php /var/www/html/crm/db/

# Remove conf and ini from doc root
RUN rm -rf /var/www/html/000-default.conf /var/www/html/php.ini-production /var/www/html/Dockerfile /var/www/html/.dockerignore /var/www/html/db_config.php

# Setting ENV variables
ENV DB_SERVER = 10.1.6.60
ENV DB_SERVER_USERNAME = crm
ENV DB_SERVER_PASSWORD = Arrisportal@1
ENV DB_DATABASE = crm_portal_cicd


# expose port 80
EXPOSE 80
EXPOSE 443

# Start Apache
CMD ["/usr/sbin/apache2ctl","-D","FOREGROUND"]