<?php

namespace Database\Factories;

use App\Models\Trigger;
use App\Models\TriggerLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TriggerLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TriggerLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trigger_id' => Trigger::factory()->create()->id,
        ];
    }
}
