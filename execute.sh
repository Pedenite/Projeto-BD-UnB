#!/bin/sh

APP_PORT=8080  # insira a porta que vai rodar o container
LOCAL_PATH="/home/pedenite/Documents/php/Projeto-BD-UnB"    # insira o caminho do projeto git em sua maquina

docker build -t bd-proj .   # buildar a imagem do conteiner
docker run -d -p $APP_PORT:80 -v $LOCAL_PATH:/var/www/html bd-proj  # rodar o container
