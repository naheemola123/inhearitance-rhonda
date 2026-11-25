
# Build Tailwind CSS
FROM node:22-alpine AS assets

WORKDIR /app

COPY . .

RUN npm ci
RUN npm run build

# PHP application
FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Copy generated Tailwind CSS
COPY --from=assets /app/src/output.css ./src/output.css

ENV PORT=80

EXPOSE 80

CMD ["apache2-foreground"]
