# Laravel UAC API Package for any protected FC Zenit API Service Application

Пакет предоставляет разработчику `middleware` под названием `auth.token_introspection`, которым разработчик может закрыть все маршруты, где требуется проверка запросов API.
Проверка запросов API происходит на OAuth сервере ФК Зенит.

## Состав

Пакет содержит единственный middleware - TokenIntrospection.

## Использование

С помощью предоставленного middleware можно закрыть один роут:

```php
Route::get('/test')->middleware('auth.token_introspection');
```

Можно закрыть группу роутов:
```php
Route::group(['middleware' => ['auth.token_introspection']], function() {
    Route::get('/test1');
    Route::get('/test2');
});
```

А можно вообще добавить этот мидлварь в группу `web`, тогда весь сайт будет закрыт от неавторизованного доступа. 

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Codewiser\UAC\Laravel\TokenIntrospection:class,
    ],
];
```

Пакет наследует `codewiser/uac-laravel`, а он в свою очередь `codewiser/uac` поэтому разработчикам доступны все способы получения `access_token`, и предоставляется удобный интерфейс доступа к api-ресурсам.
