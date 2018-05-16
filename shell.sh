#!/bin/bash
debconf-set-selections <<< "mysql-server mysql-server/root_password password minard"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password minard"
apt-get update
apt-get -y install mysql-server
/usr/sbin/mysqld &
ps ax
sleep 5
mysql -h 127.0.0.1 -u root -pminard < /var/www/html/mysql.sql
