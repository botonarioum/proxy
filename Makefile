install-composer:
		wget -O composer-setup.sig https://composer.github.io/installer.sig
		wget -O composer-setup.php https://getcomposer.org/installer
		awk '{print $$0 "  composer-setup.php"}' composer-setup.sig | sha384sum --check
		php composer-setup.php --quiet
		rm composer-setup.*
		mv composer.phar /usr/local/bin/composer

init:
		php bin/console doctrine:database:create
		php bin/console doctrine:mi:mi
		php bin/console doctrine:fixtures:load

analyse:
		vendor/bin/phpstan analyse -l 7 src/

exec-app:
		docker-compose exec app bash

run-tests:
		vendor/bin/phpunit tests/*

logs:
		tail -f var/log/dev.log

serve:
		php -S 0.0.0.0:8585 -t public/