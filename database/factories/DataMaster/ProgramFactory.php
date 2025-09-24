<?php

namespace Database\Factories\DataMaster;

use App\Models\DataMaster\Department;
use App\Models\DataMaster\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Program::class;
    public function definition(): array
    {
        $randDepart = Department::inRandomOrder()->first();

        return [
            'id' => $this->faker->uuid(),
            'department_id' => $randDepart ? $randDepart->id : null,
            'code' => $this->faker->unique()->lexify('???'),
            'name' => $this->faker->unique()->name(),

            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
