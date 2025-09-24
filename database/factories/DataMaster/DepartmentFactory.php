<?php

namespace Database\Factories\DataMaster;

use App\Models\DataMaster\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'code' => $this->faker->unique()->lexify('???'),
            'name' => $this->faker->unique()->name(),

            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
