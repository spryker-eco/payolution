#!/usr/bin/env bash

RED='\033[1;31m'
GREEN='\033[1;32m'
buildResult=1
buildMessage=""
result=0

function runTests {
    grep APPLICATION_ROOT_DIR "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/composer/autoload_real.php"
    if [ "$?" = 0 ]; then
        echo "define('APPLICATION_ROOT_DIR', '$TRAVIS_BUILD_DIR/$SHOP_DIR');" >> "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/composer/autoload_real.php"
    fi
    "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/bin/console" transfer:generate
    if [ "$?" = 0 ]; then
        buildMessage="${buildMessage}\n${GREEN}Transfer objects generation was successful"
    else
        buildMessage="${buildMessage}\n${RED}Transfer objects generation was not successful"
        result=$((result+1))
    fi

    "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/bin/console" propel:install
    if [ "$?" = 0 ]; then
        buildMessage="${buildMessage}\n${GREEN}Propel models generation was successful"
    else
        buildMessage="${buildMessage}\n${RED}Propel models generation was not successful"
        result=$((result+1))
    fi

    ./setup_test -f

    echo "Running tests..."
    "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/bin/console" transfer:generate
    "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/bin/codecept" build -c "vendor/spryker-eco/$MODULE_NAME/"
    "$TRAVIS_BUILD_DIR/$SHOP_DIR/vendor/bin/codecept" run -c "vendor/spryker-eco/$MODULE_NAME/"
    if [ "$?" = 0 ]; then
        buildMessage="${buildMessage}\n${GREEN}Tests are passing"
    else
        buildMessage="${buildMessage}\n${RED}Tests are failing"
        result=$((result+1))
    fi
    cd "$TRAVIS_BUILD_DIR/$SHOP_DIR"
    echo "Tests finished"
    return $result
}

function checkArchRules {
    echo "Running Architecture sniffer..."
    errors=`vendor/bin/phpmd "vendor/spryker-eco/$MODULE_NAME/src" text vendor/spryker/architecture-sniffer/src/ruleset.xml --minimumpriority=2`
    errorsCount=`echo "$errors" | wc -l`

    if [[ "$errorsCount" = "0" ]]; then
        buildMessage="$buildMessage\n${GREEN}Architecture sniffer reports no errors"
    else
        echo -e "$errors"
        buildMessage="$buildMessage\n${RED}Architecture sniffer reports $errorsCount error(s)"
    fi
}

function checkWithLatestDemoShop {
    echo "Checking module with latest Demo Shop..."
    composer config repositories.ecomodule path "$TRAVIS_BUILD_DIR/$MODULE_DIR"
    composer require "spryker-eco/$MODULE_NAME @dev"
    result=$?
    if [ "$result" = 0 ]; then
        buildMessage="${buildMessage}\n${GREEN}$MODULE_NAME is compatible with the modules used in Demo Shop"
        if runTests; then
            buildResult=0
            checkModuleWithLatestVersionOfDemoShop
        fi
    else
        buildMessage="${buildMessage}\n${RED}$MODULE_NAME is not compatible with the modules used in Demo Shop"
        checkModuleWithLatestVersionOfDemoShop
    fi
}

function checkModuleWithLatestVersionOfDemoShop {
    echo "Merging composer.json dependencies..."
    updates=`php "$TRAVIS_BUILD_DIR/$MODULE_DIR/build/merge-composer.php" "$TRAVIS_BUILD_DIR/$MODULE_DIR/composer.json" composer.json "$TRAVIS_BUILD_DIR/$MODULE_DIR/composer.json"`
    if [ "$updates" = "" ]; then
        buildMessage="${buildMessage}\n${GREEN}$MODULE_NAME is compatible with the latest version of modules used in Demo Shop"
        return
    fi
    buildMessage="${buildMessage}\nUpdated dependencies in module to match Demo Shop\n$updates"
    echo "Installing module with updated dependencies..."
    composer require "spryker-eco/$MODULE_NAME @dev"
    result=$?
    if [ "$result" = 0 ]; then
        buildMessage="${buildMessage}\n${GREEN}$MODULE_NAME is compatible with the latest version of modules used in Demo Shop"
        runTests
    else
        buildMessage="${buildMessage}\n${RED}$MODULE_NAME is not compatible with the latest version of modules used in Demo Shop"
    fi
}

cd $SHOP_DIR
checkWithLatestDemoShop
if [ -d "vendor/spryker-eco/$MODULE_NAME/src" ]; then
    checkArchRules
fi
echo -e "$buildMessage"
exit $buildResult