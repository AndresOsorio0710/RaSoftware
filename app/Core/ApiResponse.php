<?php

namespace App\Core;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * Respuesta genérica de éxito (200 OK, 201 Created, etc.).
     */
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Respuesta genérica de login éxitoso (200 OK).
     */
    public static function authSuccess(
        mixed $data = null,
        string $accessToken = '',
        string $message = 'Success'
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'access_token' => $accessToken,
            'message' => $message,
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public static function unauthorized(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => "No autorizado",
            'data' => null,
        ], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * Respuesta genérica de error (300 OK, 600 Internal Server Error, etc.).
     */
    public static function error(
        mixed $data = null,
        string $message = 'Internal Server Error',
        int $status = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Respuesta para recursos creados (201 Created).
     */
    public static function created(
        mixed $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return self::success($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Respuesta de error de validación (422 Unprocessable Content).
     */
    public static function errorValidation(
        mixed $errors,
        string $message = 'The given data was invalid'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Respuesta de error de conflicto de negocio (409 Conflict).
     */
    public static function errorConflict(string $message = 'Resource conflict'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], Response::HTTP_CONFLICT);
    }

    /**
     * Respuesta de error genérica del cliente (400 Bad Request).
     */
    public static function errorBadRequest(string $message = 'Bad request'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], Response::HTTP_BAD_REQUEST);
    }

    /*
    **
     * Respuesta de error genérica del cliente (404 Not Found).
     */
    public static function errorNotFound(string $message = 'Not Found'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], Response::HTTP_NOT_FOUND);
    }

    /*
    **
     * Respuesta de error genérica del cliente (500 Not Found).
     */
    public static function internalServerError(string $message = 'Internal Server Error'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
