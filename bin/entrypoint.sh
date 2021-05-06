#!/bin/bash
set -e

php bin/console cache:warmup --env=$APP_ENV
php bin/console assets:install --env=$APP_ENV --symlink
chown -R www-data:www-data $(pwd)/var/cache && chown -R www-data:www-data $(pwd)/var/log

# Only do actions which require DB if DB host and port are given, then wait for the DB to be ready
if [ -n $DB_HOST ] && [ -n $DB_PORT ]; then
  ./bin/wait-for-it.sh --host=$DB_HOST --port=$DB_PORT --timeout=30

  #Update database tables or do a migration
  php bin/console doctrine:schema:update --force
  #php bin/console doctrine:migrations:migrate --force

  #Rest of the commands for startup go here
fi

exec "$@"