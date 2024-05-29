FROM php:8.2-fpm

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Create a new user and set permissions
RUN useradd -ms /bin/bash usuario \
    && chown -R usuario:usuario /var/www

# Switch to the new user
USER usuario

# Copy the application code
COPY --chown=usuario:usuario . /var/www

# Install PHP dependencies
RUN composer install

# Switch back to root to ensure the container can be managed properly
USER root