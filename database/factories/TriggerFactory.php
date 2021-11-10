<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Trigger;
use Illuminate\Database\Eloquent\Factories\Factory;

class TriggerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trigger::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "wire" => $this->faker->randomDigit(),
            "trigger_voltage" => $this->faker->boolean(),
            "device_id" => Device::factory()->create()->id,
        ];
    }
}
