# Workerman Runtime [WIP] [EXPERIMENTAL]

[![CD/CI](https://github.com/OpenDaje/workerman-runtime/actions/workflows/cd-ci.yaml/badge.svg)](https://github.com/OpenDaje/workerman-runtime/actions/workflows/cd-ci.yaml)

⚠ Launching early stage releases (0.x.x) could break the API according to [Semantic Versioning 2.0](https://semver.org/). We are using *minor* for breaking changes.
This will change with the release of the stable `1.0.0` version.


Runtime component for [workerman/workerman](https://github.com/walkor/workerman)

## Install

Add 'repository' directive in your composer.json

````json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/OpenDaje/workerman-runtime.git"
        }
    ],
````

install the package

````shell
composer require opendaje/workerman-runtime:@dev
````

install the workerman package

````shell
composer require workerman/workerman
````

enable symfony/runtime in composer.json

````json
    "config": {
        "allow-plugins": {
            "symfony/runtime": true
        }
    }
````
