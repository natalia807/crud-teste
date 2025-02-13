# Use a imagem oficial do PHP com Apache
FROM php:7.4-apache

# Habilite o módulo mod_rewrite
RUN a2enmod rewrite

# Instale as extensões do PHP para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do seu projeto para o container
COPY . /var/www/html

# Exponha a porta 80
EXPOSE 80
