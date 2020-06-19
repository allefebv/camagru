#!/bin/bash

DEBIAN_FRONTEND=noninteractive apt-get install -y -q msmtp
DEBIAN_FRONTEND=noninteractive apt-get install -y -q msmtp-mta

php-fpm