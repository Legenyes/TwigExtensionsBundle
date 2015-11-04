#!/bin/sh

export COMPOSER_NO_INTERACTION=1
composer self-update

if [ -n "${MIN_STABILITY:-}" ]; then
	sed -i -e "s/\"minimum-stability\": \"stable\"/\"minimum-stability\": \"${MIN_STABILITY}\"/" composer.json
fi

composer remove --no-update symfony/twig-bundle

if [ -n "${SYMFONY_VERSION:-}" ]; then
	composer require --no-update --dev symfony/symfony:${SYMFONY_VERSION}
fi

if [ -n "${TWIG_VERSION:-}" ]; then
	composer require --no-update --dev twig/twig:${TWIG_VERSION}
fi

if [ "${PHPUNIT_BRIDGE:-}" = true ]; then
	composer require --no-update --dev symfony/phpunit-bridge:"${SYMFONY_VERSION}"
fi

if [ "${USE_DEPS:-}" = "lowest" ]; then
	COMPOSER_UPDATE_ARGS="--prefer-lowest"
fi

composer update ${COMPOSER_UPDATE_ARGS:-}
