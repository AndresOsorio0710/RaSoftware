# RaSoftware

## Comans

-   ### Commands

    ```
    php artisan make:class Application/Commands/User/RegisterUser/RegisterUserCommand
    ```

-   ### Controllers

    ```
    php artisan make:controller Api/User/UserRegisterController
    php artisan make:controller Api/User/UserListController
    php artisan make:controller Api/User/UserController
    php artisan make:controller Api/User/UserUpdateController
    php artisan make:controller Api/Role/CreateRoleController
    php artisan make:controller Api/Role/ListRoleController
    php artisan make:controller Api/Role/GetRoleController
    php artisan make:controller Api/Role/UpdateRoleController
    php artisan make:controller Api/UserRole/CreateUserRoleController
    php artisan make:controller Api/UserRole/DeleteUserRoleController
    ```

-   ### Create project

    ```
    composer create-project laravel/laravel RaSoftware
    ```

-   ### Directories

    ```
    mkdir -p app/Application/Commands
    mkdir -p app/Core
    ```

-   ### Execute

    ```
    php artisan serve
    ```

-   ### Handlers

    ```
    php artisan make:class Application/Handlers/User/RegisterUser/RegisterUserHandler
    php artisan make:class Application/Handlers/User/GetAllUsers/GetAllUsersHandler
    php artisan make:class Application/Handlers/User/GetUser/GetUserHandler
    php artisan make:class Application/Handlers/User/UpdateUser/UpdateUserHandler
    php artisan make:class Application/Handlers/Role/CreateRole/CreateRoleHandler
    php artisan make:class Application/Handlers/Role/ListRole/ListRoleHandler
    php artisan make:class Application/Handlers/Role/GetRole/GetRoleHandler
    php artisan make:class Application/Handlers/Role/UpdateRole/UpdateRoleHandler
    php artisan make:class Application/Handlers/UserRole/CreateUserRole/CreateUserRoleHandler
    php artisan make:class Application/Handlers/UserRole/DeleteUserRole/DeleteUserRoleHandler
    ```

-   ### Middlewares

    ```
    php artisan make:middleware RequestTraceability
    ```

-   ### Migrate

    _Apply pending migrations_

    ```
    php artisan migrate
    ```

    _Aplicar migraciones desde cero_

    ```
    php artisan migrate:fresh
    ```

-   ### Models

    _Role_

    ```
    php artisan make:model Role -m
    ```

    _Role User_

    ```
    php artisan make:migration create_role_user_table --create=role_user
    ```

-   ### Queries

    ```
    php artisan make:class Application/Queries/User/GetAllUsers/GetAllUsersQuery
    ```

-   ### Requests

    ```
    php artisan make:request RegisterUserRequest
    php artisan make:request UpdateUserRequest
    php artisan make:request Role/CreateRoleRequest
    php artisan make:request Role/UpdateRoleRequest
    php artisan make:request UserRole/CreateUserRoleRequest
    ```

-   ### Requires

    -   Laravel Sanctum

        _Intale_

        ```
        composer require laravel/sanctum
        ```

        _Configure_

        ```
        php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
        ```

-   ### Responses

    ```
    php artisan make:class Core/ApiResponse
    php artisan make:resource UserResource
    php artisan make:resource Role/RoleResource
    ```

-   ### Routes

    ```
    New-Item routes/api.php -ItemType File
    New-Item routes/user.php -ItemType File
    New-Item routes/role.php -ItemType File
    New-Item routes/user_role.php -ItemType File
    ```

-   ### Seeders

    -   _Create_

        ```
        php artisan make:seeder RoleSeeder
        ```

    -   _Execute_

        ```
        php artisan db:seed
        ```
