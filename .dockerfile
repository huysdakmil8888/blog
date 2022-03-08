FROM richarvey/nginx-php-fpm:1.6.1

RUN apk add --no-cache --virtual .build-deps \
    g++ make autoconf

RUN pecl install mongodb-1.8.0 && \
	docker-php-ext-enable mongodb

RUN rm /var/www/html/index.php && \
	rm /etc/nginx/sites-available/default-ssl.conf && \
	rm /start.sh

COPY start.sh /start.sh
COPY nginx/default.template /etc/nginx/sites-available/default.template
COPY .env /var/www/html/.env
COPY public /var/www/html/public
COPY app /var/www/html/app
COPY bootstrap /var/www/html/bootstrap
COPY config /var/www/html/config
COPY database /var/www/html/database
COPY resources /var/www/html/resources
COPY routes /var/www/html/routes
COPY storage /var/www/html/storage
COPY tests /var/www/html/tests
COPY artisan /var/www/html/artisan
COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock
COPY package.json /var/www/html/package.json
COPY phpunit.xml /var/www/html/phpunit.xml
COPY server.php /var/www/html/server.php
COPY webpack.mix.js /var/www/html/webpack.mix.js

WORKDIR /var/www/html

RUN composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-reqs && php artisan storage:link
RUN composer dump-autoload

RUN chown -Rf nginx:nginx /var/www/html && \
	chmod +x /start.sh

RUN touch /var/log/cron.log
RUN chmod 0777 /var/log/cron.log
RUN chmod 755 /start.sh

CMD /start.sh