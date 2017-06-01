#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

cd ~/Code/rfid-door-system-web/

php artisan key:generate
php artisan migrate
php artisan passport:install

npm run dev
