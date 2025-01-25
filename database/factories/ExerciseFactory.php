<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
      protected $model = Exercise::class;

      public function definition()
      {
            $options = [
                  $this->faker->unique()->word(),
                  $this->faker->unique()->word(),
                  $this->faker->unique()->word(),
                  $this->faker->unique()->word()
            ];

            return [
                  'word_id' => Word::factory(),
                  'type' => $this->faker->randomElement(['multiple_choice', 'writing', 'matching']),
                  'question' => $this->faker->sentence() . '?',
                  'options' => $options,
                  'correct_answer' => $options[0]
            ];
      }
}
