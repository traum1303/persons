#### Clone the project code
```bash
git clone {{REPOSITORY}} .
``
#### Pull the Laradock code as submodule
```bash
git submodule add https://github.com/Laradock/laradock.git
git submodule update --init --recursive
```
#### Remove all the existing containers, images, volumes
```bash
sudo docker rm $(sudo docker stop $(sudo docker ps -a -q)) && sudo docker rmi $(sudo docker images -q) && sudo docker volume rm $(sudo docker volume ls -q)
# https://docs.docker.com/config/pruning/
docker system prune
```

### copy db & config files
```bash
cp -av ./laradock.config/. ./laradock
cp persons.local/.env.example persons.local/.env
```

#### Setup local hosts
```bash
sudo echo "127.0.0.1 persons.local www.persons.local" | sudo tee -a /etc/hosts
```

#### Build & run the containers in the detach mode
```bash

docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml up -d nginx workspace php-fpm postgres

docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml restart nginx
docker-compose --env-file laradock/.env -f laradock/docker-compose-dev.yml stop 

a2ensite persons.local.conf
service nginx reload
```

#### Login inside the 'workspace' container in order to install files
```bash
docker exec -it persons-workspace-1 bash
docker exec workspace bash -c "cd persons.local && composer install -n && php artisan migrate && php artisan db:seed && php artisan test"
docker exec workspace bash -c "cd persons.local && chmod 777 ./storage -R && chmod 777 ./bootstrap/cache -R"

docker exec workspace bash -c "cd persons.local && php artisan test"
```

#### How to stop containers
```bash
docker-compose -f laradock/docker-compose-dev.yml stop
```
