<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->nullable()->constrained('programs')->onDelete('set null');
            $table->string('reference', 50)->unique();
            $table->string('name', 150)->default('NO SUMINISTRADO');
            $table->unsignedSmallInteger('period_number')->default(1);
            $table->date('start_at')->comment('Fecha de inicio del periodo.');
            $table->date('end_at')->comment('Fecha de fin del periodo.');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE periods ADD CONSTRAINT periods_period_number_max_check CHECK (period_number <= 15)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
