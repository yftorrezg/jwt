# Pasos para crear un proyecto en laravel

## Pasos ordenados

#### Paso 1 : ejecutar el siguiente comando

``` bash
composer create-project laravel/laravel laravel_jwt_example
```

#### Paso 2 : crear la base de datos en mysql

#### Paso 3 : cambiar el nombre de la base de datos en el archivo ".env" por el nombre de nuestra base de datos

#### Paso 4 : ejecutar el siguiente comando para migrar los datos

``` bash
php artisan migrate
php artisan migrate:fresh --seed
```

#### Paso 5 : ejecutar el siguiente comando para visualizar la pagina

``` bash
php artisan serve
```

#### Paso 6 : ejecutar el siguiente comando para instalar jwt

``` bash
composer require tymon/jwt-auth:dev-develop --prefer-source
composer require tymon/jwt-auth
```

#### Paso 7 : Luego en app.php en Providers copiar esto

``` php
Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
```

#### Paso 8 : Crear el archivo jwt.php

``` bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

#### Paso 9 : Generar la llave secreta:

``` bash
php artisan jwt:secret
```

#### Paso 10 : En models user.php copiar

``` php
use Tymon\JWTAuth\Contracts\JWTSubject;
```

implementar

``` php
class User extends Authenticatable implements JWTSubject
```

Despues de protected casts copiar estas funciones

``` php
public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [];
}
```

#### Paso 11 : Crear un controlador para la autenticacion 
  
  ``` bash
  php artisan make:controller AuthController
  ```

#### Paso 12 : Crear un Request para el Login :
  
  ``` bash
  php artisan make:request LoginRequest
  ```

#### Paso 13 : Para ver la lista de las rutas

``` bash
php artisan route:list
```

#### Paso 14 : Crear controlador para el User

``` bash
php artisan make:controller UserController --model=User --api
php artisan make:controller UserController 
```

#### Paso 15 : Crear Middleware

``` bash
php artisan make:middleware JwtMiddleware
```

Luego ir al kernel.php y copiar
  
  ``` php
  'jwt.verify' => JwtMiddleware::class
  ```

En api.php implementar

``` php
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
});
```

Creamos el modelo,el factory,las migrations,los seeders  y los controladores

``` bash
php artisan make:model Nombre_del_modelo -mcrfs
```
