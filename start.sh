#!/bin/bash
myPath=`pwd`

echo "Stopping Conainer if run"
docker ps -a | grep myApp | awk -F" " '{print "docker stop "$1 }' | sh
echo "Deleting previus docker"
docker ps -a | grep myApp | awk -F" " '{print "docker rm "$1 }' | sh
echo "create new container"
docker run --name myApp -p 80:80 -v $myPath:/var/www/html  -itd nimmis/apache-php5  /usr/sbin/apache2ctl -D FOREGROUND
docker ps -a | grep myApp | awk -F" " '{print "docker exec "$1 " chmod +x /var/www/html/shell.sh"}' | sh
docker ps -a | grep myApp | awk -F" " '{print "docker exec "$1 " /var/www/html/shell.sh"}' | sh


