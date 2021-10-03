# Persil

## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require web-id/persil --dev
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Publish fresh install compatible with Larastan

![Demo of fresh-install publish](https://github.com/web-id-fr/persil/raw/main/src/common/freshInstall.gif "Demo on fresh install")

```shell
php artisan vendor:publish --tag=fresh-install --force
```

## Publish Laravel stubs compatible with Larastan

List of stubs : [here](https://github.com/web-id-fr/persil/tree/main/src/Stubs/CustomLaravelStubs)

```shell
php artisan vendor:publish --tag=custom-laravel-stubs
```

## Make repository file

Empty repository ([template](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/repository.stub)):

```shell
php artisan make:repository UserRepository
```

Repository with *all, find, store, update, delete* methods ([template](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/repository.crud.stub))

```shell
php artisan make:repository UserRepository --crud
```

## Make service file

Create service file on app/Services ([template](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/service.stub))

```shell
php artisan make:service PaymentService
```
