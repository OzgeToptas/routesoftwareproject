
FROM php:8.3-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG NODE_VERSION=20
ARG NPM_VERSION=@9.3.1
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd mysqli pdo pdo_mysql zip sockets
#gd g
RUN apt-get update && docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - && apt-get install -y nodejs && npm install -g npm
# Set working directory
WORKDIR /var/www

USER $user
