
docker build -t iit/symfony_installer ./docker/symfony_installer/

docker run --rm -v %cd%:/workdir iit/symfony_installer symfony new src

docker-compose up -d