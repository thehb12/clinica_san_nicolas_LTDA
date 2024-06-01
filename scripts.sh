#!/bin/bash
# -*- ENCODING: UTF-8 -*-
composer2 install
yarn encore production
php bin/console c:c
php bin/console d:s:u -f
#composer install --no-dev --optimize-autoloader
chmod 777 -R var/cache/prod/
chmod 777 -R config/jwt/
chmod 777 -R public/uploads/fotos/
chmod 777 -R public/uploads/default/
chmod 777 -R public/uploads/iconos/
chmod 777 -R var/cache/dev/

php bin/console cache:clear --env=prod