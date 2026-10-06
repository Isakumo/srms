<?php

namespace Database\Factories;

use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition(): array
    {
        return [
            'school_id' => 1,
            'user_id' => null,
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'alternate_phone' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->optional()->safeEmail(),
            'address' => $this->faker->address(),
            'occupation' => $this->faker->jobTitle(),
            'status' => 'ACTIVE',
        ];
    }
}
