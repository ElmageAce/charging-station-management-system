#!/bin/bash

cd laradock

docker-compose up -d nginx mariadb phpmyadmin redis workspace elasticsearch

cd ..
