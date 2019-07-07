<?php
    // docker run --name camagru-db -p 3306:3306 -e MYSQL_ROOT_PASSWORD='root' -d mysql:5.7
    // docker exec -it camagru-db /bin/bash
    // mysql -u root -p
    // GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
    // docker-machine camagru
    // docker-machine ip camagru  ---> 192.168.99.100
    // 
    $DB_DNS = '0.0.0.0';
    $DB_PORT = '3306';
    $DB_USER = 'root';
    $DB_PASSWORD = 'Tlqkf42!';
    $DB_NAME = 'camagru';

?>
