<?php

namespace App\Application\Handlers\Program\UpdateProgram;

use App\Core\ApiResponse;
use App\Http\Resources\Program\ProgramResource;
use App\Models\Program;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UpdateProgramHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica para actualizar un programa existente.
     *
     * @param string $id El UUID del programa a actualizar.
     * @param array $data Los datos validados para la actualización.
     * @return JsonResponse
     */
    public function handler(string $id, array $data): JsonResponse
    {
        if (!Str::isUuid($id)) {
            Log::info("El formato del identificador proporcionado ($id) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }

        try {
            $program = Program::findOrFail($id);

            $program->manager_id = $data['manager_id'];
            $program->name = $data['name'];
            $program->description = $data['description'];
            $program->number_semesters = $data['number_semesters'];
            $program->number_credits = $data['number_credits'];
            $program->save();

            $program->refresh()->load(['faculty', 'manager']);

            $response = new ProgramResource($program);

            Log::info('Programa actualizado con éxito.', ['id' => $id, 'name' => $program->name]);

            return ApiResponse::success(
                $response,
                "Programa actualizado con éxito."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Programa con UUID:$id, no encontrado.", ['id' => $id]);
            return ApiResponse::errorNotFound("No se encontraron datos del programa.");
        } catch (InvalidArgumentException $e) {
            Log::error('Error por argumentos inválidos durante la actualización.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::errorConflict("Error por argumentos inválidos.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al actualizar programa.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al actualizar programa.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado durante la actualización del programa.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado.");
        }
    }
}
