<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('faculty_id')->nullable()->constrained('faculties')->onDelete('set null');
            $table->foreignUuid('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name', 150);
            $table->string('reference', 50)->unique();
            $table->enum('type_program', ['PREGRADO', 'POSTGRADO']);
            $table->unsignedSmallInteger('number_semesters');
            $table->unsignedSmallInteger('number_credits');
            $table->string('description', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
