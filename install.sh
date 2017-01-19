#!/usr/bin/env bash

docker build -t iit/symfony_installer ./docker/symfony_installer/

docker run --rm -v $(pwd):/workdir iit/symfony_installer symfony new src

sudo chown -R $(whoami):$(whoami) src
chmod -R 777 src/var

docker-compose up -d