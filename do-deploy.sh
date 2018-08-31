#!/bin/bash

cd ..
rm -rf crifi/var/cache/*
#rsync -a --delete --exclude var/sqlite.db -e "ssh -p 443"  crifi root@gea.noip.me:/var/www/html
rsync -a --delete -e "ssh -p 443"  crifi root@gea.noip.me:/var/www/html
ssh -p 443 root@gea.noip.me "chown -R www-data:www-data /var/www/html/crifi"
