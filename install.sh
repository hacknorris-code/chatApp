#!/bin/bash
read -p "enter database username: " user
mysql -u $user -p < db.sql
ln ../zd2/ /var/www
cat $user > conf.txt
read -p "enter database password: " password
cat $password > conf.txt
exit 0
