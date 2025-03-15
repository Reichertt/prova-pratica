# Usar imagem PHP oficial
FROM php:7.4-apache

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar o código da aplicação para o diretório do Apache
COPY ./prova /var/www/html/

# Definir permissões
RUN chown -R www-data:www-data /var/www/html/

# Expor a porta 80
EXPOSE 80
