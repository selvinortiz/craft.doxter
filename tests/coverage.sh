#!/usr/bin/env bash

php -c /etc/php5/apache2/php.ini ./phpunit.phar --coverage-html ./report
