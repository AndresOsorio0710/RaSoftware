<?php

namespace Database\Seeders;

use App\Models\Period;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        if ($currentMonth >= 7) {
            $periodNumber = 2;
            $semesterName = 'SEGUNDO SEMESTRE';
            $startAt = Carbon::create($currentYear, 8, 1);
            $endAt = Carbon::create($currentYear, 12, 31);
        } else {
            $periodNumber = 1;
            $semesterName = 'PRIMER SEMESTRE';
            $startAt = Carbon::create($currentYear, 1, 1);
            $endAt = Carbon::create($currentYear, 6, 30);
        }

        $program = Program::first();

        $reference = "{$currentYear}-{$periodNumber}";
        $name = "{$semesterName} {$currentYear}";

        $period = Period::firstOrCreate(
            ['reference' => $reference],
            [
                'program_id' => $program->id,
                'name' => $name,
                'period_number' => $periodNumber,
                'start_at' => $startAt,
                'end_at' => $endAt,
            ]
        );

        $this->command->info("Periodo creado o existente: {$period->reference} - {$period->name}");
    }
}
