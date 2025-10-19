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
    php artisan make:controller Api/UserRole/ListUserRoleController
    php artisan make:controller Api/Auth/LoginController
    php artisan make:controller Api/Auth/LogoutController
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
    php artisan make:class Application/Handlers/UserRole/ListUserRole/ListUserRoleHandler
    php artisan make:class Application/Handlers/Auth/LoginHandler
    ```

-   ### Middlewares

    ```
    php artisan make:middleware RequestTraceability
    php artisan make:middleware CheckSuperAdminRole
    php artisan make:middleware CheckAdminRole
    php artisan make:middleware CheckDirectorRole
    php artisan make:middleware CheckManagerRole
    php artisan make:middleware CheckLiderRole
    php artisan make:middleware CheckTeachernRole
    php artisan make:middleware CheckEvaluatorRole
    php artisan make:middleware CheckStudentRole
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
    php artisan make:request Auth/LoginRequest
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
    php artisan make:resource Auth/AuthResource
    ```

-   ### Routes

    ```
    New-Item routes/api.php -ItemType File
    New-Item routes/user.php -ItemType File
    New-Item routes/role.php -ItemType File
    New-Item routes/user_role.php -ItemType File
    New-Item routes/auth.php -ItemType File
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
