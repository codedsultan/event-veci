<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = fake()->name(),
            'user_id' => User::factory(),
            'slug' => Str::slug($name),
            'desc' => fake()->paragraph(),
            'strtdt' => now()->addDays(30)->toDateString(),
            'strttm' => '12:00',
            'enddt' => now()->addDays(35)->toDateString(),
            'endtm' => '16:00',
            'location' => fake()->city(),
            'venue' => fake()->company(),
            'topic_id' => Topic::factory(),
            'price' => 100,
            'qty' => 100,
            'image_path' => storage_path('event/placeholder.jpg')
        ];
    }
}
