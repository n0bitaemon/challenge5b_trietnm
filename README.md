Khi update lên 000webhost cần có:
    "require": {
        ...
        "symfony/console": "6.0.*",
        "symfony/error-handler": "6.0.*",
        "symfony/finder": "6.0.*",
        "symfony/http-foundation": "6.0.*",
        "symfony/http-kernel": "6.0.*",
        "symfony/mailer": "6.0.*",
        "symfony/mime": "6.0.*",
        "symfony/process": "6.0.*",
        "symfony/routing": "6.0.*",
        "symfony/var-dumper": "6.0.*",
        "symfony/event-dispatcher": "6.0.*",
        "symfony/string": "6.0.*",
        "symfony/translation": "6.0.*",
        "symfony/translation-contracts": "3.0.*",
        "symfony/service-contracts": "3.0.*",
        "symfony/event-dispatcher-contracts": "3.0.*",
        "symfony/deprecation-contracts": "3.0.*",
        ...
    }
trong file composer.json, rồi chạy lệnh 
    composer install --ignore-platform-req=php
    composer update --ignore-platform-req

thay giá trị của APP_DEBUG=false trong.env
