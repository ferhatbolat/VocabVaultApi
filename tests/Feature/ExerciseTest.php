<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Exercise;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExerciseTest extends TestCase
{
      use RefreshDatabase;

      public function test_can_get_all_exercises()
      {
            Exercise::factory()->count(3)->create();

            $response = $this->getJson('/api/v1/exercises');

            $response->assertStatus(200)
                  ->assertJsonCount(3);
      }

      public function test_can_create_exercise()
      {
            $word = Word::factory()->create();

            $data = [
                  'word_id' => $word->id,
                  'type' => 'multiple_choice',
                  'question' => 'What is the meaning of this word?',
                  'options' => ['Option 1', 'Option 2', 'Option 3', 'Option 4'],
                  'correct_answer' => 'Option 1'
            ];

            $response = $this->postJson('/api/v1/exercises', $data);

            $response->assertStatus(201)
                  ->assertJson([
                        'word_id' => $word->id,
                        'type' => 'multiple_choice',
                        'question' => 'What is the meaning of this word?',
                        'options' => ['Option 1', 'Option 2', 'Option 3', 'Option 4'],
                        'correct_answer' => 'Option 1'
                  ]);
      }

      public function test_can_update_exercise()
      {
            $exercise = Exercise::factory()->create();

            $data = [
                  'question' => 'Updated question',
                  'options' => ['New 1', 'New 2', 'New 3', 'New 4'],
                  'correct_answer' => 'New 1'
            ];

            $response = $this->putJson("/api/v1/exercises/{$exercise->id}", $data);

            $response->assertStatus(200)
                  ->assertJson([
                        'question' => 'Updated question',
                        'options' => ['New 1', 'New 2', 'New 3', 'New 4'],
                        'correct_answer' => 'New 1'
                  ]);
      }

      public function test_can_delete_exercise()
      {
            $exercise = Exercise::factory()->create();

            $response = $this->deleteJson("/api/v1/exercises/{$exercise->id}");

            $response->assertStatus(204);
            $this->assertSoftDeleted($exercise);
      }

      public function test_validates_required_fields_for_exercise()
      {
            $response = $this->postJson('/api/v1/exercises', []);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['word_id', 'type', 'question', 'options', 'correct_answer']);
      }

      public function test_validates_exercise_type()
      {
            $word = Word::factory()->create();

            $data = [
                  'word_id' => $word->id,
                  'type' => 'invalid_type',
                  'question' => 'Test question',
                  'options' => ['Option 1', 'Option 2', 'Option 3', 'Option 4'],
                  'correct_answer' => 'Option 1'
            ];

            $response = $this->postJson('/api/v1/exercises', $data);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['type']);
      }

      public function test_validates_options_array()
      {
            $word = Word::factory()->create();

            $data = [
                  'word_id' => $word->id,
                  'type' => 'multiple_choice',
                  'question' => 'Test question',
                  'options' => 'not_an_array',
                  'correct_answer' => 'Option 1'
            ];

            $response = $this->postJson('/api/v1/exercises', $data);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['options']);
      }

      public function test_validates_correct_answer_in_options()
      {
            $word = Word::factory()->create();

            $data = [
                  'word_id' => $word->id,
                  'type' => 'multiple_choice',
                  'question' => 'Test question',
                  'options' => ['Option 1', 'Option 2', 'Option 3', 'Option 4'],
                  'correct_answer' => 'Not in options'
            ];

            $response = $this->postJson('/api/v1/exercises', $data);

            $response->assertStatus(422)
                  ->assertJsonValidationErrors(['correct_answer']);
      }
}
