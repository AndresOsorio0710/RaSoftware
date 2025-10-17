# RaSoftware
## Comans
- ### Create project
```
composer create-project laravel/laravel RaSoftware
```
- ### Requires
    - Laravel Sanctum

        _Intale_
        ```
        composer require laravel/sanctum
        ```
        
        _Configure_
        ```
        php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
        ```
- ### Models
    _Role_
    ```
    php artisan make:model Role -m
    ```

    _Role User_
    ```
    php artisan make:migration create_role_user_table --create=role_user
    ```


- ### Migrate

    _Apply pending migrations_
    ```
    php artisan migrate
    ```

    _Aplicar migraciones desde cero_
    ```
    php artisan migrate:fresh
    ```

- ### Requests

    ```
    php artisan make:request RegisterUserRequest
    ```

- ### Directories

    ```
    mkdir -p app/Application/Commands
    mkdir -p app/Core
    ```

- ### Commands

    ```
    php artisan make:class Application/Commands/User/RegisterUser/RegisterUserCommand
    ```

- ### Queries

     ```
    php artisan make:class Application/Queries/User/GetAllUsers/GetAllUsersQuery
    ```

- ### Handlers

    ```
    php artisan make:class Application/Handlers/User/RegisterUser/RegisterUserHandler
    php artisan make:class Application/Handlers/User/GetAllUsers/GetAllUsersHandler
    php artisan make:class Application/Handlers/User/GetUsers/GetUsersHandler
    ```

- ### Middlewares

    ```
    php artisan make:middleware RequestTraceability
    ```
    
- ### Controllers

    ```
    php artisan make:controller Api/User/UserRegisterController
    php artisan make:controller Api/User/UserListController
    php artisan make:controller Api/User/UserController
    ```
- ### Responses

    ```
    php artisan make:class Core/ApiResponse
    php artisan make:resource UserResource
    ```

- ### Routes

    ```
    New-Item routes/api.php -ItemType File 
    ```

- ### Seeders

    - _Create_

        ```
        php artisan make:seeder RoleSeeder
        ```
    
    - _Execute_

        ```
        php artisan db:seed
        ```

- ### Execute

    ```
    php artisan serve  
    ```