Dependency Injection Container (DIC)
===
Simple container for services. Inject services into your container and use anywhere you want.

Requirements
===
- PHP >= 7.0

Basic usage
===

Registering services:
```
    $container = new \Vagif\Container;
    $container->bind(SomeService::class, function () {
        return new SomeService();   
    });
```

Note: Additionaly you can use **Container** instance within the container.

```
    $container = new \Vagif\Container;
    $container->bind(SomeService::class, function (Container $container) {
        $dependency = $container->resolve(Config::class); // passing Config to the service
        return new SomeService($dependency);   
    });
```

Getting service out of container:
``` 
    $container = new \Vagif\Container;
    $service = $container->resolve(StripeAPI::class);
```

Contributions
===
You're welcome to submit patches and new features.

- Please, create a new branch for your feature
- Add tests so it doesn't break any existing code
- Open a new pull request

License
===
The MIT License (MIT)

Vagif Rufullazada, vaqifrzade@gmail.com