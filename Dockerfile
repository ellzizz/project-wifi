FROM php:8.2-cli

# Install dependensi dasar
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    sqlite3 \
    libsqlite3-dev \
    zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set workdir
WORKDIR /app

# Salin semua file ke dalam container
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Generate SQLite DB file
RUN mkdir -p /var/data && touch /var/data/database.sqlite

# Jalankan migration
RUN php artisan migrate --force || true

# Jalankan Laravel dev server
CMD php artisan serve --host=0.0.0.0 --port=10000
