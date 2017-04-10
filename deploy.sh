#!/usr/bin/env bash

git reset --hard
git pull
chmod u+x deploy.sh
cd src
composer install
npm install
webpack
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load --append