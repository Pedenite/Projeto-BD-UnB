#!/bin/sh

docker stop projbd
docker rm projbd
docker image rm bd-proj
