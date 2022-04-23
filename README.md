# Persil

## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require web-id/persil --dev
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Publish Laravel stubs compatible with Larastan

List of stubs : [here](https://github.com/web-id-fr/persil/tree/main/src/Stubs/CustomLaravelStubs)

```shell
php artisan vendor:publish --tag=custom-laravel-stubs
```

## Make repository file

Empty repository

```shell
php artisan make:repository UserRepository
```

Repository with wanted methods

```shell
php artisan make:repository UserRepository --update --delete
```

Repository with *all, store, update, delete* methods

```shell
php artisan make:repository UserRepository --resource
```

List of available methods (options)
- [all](https://github.com/web-id-fr/persil/tree/main/src/Stubs/Makes/repositories/all.stub)
- [store](https://github.com/web-id-fr/persil/tree/main/src/Stubs/Makes/repositories/store.stub)
- [update](https://github.com/web-id-fr/persil/tree/main/src/Stubs/Makes/repositories/update.stub)
- [delete](https://github.com/web-id-fr/persil/tree/main/src/Stubs/Makes/repositories/delete.stub)

## Make service file

Create service file on app/Services ([template](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/services/service.stub))

```shell
php artisan make:service PaymentService
```

Create [service file](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/services/service.implemented.stub) with [testing service file](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/services/service.testing.stub), [interface](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/services/service.contract.stub) and [provider](https://github.com/web-id-fr/persil/blob/main/src/Stubs/Makes/services/service.provider.stub)

```shell
php artisan make:service PaymentService --provider
```
