<?php

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckDirectorRole;
use App\Http\Middleware\CheckEvaluatorRole;
use App\Http\Middleware\CheckLiderRole;
use App\Http\Middleware\CheckManagerRole;
use App\Http\Middleware\CheckStudentRole;
use App\Http\Middleware\CheckSuperAdminRole;
use App\Http\Middleware\CheckTeachernRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\RequestTraceability::class,
        ]);

        $middleware->alias([
            'role.admin' => CheckAdminRole::class,
            'role.director' => CheckDirectorRole::class,
            'role.evaluator' => CheckEvaluatorRole::class,
            'role.lider' => CheckLiderRole::class,
            'role.manager' => CheckManagerRole::class,
            'role.student' => CheckStudentRole::class,
            'role.super_admin' => CheckSuperAdminRole::class,
            'role.teacher' => CheckTeachernRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
