FROM php:8.2-apache-bullseye

RUN apt-get update && apt-get install libzip-dev -y \
    && docker-php-ext-install zip
RUN docker-php-ext-configure bcmath && docker-php-ext-install bcmath \
    && docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y libpng-dev
RUN apt-get install -y libjpeg-dev
RUN docker-php-ext-configure gd --enable-gd --with-jpeg
RUN docker-php-ext-install gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
	<VirtualHost *:80>
		DocumentRoot /var/www/html/public
		<Directory /var/www/html/public>
			AllowOverride All
		</Directory>
	</VirtualHost>
EOF

RUN  cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled

COPY retace-install-checker.sh /usr/bin/retace-install-checker.sh
RUN chmod +x /usr/bin/retace-install-checker.sh

WORKDIR /var/www/html

ENV RETACE_HOME="/var/www/html"

ENTRYPOINT ["/usr/bin/retace-install-checker.sh"]

EXPOSE 80

CMD ["apache2-foreground"]
