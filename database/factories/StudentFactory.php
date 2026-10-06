<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'school_id' => 1,
            'user_id' => null,
            'admission_no' => 'ADM-' . $this->faker->unique()->numerify('######'),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['MALE', 'FEMALE']),
            'date_of_birth' => $this->faker->dateTimeBetween('-16 years', '-5 years')->format('Y-m-d'),
            'address' => $this->faker->address(),
            'admission_date' => now()->subDays(rand(10, 300))->format('Y-m-d'),
            'status' => 'ADMITTED',
        ];
    }
}
