#!/usr/bin/env bash

HOSTNAMES=(
    advanced-embed.vanilla.localhost
    database
    dev.vanilla.localhost
    embed.vanilla.localhost
    vanilla.localhost
    memcached
    sso.vanilla.localhost
    vanilla.test
);

if [[ $UID != 0 ]]; then
    echo "Please run this script with sudo:";
    echo "sudo $0 $*";
    exit 1;
fi

DOCKER_CHECK=$(command -v docker);
if [ ! -n "$DOCKER_CHECK" ]; then
    echo "The docker command was not found. Make sure you installed Docker.";
    exit 1;
fi

CERTIFICATE_PATH1="./resources/certificates/wildcard.vanilla.localhost.crt";
if [ ! -f "$CERTIFICATE_PATH1" ]; then
    echo "Missing $CERTIFICATE_PATH1 certificate. Was it renamed or something?";
    exit 1;
fi

CERTIFICATE_PATH2="./resources/certificates/vanilla.localhost.crt";
if [ ! -f "$CERTIFICATE_PATH2" ]; then
    echo "Missing $CERTIFICATE_PATH2 certificate. Was it renamed or something?";
    exit 1;
fi

CERTIFICATE_LOCATION="/usr/local/share/ca-certificates"

CERTIFICATE_EXIST1="${CERTIFICATE_LOCATION}/wildcard.vanilla.localhost.crt"
if [ ! -f "$CERTIFICATE_EXIST1" ]; then
    cp $CERTIFICATE_PATH1 $CERTIFICATE_LOCATION
fi

CERTIFICATE_EXIST2="${CERTIFICATE_LOCATION}/wildcard.vanilla.localhost.crt"
if [ ! -f "$CERTIFICATE_EXIST2" ]; then
    cp $CERTIFICATE_PATH2 $CERTIFICATE_LOCATION
fi

update-ca-certificates

ip addr add 192.0.2.1 dev lo

# Allows us to use database as the hostname to connect to the database.
for HOSTNAME in ${HOSTNAMES[@]}; do
    HOST_ENTRY=$(grep ^"$HOSTNAME" /etc/hosts);
    if [ ! -n "$HOST_ENTRY" ]; then
        echo '127.0.0.1 '"$HOSTNAME" \# Added from vanilla-docker/mac-setup.sh >> /etc/hosts
    fi
done

# https://docs.docker.com/engine/tutorials/dockervolumes/#mount-a-host-file-as-a-data-volume#creating-and-mounting-a-data-volume-container
DATA_STORAGE_CHECK=$(docker volume ls -q | grep datastorage);
if [ ! -n "$DATA_STORAGE_CHECK" ]; then
    docker volume create --name=datastorage --label="Persistent_data_storage" > /dev/null
fi
