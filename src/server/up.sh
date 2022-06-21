#!/bin/sh
# up.sh

set -e

while true
do
    if php yii queue/listen-all
    then
        break
    fi

    sleep 1
done

php-fpm
