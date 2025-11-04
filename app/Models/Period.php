<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Period extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'reference',
        'name',
        'period_number',
        'start_at',
        'end_at',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    protected function reference(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value),
        );
    }
}
