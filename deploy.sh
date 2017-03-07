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