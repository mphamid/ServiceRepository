# Service Repository Pattern

This package is designed to implement the service structure on Laravel projects.

## Installation

    composer require vandarpay/service-repository

## Requirement

- Laravel 9.*

## Generator Commands

    php artisan make:dto
    php artisan make:service-exception {service-name}
    php artisan make:service-exception-language {service-name} --language=fa
    php artisan make:service-repository {service-name} --grpc
    php artisan make:service-transformer {service-name}
    php artisan make:service {service-name} --grpc --language=fa --transformer

## Service Structure

Each service contains 5 files that are located in a folder with the same name as the service in the **services** folder,
listed below

1. **Exception**: To collect the service exception with the following specific structure

exception class must be extends from **ServiceException** class and each class contains several errors that contain a
constant variable and the definition of this variable. In defining the parameters, the exception error code, the
machine-readable code and the error message must be defined please attention to below example

```php
class TestException extends ServiceException
{
    public const NEW_ERROR = 'new_error';

    public function configureExceptions()
    {
        $this->addException(self::NEW_ERROR, Response::HTTP_BAD_REQUEST, 'this is a test exception');
    }
}
```

2. **Exception Language**: This file is the translation of the exceptions in the service, which sends the text related
   to the exception error to the user according to the language specified in the request of the error handling section.
3. **Repository**: Service interface for implement service repository structure
4. **Transformer**:  It is the class between service methods and other microservices, which can be provided in different
   versions and include calling several methods from several service.
5. **Service**: A class that extends from the repository and all the logic of the service is placed in this class

## Register Services

There are two ways to connect the repository to the services, which you can do in the `service providers`.

```php
$this->app->bind(UserRepository::class, UserService::class);
```

or

```php
$this->app->singleton(UserRepository::class, UserService::class);
```

### The difference between bind and singleton

The difference between these two methods is that they persist in memory. If you use the singleton method, your instance
of the service class will persist in memory and one instance will be used for all requests. Therefore, use Singleton for
high-visit services and make sure that this feature does not interfere with the performance of your service.

## Handel Service Exception

Please put the following code sample in the `report` method of the exception handler file (`app/Exceptions/Handler.php`)
To integrate and standardize the outputs issued from the service.

```php
    if ($e instanceof ServiceException && ($request->wantsJson() || $request->is('api/*'))) {
        return response()->json(['code' => $e->getAppCode(), 'message' => $e->getMessage()], $e->getCode());
    }
```
