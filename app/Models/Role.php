<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // ⬅️ Añadido
        'description', // ⬅️ Añadido
    ];
    
    public function users(): BelongsToMany
    {
        // El método automáticamente busca la tabla pivote 'role_user'
        return $this->belongsToMany(User::class);
    }
}
