# laravel 9

este proyecto va ser del 
<https://www.youtube.com/watch?v=p7tGYsVQV48&t=2085s>
Neither Ruiz dominicano.

## lista de comandos

- creamos el proyecto

``` bash
composer create-project --prefer-dist laravel/laravel laravel_jwt_example
composer create-project laravel/laravel laravel_jwt_example
```

- creamos nuestra base de datos en mysql
- cambiamos el nombre de la base de datos en el archivo ".env" por el nombre 
de nuestra base de datos

- Comando para migrar datos:

``` bash
php artisan migrate
php artisan migrate:fresh --seed
```

## visualizar la pagina

``` bash
php artisan serve
```

<!--  php artisan migrate -->

## migrate
  
  ``` bash
  php artisan migrate
  php artisan migrate: refresh  
  php artisan migrate:fresh
  php artisan migrate:fresh --seed

  ```
<!-- composer require tymon/jwt-auth:dev-develop --prefer-source -->

## jwt

``` bash
composer require tymon/jwt-auth
composer require tymon/jwt-auth:dev-develop --prefer-source
```

## codigo de youtube

<!-- link -->
<https://www.youtube.com/watch?v=kP2N_eEv-iA>

``` php
- app/Providers/AppServiceProvider.php 

use Illuminate\Support\Facades\Schema;

.
. 
public function boot()
    {
        Schema::defaultStringLength(191);
    }

```

 ```php artisan migrate```
 ```composer require tymon/jwt-auth```

config/app.php

``` php
'providers' => [

    ...

    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
```

``` bash
 php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
 php artisan vendor:publish 
 // generar clave secrete en .env se ve
 php artisan jwt:secret
```

config/auth.php

```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

...

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

app/Models/User.php

```php
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject


<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Rest omitted for brevity Despues de protected casts copiar estas funciones :
    //  😎 😎 ESTO DE AQUI ABAJO 😎 😎 


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
```

routes/api.php

```php
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

//o bien tmbn 😀😀😀😀😀
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});
```

```bash
php artisan make:controller Auth/AuthController
php artisan make:controller AuthController
```

app/Http/Controllers/AuthController.php

```php

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

// 😀😀😀😀😀
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    // 😀😀😀😀😀 register
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
// 😀😀😀😀😀 login: email, password
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
// 😀😀😀😀😀 register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => '¡Usuario registrado exitosamente!',
            'user' => $user
        ], 201);
    }
}
```
