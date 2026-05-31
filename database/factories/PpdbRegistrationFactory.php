<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PpdbRegistration> */
class PpdbRegistrationFactory extends Factory
{
    protected $model = PpdbRegistration::class;

    public function definition(): array
    {
        return [
            'registration_number' => PpdbRegistration::generateNumber(),
            'spmb_banten_number'  => fake()->unique()->numerify('360##########'),
            'major_id'            => Major::query()->value('id'),
            'full_name'           => fake()->name(),
            'nisn'                => fake()->unique()->numerify('##########'),
            'gender'              => fake()->randomElement(['L', 'P']),
            'form_status'         => 'submitted',
            'status'              => 'pending',
            'draft_token'         => fake()->uuid(),
        ];
    }
}
