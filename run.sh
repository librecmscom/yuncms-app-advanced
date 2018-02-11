#!/bin/bash

php init --env=${APP_ENV:-Production} --overwrite=y

php yii migrate/up --interactive=0

echo -e "\033[32mStarting php and nginx......\033[0m"

rm -f /run/supervisord.pid

supervisord -n -c /etc/supervisord.conf
