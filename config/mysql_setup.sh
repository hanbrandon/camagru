############################
# Used Docker to Use MySQL #
############################

docker-machine create --driver virtualbox camagru
docker-machine start camagru
docker-machine env camagru
eval $(docker-machine env camagru)
docker-machine ip camagru
docker run --name camagru-db -p 3306:3306 -e MYSQL_ROOT_PASSWORD='root' -d mysql:5.7
docker start camagru-db
docker exec -it camagru-db /bin/bash
# mysql -u root -p
# GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

