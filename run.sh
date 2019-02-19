#!/bin/bash

cd laradock

# Create valid .env file for laradock
cp -rf .env.docker .env

# Run containers
docker-compose up -d nginx mariadb phpmyadmin redis workspace elasticsearch

cd ..
