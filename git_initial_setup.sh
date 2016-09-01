#!/bin/bash

# initial install of php packages with composer
echo "Beginning installation of required php packages via composer (cmd: 'composer install')"
composer install
echo "Finished installing required composer packages"
echo "Creating '.env' file from '.env.example'..."
cp .env.example .env
echo "File created: "
ls -ld .env
echo "Create torrent file storage directory 'storage/torrents'"
mkdir ./storage/torrents
echo "Directory successfully created"
ls -ld ./storage/torrents
echo "Generating application key (cmd: 'php artisan key:generate')"
php artisan key:generate
echo "Application key created"
echo "Initial set up completed. Thanks"
