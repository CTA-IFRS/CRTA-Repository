#!/usr/bin/env bash

echo "Preparing RETACE..."

sleep 20

if [ -d "vendor" ] && [ -f "vendor/autoload.php" ]; then
    echo "✓ Composer dependencies installed"
else
    /usr/bin/composer install
fi

if [ -f .env ]; then
    echo "✓ .env file exists"
    if grep -Eq '^APP_KEY=$' .env; then
        php artisan key:generate
    else
        echo "✓ APP_KEY already set"
    fi
else
    echo "✗ .env does not exists"
fi

sed -i 's/DB_HOST=.*/DB_HOST=db/' .env

if php artisan migrate:status >/dev/null 2>&1; then
    echo "✓ Database connection successful"
else
    php artisan migrate
fi

if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

STORAGE_PERM=$(stat -c '%a' storage)
STORAGE_G_OWNER=$(stat -c '%G' storage)

if [ ! "$STORAGE_G_OWNER" == "www-data" ]; then
    chown -R $(whoami):www-data storage
fi
if ! grep -Eq '^.?775$' <<<$STORAGE_PERM; then
    chmod -R 775 storage
fi

GREEN="\033[0;32m"
NCOLOR="\033[0m"
echo -e "${GREEN}Starting RETACE on localhost:8888${NCOLOR}"

exec "$@"
