#!/bin/bash

function clear_docker {
  (
    set -e
    sudo docker container kill $(docker ps -q)
  )
  sudo docker system prune -a --volumes -f
}
function check_docker {
  if [ ! -x "$(command -v docker)" ]; then
    sudo apt-get update
    sudo apt-get -y install docker.io curl
    sudo curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
    sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
  fi
}

function setup_server {
    
    check_docker

    if [ ! -f "${PWD}/.env" ]; then
        MYSQL_ROOT_PASSWORD="pwd"$(date | md5sum | rev | cut -c5- | rev)
        MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD$(date | md5sum | rev | cut -c5- | rev)
        echo "MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD" > ${PWD}/.env
    fi 

    sudo docker-compose up --build -d
}

function reload_server {
    sudo docker-compose exec nginx bash -c "service nginx reload && service nginx restart"
}

if [[ "$1" != "" ]]; then 
    $1 
else
    mode_opt=("Setup Server" "Reload Server" "Docker Prune" "Wipe Data" "Exit")
    PS3='Please enter your choice: '
    select mode in "${mode_opt[@]}"
    do
        if [ "$REPLY" == "1" ]; then
            setup_server
        elif [ "$REPLY" == "2" ]; then
            reload_server
        elif [ "$REPLY" == "3" ]; then
            clear_docker
        elif [ "$REPLY" == "3" ]; then
            rm -rf ${PWD}/data/mysql
        fi
        exit
    done
fi

