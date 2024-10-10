#!/bin/bash

ln -sfn /var/www/pos/backend/web /var/www/pos/backend/web/og
chmod -R 0777 /var/www/pos/backend/web/og

cd /var/www/pos && composer self-update && composer install -o && composer dump-autoload

ln -s /var/www/pos/vendor/bin/codecept /usr/local/bin/ || echo 'codecept symlink already exist'
chmod +x /usr/local/bin/codecept

supervisord -n -c /etc/supervisor/supervisord.conf &

# start services
/usr/sbin/php-fpm${PHP_VERSION} --allow-to-run-as-root --fpm-config /etc/php/${PHP_VERSION}/fpm/php-fpm.conf --nodaemonize
